<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once __DIR__ . '/../../config/db.php';
require_once __DIR__ . '/../../include/eonet.php';

// Получаем параметры запроса
$lat = $_GET['lat'] ?? null;
$lon = $_GET['lon'] ?? null;
$radius = $_GET['radius'] ?? 1000; // радиус в км
$categories = $_GET['categories'] ?? '';
$limit = (int)($_GET['limit'] ?? 50);

try {
    $eonet = new EONETService($conn);
    
    // Если указаны координаты, ищем события в радиусе
    if ($lat && $lon) {
        $events = $eonet->getEventsInRadius($lat, $lon, $radius);
        
        // Формируем GeoJSON
        $features = [];
        foreach ($events as $event_data) {
            $event = $event_data['event'];
            $distance = $event_data['distance'];
            
            // Получаем координаты из первой геометрии
            $coords = null;
            if (isset($event['geometry']) && is_array($event['geometry'])) {
                $first_geometry = $event['geometry'][0];
                if (isset($first_geometry['coordinates'])) {
                    $coords = $first_geometry['coordinates'];
                }
            }
            
            if ($coords && count($coords) >= 2) {
                $features[] = [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => $coords
                    ],
                    'properties' => [
                        'id' => $event['id'],
                        'title' => $event['title'],
                        'type' => $eonet->mapEONETType($event['categories'][0]['id'] ?? 0),
                        'severity' => $eonet->determineSeverity($event),
                        'distance' => round($distance, 2),
                        'source' => 'eonet',
                        'categories' => $event['categories'],
                        'lastDate' => $event['lastDate'],
                        'created_at' => $event['lastDate']
                    ]
                ];
            }
        }
        
        // Сортируем по расстоянию
        usort($features, function($a, $b) {
            return $a['properties']['distance'] <=> $b['properties']['distance'];
        });
        
        // Ограничиваем количество
        $features = array_slice($features, 0, $limit);
        
    } else {
        // Получаем все активные события
        $events = $eonet->getActiveEvents($limit);
        
        $features = [];
        foreach ($events as $event) {
            // Получаем координаты из первой геометрии
            $coords = null;
            if (isset($event['geometry']) && is_array($event['geometry'])) {
                $first_geometry = $event['geometry'][0];
                if (isset($first_geometry['coordinates'])) {
                    $coords = $first_geometry['coordinates'];
                }
            }
            
            if ($coords && count($coords) >= 2) {
                $features[] = [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => $coords
                    ],
                    'properties' => [
                        'id' => $event['id'],
                        'title' => $event['title'],
                        'type' => $eonet->mapEONETType($event['categories'][0]['id'] ?? 0),
                        'severity' => $eonet->determineSeverity($event),
                        'source' => 'eonet',
                        'categories' => $event['categories'],
                        'lastDate' => $event['lastDate'],
                        'created_at' => $event['lastDate']
                    ]
                ];
            }
        }
    }
    
    // Фильтруем по категориям, если указаны
    if ($categories) {
        $category_list = explode(',', $categories);
        $features = array_filter($features, function($feature) use ($category_list) {
            $event_type = $feature['properties']['type'];
            return in_array($event_type, $category_list);
        });
    }
    
    $response = [
        'type' => 'FeatureCollection',
        'features' => $features,
        'metadata' => [
            'total' => count($features),
            'source' => 'NASA EONET',
            'generated_at' => date('Y-m-d H:i:s')
        ]
    ];
    
    echo json_encode($response, JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    echo json_encode([
        'type' => 'FeatureCollection',
        'features' => [],
        'error' => 'Ошибка получения данных EONET: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
?>
