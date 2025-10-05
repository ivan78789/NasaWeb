<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

require_once __DIR__ . '/../../config/db.php';

// Получаем параметры
$query = $_GET['q'] ?? 'disaster weather climate';
$language = $_GET['lang'] ?? 'ru';
$pageSize = (int)($_GET['pageSize'] ?? 20);
$page = (int)($_GET['page'] ?? 1);
$category = $_GET['category'] ?? '';

// News API ключ (замените на ваш)
$apiKey = 'YOUR_NEWS_API_KEY_HERE';
$baseUrl = 'https://newsapi.org/v2/everything';

// Параметры запроса
$params = [
    'q' => $query,
    'language' => $language,
    'pageSize' => $pageSize,
    'page' => $page,
    'sortBy' => 'publishedAt',
    'apiKey' => $apiKey
];

// Добавляем категорию если указана
if ($category) {
    $params['q'] .= ' AND (' . $category . ')';
}

// Формируем URL
$url = $baseUrl . '?' . http_build_query($params);

try {
    // Если API ключ не настроен, возвращаем тестовые данные
    if ($apiKey === 'YOUR_NEWS_API_KEY_HERE') {
        $testData = generateTestNewsData($pageSize);
        echo json_encode([
            'status' => 'success',
            'totalResults' => $pageSize,
            'articles' => $testData
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }
    
    // Получаем данные от News API
    $context = stream_context_create([
        'http' => [
            'timeout' => 10,
            'user_agent' => 'DisasterAlert/1.0'
        ]
    ]);
    
    $response = file_get_contents($url, false, $context);
    
    if ($response === false) {
        throw new Exception('Ошибка получения данных от News API');
    }
    
    $data = json_decode($response, true);
    
    if (isset($data['status']) && $data['status'] === 'error') {
        throw new Exception($data['message'] ?? 'Ошибка News API');
    }
    
    // Обрабатываем статьи
    $articles = [];
    if (isset($data['articles'])) {
        foreach ($data['articles'] as $article) {
            $articles[] = [
                'id' => md5($article['url'] ?? uniqid()),
                'title' => $article['title'] ?? '',
                'description' => $article['description'] ?? '',
                'url' => $article['url'] ?? '',
                'urlToImage' => $article['urlToImage'] ?? '',
                'publishedAt' => $article['publishedAt'] ?? date('Y-m-d\TH:i:s\Z'),
                'source' => $article['source']['name'] ?? 'Unknown',
                'category' => determineCategory($article['title'] ?? '', $article['description'] ?? ''),
                'language' => $language
            ];
        }
    }
    
    // Сохраняем в базу данных для кеширования
    saveNewsToDatabase($articles);
    
    echo json_encode([
        'status' => 'success',
        'totalResults' => $data['totalResults'] ?? count($articles),
        'articles' => $articles
    ], JSON_UNESCAPED_UNICODE);
    
} catch (Exception $e) {
    // В случае ошибки возвращаем кешированные данные
    $cachedNews = getCachedNews($query, $pageSize);
    
    if (!empty($cachedNews)) {
        echo json_encode([
            'status' => 'success',
            'totalResults' => count($cachedNews),
            'articles' => $cachedNews,
            'cached' => true
        ], JSON_UNESCAPED_UNICODE);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Ошибка получения новостей: ' . $e->getMessage()
        ], JSON_UNESCAPED_UNICODE);
    }
}

// Определение категории новости
function determineCategory($title, $description) {
    $text = strtolower($title . ' ' . $description);
    
    if (strpos($text, 'earthquake') !== false || strpos($text, 'землетрясение') !== false) {
        return 'earthquake';
    } elseif (strpos($text, 'fire') !== false || strpos($text, 'пожар') !== false) {
        return 'fire';
    } elseif (strpos($text, 'flood') !== false || strpos($text, 'наводнение') !== false) {
        return 'flood';
    } elseif (strpos($text, 'storm') !== false || strpos($text, 'шторм') !== false) {
        return 'storm';
    } elseif (strpos($text, 'volcano') !== false || strpos($text, 'вулкан') !== false) {
        return 'volcano';
    } elseif (strpos($text, 'climate') !== false || strpos($text, 'климат') !== false) {
        return 'climate';
    } elseif (strpos($text, 'space') !== false || strpos($text, 'космос') !== false) {
        return 'space';
    } else {
        return 'general';
    }
}

