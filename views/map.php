<?php 
require_once __DIR__ . '/../config/db.php';

$TitleName = "Disaster Alert / TerraAlert - Карта рисков";
?>

<?php require_once __DIR__ . '/../layout/header.php' ?>
<?php require_once __DIR__ . '/../layout/nav.php' ?>

<div class="container-fluid">
    <!-- Заголовок страницы -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="hero-section">
                <h1 class="display-4 fw-bold text-center mb-3">
                    <i class="bi bi-map me-3"></i>
                    <span class="translatable">Интерактивная карта рисков</span>
                </h1>
                <p class="lead text-center text-muted">
                    <span class="translatable">Мониторинг природных катастроф в реальном времени</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Панель управления -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="bi bi-sliders me-2"></i>
                                <span class="translatable">Фильтры и настройки</span>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-wrap gap-2">
                                <!-- Фильтр по типу событий -->
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-outline-danger btn-sm" data-type="earthquake">
                                        <i class="bi bi-circle-fill me-1"></i>
                                        <span class="translatable">Землетрясения</span>
                                    </button>
                                    <button type="button" class="btn btn-outline-warning btn-sm" data-type="fire">
                                        <i class="bi bi-circle-fill me-1"></i>
                                        <span class="translatable">Пожары</span>
                                    </button>
                                    <button type="button" class="btn btn-outline-info btn-sm" data-type="storm">
                                        <i class="bi bi-circle-fill me-1"></i>
                                        <span class="translatable">Штормы</span>
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm" data-type="volcano">
                                        <i class="bi bi-circle-fill me-1"></i>
                                        <span class="translatable">Вулканы</span>
                                    </button>
                                </div>
                                
                                <!-- Кнопки управления -->
                                <div class="btn-group ms-2" role="group">
                                    <button type="button" class="btn btn-outline-primary btn-sm" id="center-map">
                                        <i class="bi bi-geo-alt me-1"></i>
                                        <span class="translatable">Мое местоположение</span>
                                    </button>
                                    <button type="button" class="btn btn-outline-success btn-sm" id="refresh-data">
                                        <i class="bi bi-arrow-clockwise me-1"></i>
                                        <span class="translatable">Обновить</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Карта и боковая панель -->
    <div class="row">
        <!-- Карта -->
        <div class="col-lg-8 mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-globe me-2"></i>
                        <span class="translatable">Карта событий</span>
                    </h5>
                    <div class="d-flex align-items-center">
                        <span class="badge bg-primary me-2" id="events-count">0</span>
                        <span class="translatable">событий</span>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="map" style="height: 600px;"></div>
                </div>
            </div>
        </div>

        <!-- Боковая панель -->
        <div class="col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-list-ul me-2"></i>
                        <span class="translatable">Список событий</span>
                    </h5>
                </div>
                <div class="card-body" style="max-height: 600px; overflow-y: auto;">
                    <div id="events-list">
                        <div class="text-center py-4">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Загрузка...</span>
                            </div>
                            <p class="mt-3 text-muted">
                                <span class="translatable">Загружаем события...</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Статистика -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">
                        <i class="bi bi-graph-up me-2"></i>
                        <span class="translatable">Статистика за последние 24 часа</span>
                    </h5>
                    <div class="row" id="stats-container">
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <i class="bi bi-circle-fill text-danger display-6"></i>
                                <h4 class="mt-2" id="earthquake-count">0</h4>
                                <p class="text-muted">
                                    <span class="translatable">Землетрясения</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <i class="bi bi-circle-fill text-warning display-6"></i>
                                <h4 class="mt-2" id="fire-count">0</h4>
                                <p class="text-muted">
                                    <span class="translatable">Пожары</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <i class="bi bi-circle-fill text-info display-6"></i>
                                <h4 class="mt-2" id="storm-count">0</h4>
                                <p class="text-muted">
                                    <span class="translatable">Штормы</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-md-3 text-center">
                            <div class="stat-item">
                                <i class="bi bi-circle-fill text-secondary display-6"></i>
                                <h4 class="mt-2" id="volcano-count">0</h4>
                                <p class="text-muted">
                                    <span class="translatable">Вулканы</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Модальное окно для детального просмотра события -->
