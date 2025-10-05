<?php
/**
 * NASA EONET API Integration
 * Получает данные о природных катастрофах с NASA EONET API
 */

class EONETService {
    private $conn;
    private $api_url = 'https://eonet.gsfc.nasa.gov/api/v3/events';
    
    public function __construct($database_connection) {
        $this->conn = $database_connection;
    }
    
    /**
     * Получить все активные события
     */
    public function getActiveEvents($limit = 50) {
        try {
            $url = $this->api_url . '?limit=' . $limit;
            $data = file_get_contents($url);
            $events = json_decode($data, true);
            
            if (!$events || !isset($events['events'])) {
                return [];
            }
            
            return $events['events'];
            
        } catch (Exception $e) {
            error_log('EONET API Error: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Получить события по категориям
     */
    public function getEventsByCategory($categories = []) {
        try {
            $url = $this->api_url;
            if (!empty($categories)) {
                $url .= '?category=' . implode(',', $categories);
            }
            
            $data = file_get_contents($url);
            $events = json_decode($data, true);
            
            if (!$events || !isset($events['events'])) {
                return [];
            }
            
            return $events['events'];
            
        } catch (Exception $e) {
            error_log('EONET Category API Error: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Получить события в радиусе от координат
     */
    public function getEventsInRadius($lat, $lon, $radius_km = 1000) {
        try {
            $url = $this->api_url . '?limit=100';
            $data = file_get_contents($url);
            $events = json_decode($data, true);
            
            if (!$events || !isset($events['events'])) {
                return [];
            }
            
            $filtered_events = [];
            foreach ($events['events'] as $event) {
                if (isset($event['geometry']) && is_array($event['geometry'])) {
                    foreach ($event['geometry'] as $geometry) {
                        if (isset($geometry['coordinates'])) {
                            $coords = $geometry['coordinates'];
                            if (count($coords) >= 2) {
                                $event_lat = $coords[1];
                                $event_lon = $coords[0];
                                
                                $distance = $this->calculateDistance($lat, $lon, $event_lat, $event_lon);
                                
                                if ($distance <= $radius_km) {
                                    $filtered_events[] = [
                                        'event' => $event,
                                        'distance' => $distance
                                    ];
                                }
                            }
                        }
                    }
                }
            }
            
            // Сортируем по расстоянию
            usort($filtered_events, function($a, $b) {
                return $a['distance'] <=> $b['distance'];
            });
            
            return array_slice($filtered_events, 0, 20); // Возвращаем ближайшие 20
            
        } catch (Exception $e) {
            error_log('EONET Radius API Error: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Сохранить события в базу данных
     */
    public function saveEventsToDatabase($events) {
        if (empty($events)) {
            return 0;
        }
        
        $saved = 0;
        foreach ($events as $event) {
            try {
                // Проверяем, есть ли уже такое событие
                $check_sql = "SELECT id FROM alerts WHERE source = 'eonet' AND properties->>'eonet_id' = ?";
                $check_stmt = $this->conn->prepare($check_sql);
                $check_stmt->execute([$event['id']]);
                
                if ($check_stmt->fetch()) {
                    continue; // Уже есть в базе
                }
                
                // Определяем тип события
                $type = $this->mapEONETType($event['categories'][0]['id'] ?? 0);
                $severity = $this->determineSeverity($event);
                
                // Получаем координаты (берем первую геометрию)
                $coords = null;
                if (isset($event['geometry']) && is_array($event['geometry'])) {
                    $first_geometry = $event['geometry'][0];
                    if (isset($first_geometry['coordinates'])) {
                        $coords = $first_geometry['coordinates'];
                    }
                }
                
                if (!$coords || count($coords) < 2) {
                    continue; // Пропускаем события без координат
                }
                
                // Радиус воздействия
                $radius_km = $this->getEventRadius($type, $severity);
                
                // Создаем сообщения на разных языках
                $title = $event['title'] ?? 'Природное событие';
                $message_ru = $this->translateMessage($title, 'ru');
                $message_en = $title;
                $message_kg = $this->translateMessage($title, 'kg');
                
                // Сохраняем в базу
                $insert_sql = "INSERT INTO alerts (source, type, severity, latitude, longitude, radius_km, message_ru, message_en, message_kg, properties, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $insert_stmt = $this->conn->prepare($insert_sql);
                $insert_stmt->execute([
                    'eonet',
                    $type,
                    $severity,
                    $coords[1], // latitude
                    $coords[0], // longitude
                    $radius_km,
                    $message_ru,
                    $message_en,
                    $message_kg,
                    json_encode($event),
                    date('Y-m-d H:i:s', strtotime($event['lastDate'] ?? 'now'))
                ]);
                
                $saved++;
                
            } catch (Exception $e) {
                error_log('Error saving EONET event: ' . $e->getMessage());
            }
        }
        
        return $saved;
    }
    
    /**
     * Маппинг типов EONET на наши типы
     */
    private function mapEONETType($category_id) {
        $type_map = [
            6 => 'drought',      // Drought
            8 => 'dust',         // Dust and Haze
            9 => 'earthquake',   // Earthquakes
            10 => 'floods',      // Floods
            12 => 'landslides', // Landslides
            13 => 'manmade',    // Manmade
            14 => 'sea',        // Sea and Lake Ice
            15 => 'snow',      // Severe Storms
            16 => 'temperature', // Temperature Extremes
            17 => 'volcanoes',   // Volcanoes
            18 => 'water',      // Water Color
            19 => 'wildfires'   // Wildfires
        ];
        
        return $type_map[$category_id] ?? 'other';
    }
    
    /**
     * Определение серьезности события
     */
    private function determineSeverity($event) {
        // Простая логика определения серьезности
        $title = strtolower($event['title'] ?? '');
        
        if (strpos($title, 'major') !== false || strpos($title, 'severe') !== false) {
            return 'critical';
        } elseif (strpos($title, 'moderate') !== false || strpos($title, 'warning') !== false) {
            return 'warning';
        } elseif (strpos($title, 'minor') !== false || strpos($title, 'advisory') !== false) {
            return 'advisory';
        } else {
            return 'info';
        }
    }
    
    /**
     * Получение радиуса воздействия события
     */
    private function getEventRadius($type, $severity) {
        $base_radius = [
            'earthquake' => 50,
            'volcanoes' => 100,
            'wildfires' => 25,
            'floods' => 30,
            'drought' => 200,
            'other' => 20
        ];
        
        $radius = $base_radius[$type] ?? 20;
        
        // Увеличиваем радиус в зависимости от серьезности
        switch ($severity) {
            case 'critical':
                return $radius * 2;
            case 'warning':
                return $radius * 1.5;
            case 'advisory':
                return $radius;
            case 'info':
                return $radius * 0.5;
            default:
                return $radius;
        }
    }
    
    /**
     * Простой перевод сообщений
     */
    private function translateMessage($text, $lang) {
        // В реальном проекте здесь должен быть полноценный переводчик
        $translations = [
            'ru' => [
                'earthquake' => 'Землетрясение',
                'volcano' => 'Вулканическая активность',
                'fire' => 'Пожар',
                'flood' => 'Наводнение',
                'drought' => 'Засуха',
                'storm' => 'Шторм'
            ],
            'kg' => [
                'earthquake' => 'Жер титирөө',
                'volcano' => 'Вулкан активдүүлүгү',
                'fire' => 'Өрт',
                'flood' => 'Суу ташкыны',
                'drought' => 'Кургакчылык',
                'storm' => 'Шторм'
            ]
        ];
        
        if ($lang === 'en') {
            return $text;
        }
        
        $lower_text = strtolower($text);
        foreach ($translations[$lang] ?? [] as $en => $translated) {
            if (strpos($lower_text, $en) !== false) {
                return $translated;
            }
        }
        
        return $text; // Возвращаем оригинал, если перевод не найден
    }
    
    /**
     * Расчет расстояния между двумя точками
     */
    private function calculateDistance($lat1, $lon1, $lat2, $lon2) {
        $earth_radius = 6371; // Радиус Земли в км
        
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);
        
        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * atan2(sqrt($a), sqrt(1-$a));
        
        return $earth_radius * $c;
    }
    
    /**
     * Обновить события EONET
     */
    public function updateEvents() {
        $events = $this->getActiveEvents(100);
        $saved = $this->saveEventsToDatabase($events);
        
        return [
            'total' => count($events),
            'saved' => $saved
        ];
    }
}
?>