// Сохранение новостей в базу данных
function saveNewsToDatabase($articles) {
    global $conn;
    
    foreach ($articles as $article) {
        try {
            // Проверяем, есть ли уже такая новость
            $check_sql = "SELECT id FROM news_items WHERE source_url = ?";
            $check_stmt = $conn->prepare($check_sql);
            $check_stmt->execute([$article['url']]);
            
            if ($check_stmt->fetch()) {
                continue; // Уже есть в базе
            }
            
            // Сохраняем новость
            $insert_sql = "INSERT INTO news_items (source, title_en, summary_en, source_url, media_url, published_at, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_sql);
            $insert_stmt->execute([
                'newsapi',
                $article['title'],
                $article['description'],
                $article['url'],
                $article['urlToImage'],
                date('Y-m-d H:i:s', strtotime($article['publishedAt'])),
                date('Y-m-d H:i:s')
            ]);
            
        } catch (Exception $e) {
            error_log('Ошибка сохранения новости: ' . $e->getMessage());
        }
    }
}

// Получение кешированных новостей
function getCachedNews($query, $limit) {
    global $conn;
    
    try {
        $sql = "SELECT * FROM news_items WHERE source = 'newsapi' ORDER BY published_at DESC LIMIT ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$limit]);
        $news = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $articles = [];
        foreach ($news as $item) {
            $articles[] = [
                'id' => $item['id'],
                'title' => $item['title_en'] ?? $item['title_ru'] ?? '',
                'description' => $item['summary_en'] ?? $item['summary_ru'] ?? '',
                'url' => $item['source_url'] ?? '',
                'urlToImage' => $item['media_url'] ?? '',
                'publishedAt' => $item['published_at'] ?? '',
                'source' => 'NewsAPI',
                'category' => 'general',
                'language' => 'en'
            ];
        }
        
        return $articles;
        
    } catch (Exception $e) {
        error_log('Ошибка получения кешированных новостей: ' . $e->getMessage());
        return [];
    }
}

// Генерация тестовых данных
function generateTestNewsData($count) {
    $testNews = [
        [
            'title' => 'Климатические изменения: новые данные о глобальном потеплении',
            'description' => 'Ученые представили новые данные о влиянии климатических изменений на планету.',
            'url' => '#',
            'urlToImage' => '',
            'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-1 hour')),
            'source' => 'Climate News',
            'category' => 'climate'
        ],
        [
            'title' => 'Землетрясение магнитудой 5.2 в Тихом океане',
            'description' => 'Геологическая служба США зафиксировала землетрясение в Тихом океане.',
            'url' => '#',
            'urlToImage' => '',
            'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-2 hours')),
            'source' => 'USGS',
            'category' => 'earthquake'
        ],
        [
            'title' => 'Лесные пожары в Калифорнии: ситуация под контролем',
            'description' => 'Пожарные службы сообщают о стабилизации ситуации с лесными пожарами.',
            'url' => '#',
            'urlToImage' => '',
            'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-3 hours')),
            'source' => 'Fire Department',
            'category' => 'fire'
        ],
        [
            'title' => 'Новые спутниковые данные о состоянии атмосферы',
            'description' => 'NASA опубликовала новые данные о состоянии атмосферы Земли.',
            'url' => '#',
            'urlToImage' => '',
            'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-4 hours')),
            'source' => 'NASA',
            'category' => 'space'
        ],
        [
            'title' => 'Прогноз погоды: экстремальные температуры ожидаются',
            'description' => 'Метеорологи предупреждают о возможных экстремальных температурах.',
            'url' => '#',
            'urlToImage' => '',
            'publishedAt' => date('Y-m-d\TH:i:s\Z', strtotime('-5 hours')),
            'source' => 'Weather Service',
            'category' => 'weather'
        ]
    ];
    
    return array_slice($testNews, 0, $count);
}
?>