<div class="modal fade" id="eventModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eventModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="eventModalContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <span class="translatable">Закрыть</span>
                </button>
                <button type="button" class="btn btn-primary" id="subscribe-to-alerts">
                    <i class="bi bi-bell me-1"></i>
                    <span class="translatable">Подписаться на уведомления</span>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
}

.stat-item {
    padding: 1rem;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.stat-item:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
}

.event-item {
    border: 1px solid #e9ecef;
    border-radius: 10px;
    padding: 1rem;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
    cursor: pointer;
}

.event-item:hover {
    border-color: #007bff;
    box-shadow: 0 2px 10px rgba(0,123,255,0.1);
    transform: translateY(-2px);
}

.event-type {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 0.5rem;
}

.event-type.earthquake {
    background: #ffebee;
    color: #c62828;
}

.event-type.fire {
    background: #fff3e0;
    color: #ef6c00;
}

.event-type.storm {
    background: #e3f2fd;
    color: #1565c0;
}

.event-type.volcano {
    background: #f3e5f5;
    color: #7b1fa2;
}

.event-severity {
    display: inline-block;
    padding: 0.2rem 0.6rem;
    border-radius: 15px;
    font-size: 0.75rem;
    font-weight: 600;
    margin-left: 0.5rem;
}

.event-severity.critical {
    background: #ffebee;
    color: #c62828;
}

.event-severity.warning {
    background: #fff3e0;
    color: #ef6c00;
}

.event-severity.advisory {
    background: #e8f5e8;
    color: #2d5a2d;
}

.event-severity.info {
    background: #e3f2fd;
    color: #1565c0;
}

.leaflet-popup-content {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.leaflet-popup-content h3 {
    margin: 0 0 0.5rem 0;
    font-size: 1.1rem;
    color: #333;
}

.leaflet-popup-content p {
    margin: 0.25rem 0;
    font-size: 0.9rem;
    color: #666;
}

.map-legend {
    position: absolute;
    bottom: 20px;
    right: 20px;
    background: white;
    padding: 1rem;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    z-index: 1000;
}

.legend-item {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
}

.legend-item:last-child {
    margin-bottom: 0;
}

.legend-color {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    margin-right: 0.5rem;
}

.legend-color.earthquake {
    background: #dc3545;
}

.legend-color.fire {
    background: #fd7e14;
}

.legend-color.storm {
    background: #0dcaf0;
}

.legend-color.volcano {
    background: #6f42c1;
}
</style>

<!-- Leaflet CSS и JS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
// Глобальные переменные
let map;
let currentLocation = { lat: 42.8746, lon: 74.5698 }; // Бишкек по умолчанию
let eventMarkers = [];
let eventLayers = {
    earthquake: L.layerGroup(),
    fire: L.layerGroup(),
    storm: L.layerGroup(),
    volcano: L.layerGroup()
};
let activeFilters = new Set(['earthquake', 'fire', 'storm', 'volcano']);

// Инициализация карты
function initMap() {
    map = L.map('map').setView([currentLocation.lat, currentLocation.lon], 6);
    
    // Добавляем слой карты
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 18,
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Добавляем слои событий
    Object.values(eventLayers).forEach(layer => {
        map.addLayer(layer);
    });
    
    // Добавляем легенду
    addMapLegend();
    
    // Загружаем события
    loadEvents();
    
    // Настраиваем кнопки
    setupButtons();
}

// Добавление легенды карты
function addMapLegend() {
    const legend = L.control({position: 'bottomright'});
    
    legend.onAdd = function(map) {
        const div = L.DomUtil.create('div', 'map-legend');
        div.innerHTML = `
            <div class="legend-item">
                <div class="legend-color earthquake"></div>
                <span>Землетрясения</span>
            </div>
            <div class="legend-item">
                <div class="legend-color fire"></div>
                <span>Пожары</span>
            </div>
            <div class="legend-item">
                <div class="legend-color storm"></div>
                <span>Штормы</span>
            </div>
            <div class="legend-item">
                <div class="legend-color volcano"></div>
                <span>Вулканы</span>
            </div>
        `;
        return div;
    };
    
    legend.addTo(map);
}

// Настройка кнопок
function setupButtons() {
    // Фильтры по типу событий
    document.querySelectorAll('[data-type]').forEach(button => {
        button.addEventListener('click', function() {
            const type = this.dataset.type;
            if (activeFilters.has(type)) {
                activeFilters.delete(type);
                this.classList.remove('active');
                eventLayers[type].removeFrom(map);
            } else {
                activeFilters.add(type);
                this.classList.add('active');
                map.addLayer(eventLayers[type]);
            }
        });
    });
    
    // Кнопка "Мое местоположение"
    document.getElementById('center-map').addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                currentLocation = {
                    lat: position.coords.latitude,
                    lon: position.coords.longitude
                };
                map.setView([currentLocation.lat, currentLocation.lon], 10);
            });
        } else {
            alert('Геолокация не поддерживается вашим браузером');
        }
    });
    
    // Кнопка "Обновить"
    document.getElementById('refresh-data').addEventListener('click', function() {
        loadEvents();
    });
}

