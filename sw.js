// Service Worker для PWA функциональности
const CACHE_NAME = 'disaster-alert-v1';
const urlsToCache = [
    '/',
    '/news',
    '/map',
    '/weather',
    '/about',
    '/visualization',
    '/assets/css/style.css',
    '/assets/js/app.js',
    'https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css',
    'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css',
    'https://unpkg.com/leaflet@1.9.4/dist/leaflet.css',
    'https://unpkg.com/leaflet@1.9.4/dist/leaflet.js',
    'https://cdn.jsdelivr.net/npm/chart.js'
];

// Установка Service Worker
self.addEventListener('install', function (event) {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(function (cache) {
                console.log('Кеширование файлов');
                return cache.addAll(urlsToCache);
            })
    );
});

// Активация Service Worker
self.addEventListener('activate', function (event) {
    event.waitUntil(
        caches.keys().then(function (cacheNames) {
            return Promise.all(
                cacheNames.map(function (cacheName) {
                    if (cacheName !== CACHE_NAME) {
                        console.log('Удаление старого кеша:', cacheName);
                        return caches.delete(cacheName);
                    }
                })
            );
        })
    );
});

// Перехват запросов
self.addEventListener('fetch', function (event) {
    event.respondWith(
        caches.match(event.request)
            .then(function (response) {
                // Возвращаем кешированную версию или загружаем из сети
                if (response) {
                    return response;
                }

                return fetch(event.request).then(function (response) {
                    // Проверяем, что получили валидный ответ
                    if (!response || response.status !== 200 || response.type !== 'basic') {
                        return response;
                    }

                    // Клонируем ответ для кеширования
                    const responseToCache = response.clone();

                    caches.open(CACHE_NAME)
                        .then(function (cache) {
                            cache.put(event.request, responseToCache);
                        });

                    return response;
                });
            })
    );
});

// Обработка push уведомлений
self.addEventListener('push', function (event) {
    console.log('Получено push уведомление:', event);

    const options = {
        body: 'Новое событие обнаружено в вашем регионе',
        icon: '/icon-192x192.png',
        badge: '/badge-72x72.png',
        vibrate: [100, 50, 100],
        data: {
            dateOfArrival: Date.now(),
            primaryKey: 1
        },
        actions: [
            {
                action: 'explore',
                title: 'Посмотреть на карте',
                icon: '/icon-192x192.png'
            },
            {
                action: 'close',
                title: 'Закрыть',
                icon: '/icon-192x192.png'
            }
        ]
    };

    if (event.data) {
        const data = event.data.json();
        options.body = data.body || options.body;
        options.title = data.title || 'Disaster Alert';
    }

    event.waitUntil(
        self.registration.showNotification('Disaster Alert', options)
    );
});

// Обработка кликов по уведомлениям
self.addEventListener('notificationclick', function (event) {
    console.log('Клик по уведомлению:', event);

    event.notification.close();

    if (event.action === 'explore') {
        // Открываем карту
        event.waitUntil(
            clients.openWindow('/map')
        );
    } else if (event.action === 'close') {
        // Просто закрываем уведомление
        return;
    } else {
        // Открываем главную страницу
        event.waitUntil(
            clients.openWindow('/')
        );
    }
});

// Фоновая синхронизация
self.addEventListener('sync', function (event) {
    if (event.tag === 'background-sync') {
        console.log('Фоновая синхронизация');
        event.waitUntil(doBackgroundSync());
    }
});

// Функция фоновой синхронизации
function doBackgroundSync() {
    return fetch('/api/alerts')
        .then(response => response.json())
        .then(data => {
            console.log('Синхронизация данных:', data);
            // Здесь можно обновить локальные данные
        })
        .catch(error => {
            console.error('Ошибка синхронизации:', error);
        });
}

// Обработка сообщений от основного потока
self.addEventListener('message', function (event) {
    if (event.data && event.data.type === 'SKIP_WAITING') {
        self.skipWaiting();
    }
});