// Загрузка событий
async function loadEvents() {
    try {
        const response = await fetch('/api/alerts?bbox=-180,-90,180,90&types=earthquake,fire,storm,volcano');
        const data = await response.json();
        
        if (data.features) {
            displayEvents(data.features);
        } else {
            console.warn('Нет данных о событиях, используем тестовые данные');
            displayTestEvents();
        }
    } catch (error) {
        console.error('Ошибка загрузки событий:', error);
        displayTestEvents();
    }
}

// Тестовые данные
function displayTestEvents() {
    const testEvents = [
        {
            geometry: { coordinates: [74.5698, 42.8746] },
            properties: {
                type: 'earthquake',
                severity: 'warning',
                magnitude: 5.2,
                message_ru: 'Землетрясение магнитудой 5.2 в районе Бишкека',
                created_at: new Date().toISOString()
            }
        },
        {
            geometry: { coordinates: [74.6000, 42.9000] },
            properties: {
                type: 'fire',
                severity: 'advisory',
                message_ru: 'Обнаружен пожар в районе',
                created_at: new Date().toISOString()
            }
        },
        {
            geometry: { coordinates: [74.5000, 42.8000] },
            properties: {
                type: 'storm',
                severity: 'info',
                message_ru: 'Штормовое предупреждение',
                created_at: new Date().toISOString()
            }
        }
    ];
    displayEvents(testEvents);
}

// Отображение событий
function displayEvents(events) {
    // Очищаем старые маркеры
    Object.values(eventLayers).forEach(layer => {
        layer.clearLayers();
    });
    
    // Обновляем счетчики
    updateEventCounts(events);
    
    // Добавляем новые маркеры
    events.forEach(event => {
        addEventMarker(event);
    });
    
    // Обновляем список событий
    updateEventsList(events);
}

// Добавление маркера события
function addEventMarker(event) {
    const coords = event.geometry.coordinates;
    const props = event.properties;
    
    // Определяем цвет и иконку по типу
    let color = '#007bff';
    let icon = 'circle';
    
    switch (props.type) {
        case 'earthquake':
            color = '#dc3545';
            break;
        case 'fire':
            color = '#fd7e14';
            break;
        case 'storm':
            color = '#0dcaf0';
            break;
        case 'volcano':
            color = '#6f42c1';
            break;
    }
    
    // Создаем маркер
    const marker = L.circleMarker([coords[1], coords[0]], {
        radius: getMarkerRadius(props.severity, props.magnitude),
        fillColor: color,
        color: 'white',
        weight: 2,
        opacity: 1,
        fillOpacity: 0.8
    });
    
    // Добавляем popup
    marker.bindPopup(`
        <div>
            <h3>${props.message_ru || props.message_en || 'Событие'}</h3>
            <p><strong>Тип:</strong> ${getTypeName(props.type)}</p>
            <p><strong>Серьезность:</strong> ${getSeverityName(props.severity)}</p>
            ${props.magnitude ? `<p><strong>Магнитуда:</strong> ${props.magnitude}</p>` : ''}
            <p><strong>Время:</strong> ${new Date(props.created_at).toLocaleString()}</p>
        </div>
    `);
    
    // Добавляем обработчик клика
    marker.on('click', function() {
        showEventModal(event);
    });
    
    // Добавляем в соответствующий слой
    eventLayers[props.type].addLayer(marker);
}

// Получение радиуса маркера
function getMarkerRadius(severity, magnitude) {
    let baseRadius = 6;
    
    if (magnitude) {
        baseRadius = Math.max(4, Math.min(12, magnitude * 2));
    }
    
    switch (severity) {
        case 'critical':
            return baseRadius * 1.5;
        case 'warning':
            return baseRadius * 1.2;
        case 'advisory':
            return baseRadius;
        case 'info':
            return baseRadius * 0.8;
        default:
            return baseRadius;
    }
}

// Получение названия типа
function getTypeName(type) {
    const typeNames = {
        'earthquake': 'Землетрясение',
        'fire': 'Пожар',
        'storm': 'Шторм',
        'volcano': 'Вулкан'
    };
    return typeNames[type] || type;
}

// Получение названия серьезности
function getSeverityName(severity) {
    const severityNames = {
        'critical': 'Критическое',
        'warning': 'Предупреждение',
        'advisory': 'Рекомендация',
        'info': 'Информация'
    };
    return severityNames[severity] || severity;
}

// Обновление счетчиков событий
function updateEventCounts(events) {
    const counts = {
        earthquake: 0,
        fire: 0,
        storm: 0,
        volcano: 0
    };
    
    events.forEach(event => {
        const type = event.properties.type;
        if (counts.hasOwnProperty(type)) {
            counts[type]++;
        }
    });
    
    document.getElementById('earthquake-count').textContent = counts.earthquake;
    document.getElementById('fire-count').textContent = counts.fire;
    document.getElementById('storm-count').textContent = counts.storm;
    document.getElementById('volcano-count').textContent = counts.volcano;
    document.getElementById('events-count').textContent = events.length;
}

// Обновление списка событий
function updateEventsList(events) {
    const container = document.getElementById('events-list');
    
    if (events.length === 0) {
        container.innerHTML = `
            <div class="text-center py-4">
                <i class="bi bi-map display-4 text-muted"></i>
                <h5 class="mt-3 text-muted">
                    <span class="translatable">События не найдены</span>
                </h5>
                <p class="text-muted">
                    <span class="translatable">Попробуйте изменить фильтры</span>
                </p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = events.map(event => {
        const props = event.properties;
        const coords = event.geometry.coordinates;
        
        return `
            <div class="event-item" onclick="showEventModal(${JSON.stringify(event).replace(/"/g, '&quot;')})">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="event-type ${props.type}">${getTypeName(props.type)}</span>
                    <span class="event-severity ${props.severity}">${getSeverityName(props.severity)}</span>
                </div>
                <h6 class="mb-2">${props.message_ru || props.message_en || 'Событие'}</h6>
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="bi bi-geo-alt me-1"></i>
                        ${coords[1].toFixed(4)}, ${coords[0].toFixed(4)}
                    </small>
                    <small class="text-muted">
                        <i class="bi bi-clock me-1"></i>
                        ${new Date(props.created_at).toLocaleTimeString()}
                    </small>
                </div>
            </div>
        `;
    }).join('');
}

// Показать модальное окно события
function showEventModal(event) {
    const props = event.properties;
    const coords = event.geometry.coordinates;
    
    document.getElementById('eventModalTitle').textContent = props.message_ru || props.message_en || 'Событие';
    document.getElementById('eventModalContent').innerHTML = `
        <div class="row">
            <div class="col-md-6">
                <h6>Детали события</h6>
                <p><strong>Тип:</strong> ${getTypeName(props.type)}</p>
                <p><strong>Серьезность:</strong> ${getSeverityName(props.severity)}</p>
                ${props.magnitude ? `<p><strong>Магнитуда:</strong> ${props.magnitude}</p>` : ''}
                <p><strong>Координаты:</strong> ${coords[1].toFixed(6)}, ${coords[0].toFixed(6)}</p>
            </div>
            <div class="col-md-6">
                <h6>Временная информация</h6>
                <p><strong>Обнаружено:</strong> ${new Date(props.created_at).toLocaleString()}</p>
                <p><strong>Источник:</strong> ${props.source || 'Автоматическое обнаружение'}</p>
            </div>
        </div>
        <div class="mt-3">
            <h6>Описание</h6>
            <p>${props.message_ru || props.message_en || 'Описание недоступно'}</p>
        </div>
    `;
    
    const modal = new bootstrap.Modal(document.getElementById('eventModal'));
    modal.show();
}

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    initMap();
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php' ?>
