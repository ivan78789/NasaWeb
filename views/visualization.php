<?php 
require_once __DIR__ . '/../config/db.php';

$TitleName = "Disaster Alert / TerraAlert - Визуализация данных";
?>

<?php require_once __DIR__ . '/../layout/header.php' ?>
<?php require_once __DIR__ . '/../layout/nav.php' ?>

<div class="container-fluid">
    <!-- Заголовок страницы -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="hero-section">
                <h1 class="display-4 fw-bold text-center mb-3">
                    <i class="bi bi-graph-up me-3"></i>
                    <span class="translatable">Визуализация данных</span>
                </h1>
                <p class="lead text-center text-muted">
                    <span class="translatable">Интерактивные графики и статистика природных катастроф</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Фильтры и настройки -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="bi bi-sliders me-2"></i>
                                <span class="translatable">Настройки визуализации</span>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex flex-wrap gap-2">
                                <select class="form-select" id="time-range">
                                    <option value="24h">
                                        <span class="translatable">Последние 24 часа</span>
                                    </option>
                                    <option value="7d" selected>
                                        <span class="translatable">Последние 7 дней</span>
                                    </option>
                                    <option value="30d">
                                        <span class="translatable">Последние 30 дней</span>
                                    </option>
                                    <option value="1y">
                                        <span class="translatable">Последний год</span>
                                    </option>
                                </select>
                                <select class="form-select" id="data-type">
                                    <option value="all" selected>
                                        <span class="translatable">Все данные</span>
                                    </option>
                                    <option value="earthquake">
                                        <span class="translatable">Землетрясения</span>
                                    </option>
                                    <option value="fire">
                                        <span class="translatable">Пожары</span>
                                    </option>
                                    <option value="storm">
                                        <span class="translatable">Штормы</span>
                                    </option>
                                </select>
                                <button class="btn btn-outline-primary" id="refresh-charts">
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

    <!-- Статистические карточки -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-exclamation-triangle text-danger"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number" id="total-events">0</h3>
                    <p class="stat-label">
                        <span class="translatable">Всего событий</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-thermometer-half text-warning"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number" id="avg-temperature">0°C</h3>
                    <p class="stat-label">
                        <span class="translatable">Средняя температура</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-wind text-info"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number" id="max-wind">0 м/с</h3>
                    <p class="stat-label">
                        <span class="translatable">Максимальный ветер</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="stat-card">
                <div class="stat-icon">
                    <i class="bi bi-shield-check text-success"></i>
                </div>
                <div class="stat-content">
                    <h3 class="stat-number" id="safety-score">0%</h3>
                    <p class="stat-label">
                        <span class="translatable">Индекс безопасности</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Графики -->
    <div class="row mb-4">
        <!-- График событий по времени -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-graph-up me-2"></i>
                        <span class="translatable">События по времени</span>
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="events-timeline-chart" height="300"></canvas>
                </div>
            </div>
        </div>
        
        <!-- Круговая диаграмма типов событий -->
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-pie-chart me-2"></i>
                        <span class="translatable">Типы событий</span>
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="events-pie-chart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- График температуры -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-thermometer-half me-2"></i>
                        <span class="translatable">Температурный график</span>
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="temperature-chart" height="250"></canvas>
                </div>
            </div>
        </div>
        
        <!-- График влажности -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-droplet me-2"></i>
                        <span class="translatable">Влажность и осадки</span>
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="humidity-chart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Тепловая карта -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-map me-2"></i>
                        <span class="translatable">Тепловая карта событий</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div id="heatmap-container" style="height: 400px;">
                        <div class="text-center py-5">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Загрузка...</span>
                            </div>
                            <p class="mt-3 text-muted">
                                <span class="translatable">Загружаем тепловую карту...</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Анализ трендов -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-trending-up me-2"></i>
                        <span class="translatable">Анализ трендов</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row" id="trends-analysis">
                        <div class="col-md-4 mb-3">
                            <div class="trend-item">
                                <div class="trend-icon">
                                    <i class="bi bi-arrow-up text-danger"></i>
                                </div>
                                <div class="trend-content">
                                    <h6>
                                        <span class="translatable">Рост землетрясений</span>
                                    </h6>
                                    <p class="text-muted">
                                        <span class="translatable">+15% за последний месяц</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="trend-item">
                                <div class="trend-icon">
                                    <i class="bi bi-arrow-down text-success"></i>
                                </div>
                                <div class="trend-content">
                                    <h6>
                                        <span class="translatable">Снижение пожаров</span>
                                    </h6>
                                    <p class="text-muted">
                                        <span class="translatable">-8% за последний месяц</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="trend-item">
                                <div class="trend-icon">
                                    <i class="bi bi-arrow-right text-info"></i>
                                </div>
                                <div class="trend-content">
                                    <h6>
                                        <span class="translatable">Стабильная погода</span>
                                    </h6>
                                    <p class="text-muted">
                                        <span class="translatable">Без значительных изменений</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<!-- Leaflet для тепловой карты -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>

<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 3rem 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
}

.stat-card {
    background: white;
    border-radius: 15px;
    padding: 1.5rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.stat-icon {
    font-size: 2.5rem;
    opacity: 0.8;
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    margin: 0;
    color: #333;
}

.stat-label {
    margin: 0;
    color: #666;
    font-size: 0.9rem;
}

.trend-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border-radius: 10px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.trend-item:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

.trend-icon {
    font-size: 1.5rem;
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: white;
}

.trend-content h6 {
    margin: 0 0 0.25rem 0;
    font-weight: 600;
    color: #333;
}

.trend-content p {
    margin: 0;
    font-size: 0.9rem;
}

.chart-container {
    position: relative;
    height: 300px;
}

#heatmap-container {
    border-radius: 10px;
    overflow: hidden;
}

.loading-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(255,255,255,0.9);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 1000;
}

@media (max-width: 768px) {
    .stat-card {
        flex-direction: column;
        text-align: center;
    }
    
    .trend-item {
        flex-direction: column;
        text-align: center;
    }
}
</style>

<script>
// Глобальные переменные для графиков
let eventsTimelineChart;
let eventsPieChart;
let temperatureChart;
let humidityChart;
let heatmap;

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    loadVisualizationData();
    setupEventListeners();
});

// Настройка обработчиков событий
function setupEventListeners() {
    document.getElementById('time-range').addEventListener('change', loadVisualizationData);
    document.getElementById('data-type').addEventListener('change', loadVisualizationData);
    document.getElementById('refresh-charts').addEventListener('click', loadVisualizationData);
}

// Загрузка данных для визуализации
async function loadVisualizationData() {
    const timeRange = document.getElementById('time-range').value;
    const dataType = document.getElementById('data-type').value;
    
    try {
        // Загружаем данные событий
        const eventsResponse = await fetch(`/api/alerts?since=${getSinceDate(timeRange)}&types=${dataType === 'all' ? 'earthquake,fire,storm' : dataType}`);
        const eventsData = await eventsResponse.json();
        
        // Загружаем погодные данные
        const weatherResponse = await fetch(`/api/weather?lat=42.8746&lon=74.5698`);
        const weatherData = await weatherResponse.json();
        
        // Обновляем статистические карточки
        updateStatCards(eventsData, weatherData);
        
        // Создаем графики
        createEventsTimelineChart(eventsData);
        createEventsPieChart(eventsData);
        createTemperatureChart(weatherData);
        createHumidityChart(weatherData);
        createHeatmap(eventsData);
        
    } catch (error) {
        console.error('Ошибка загрузки данных:', error);
        // Используем тестовые данные
        loadTestData();
    }
}

// Получение даты "с" для фильтра
function getSinceDate(timeRange) {
    const now = new Date();
    switch (timeRange) {
        case '24h':
            return new Date(now.getTime() - 24 * 60 * 60 * 1000).toISOString();
        case '7d':
            return new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000).toISOString();
        case '30d':
            return new Date(now.getTime() - 30 * 24 * 60 * 60 * 1000).toISOString();
        case '1y':
            return new Date(now.getTime() - 365 * 24 * 60 * 60 * 1000).toISOString();
        default:
            return new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000).toISOString();
    }
}

// Обновление статистических карточек
function updateStatCards(eventsData, weatherData) {
    const events = eventsData.features || [];
    
    document.getElementById('total-events').textContent = events.length;
    
    if (weatherData.current) {
        document.getElementById('avg-temperature').textContent = Math.round(weatherData.current.temperature) + '°C';
        document.getElementById('max-wind').textContent = Math.round(weatherData.current.wind_speed) + ' м/с';
    }
    
    // Расчет индекса безопасности (упрощенный)
    const safetyScore = Math.max(0, 100 - (events.length * 5));
    document.getElementById('safety-score').textContent = safetyScore + '%';
}

// Создание графика событий по времени
function createEventsTimelineChart(eventsData) {
    const ctx = document.getElementById('events-timeline-chart').getContext('2d');
    
    if (eventsTimelineChart) {
        eventsTimelineChart.destroy();
    }
    
    const events = eventsData.features || [];
    const timelineData = processTimelineData(events);
    
    eventsTimelineChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: timelineData.labels,
            datasets: [
                {
                    label: 'Землетрясения',
                    data: timelineData.earthquakes,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Пожары',
                    data: timelineData.fires,
                    borderColor: '#fd7e14',
                    backgroundColor: 'rgba(253, 126, 20, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Штормы',
                    data: timelineData.storms,
                    borderColor: '#0dcaf0',
                    backgroundColor: 'rgba(13, 202, 240, 0.1)',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}

// Создание круговой диаграммы типов событий
function createEventsPieChart(eventsData) {
    const ctx = document.getElementById('events-pie-chart').getContext('2d');
    
    if (eventsPieChart) {
        eventsPieChart.destroy();
    }
    
    const events = eventsData.features || [];
    const pieData = processPieData(events);
    
    eventsPieChart = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: pieData.labels,
            datasets: [{
                data: pieData.data,
                backgroundColor: [
                    '#dc3545',
                    '#fd7e14',
                    '#0dcaf0',
                    '#6f42c1'
                ],
                borderWidth: 2,
                borderColor: '#fff'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}

// Создание графика температуры
function createTemperatureChart(weatherData) {
    const ctx = document.getElementById('temperature-chart').getContext('2d');
    
    if (temperatureChart) {
        temperatureChart.destroy();
    }
    
    const tempData = processTemperatureData(weatherData);
    
    temperatureChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: tempData.labels,
            datasets: [{
                label: 'Температура',
                data: tempData.temperatures,
                borderColor: '#ff6b6b',
                backgroundColor: 'rgba(255, 107, 107, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });
}

// Создание графика влажности
function createHumidityChart(weatherData) {
    const ctx = document.getElementById('humidity-chart').getContext('2d');
    
    if (humidityChart) {
        humidityChart.destroy();
    }
    
    const humidityData = processHumidityData(weatherData);
    
    humidityChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: humidityData.labels,
            datasets: [{
                label: 'Влажность (%)',
                data: humidityData.humidity,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
}

// Создание тепловой карты
function createHeatmap(eventsData) {
    const container = document.getElementById('heatmap-container');
    container.innerHTML = '';
    
    const events = eventsData.features || [];
    const heatmapData = processHeatmapData(events);
    
    // Создаем карту
    const map = L.map('heatmap-container').setView([42.8746, 74.5698], 6);
    
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap contributors'
    }).addTo(map);
    
    // Добавляем тепловую карту
    if (heatmapData.length > 0) {
        L.heatLayer(heatmapData, {
            radius: 25,
            blur: 15,
            maxZoom: 17
        }).addTo(map);
    }
    
    heatmap = map;
}

// Обработка данных для временной шкалы
function processTimelineData(events) {
    const now = new Date();
    const days = 7;
    const labels = [];
    const earthquakes = new Array(days).fill(0);
    const fires = new Array(days).fill(0);
    const storms = new Array(days).fill(0);
    
    for (let i = days - 1; i >= 0; i--) {
        const date = new Date(now.getTime() - i * 24 * 60 * 60 * 1000);
        labels.push(date.toLocaleDateString('ru-RU', { weekday: 'short' }));
    }
    
    events.forEach(event => {
        const eventDate = new Date(event.properties.created_at);
        const daysDiff = Math.floor((now - eventDate) / (24 * 60 * 60 * 1000));
        
        if (daysDiff >= 0 && daysDiff < days) {
            const type = event.properties.type;
            const index = days - 1 - daysDiff;
            
            if (type === 'earthquake') earthquakes[index]++;
            else if (type === 'fire') fires[index]++;
            else if (type === 'storm') storms[index]++;
        }
    });
    
    return { labels, earthquakes, fires, storms };
}

// Обработка данных для круговой диаграммы
function processPieData(events) {
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
    
    return {
        labels: ['Землетрясения', 'Пожары', 'Штормы', 'Вулканы'],
        data: [counts.earthquake, counts.fire, counts.storm, counts.volcano]
    };
}

// Обработка данных температуры
function processTemperatureData(weatherData) {
    const labels = [];
    const temperatures = [];
    
    if (weatherData.forecast) {
        weatherData.forecast.forEach(day => {
            labels.push(new Date(day.date).toLocaleDateString('ru-RU', { weekday: 'short' }));
            temperatures.push(Math.round(day.temp_max));
        });
    } else {
        // Тестовые данные
        for (let i = 0; i < 5; i++) {
            const date = new Date();
            date.setDate(date.getDate() + i);
            labels.push(date.toLocaleDateString('ru-RU', { weekday: 'short' }));
            temperatures.push(20 + Math.random() * 10);
        }
    }
    
    return { labels, temperatures };
}

// Обработка данных влажности
function processHumidityData(weatherData) {
    const labels = [];
    const humidity = [];
    
    if (weatherData.forecast) {
        weatherData.forecast.forEach(day => {
            labels.push(new Date(day.date).toLocaleDateString('ru-RU', { weekday: 'short' }));
            humidity.push(Math.round(day.humidity || 50 + Math.random() * 30));
        });
    } else {
        // Тестовые данные
        for (let i = 0; i < 5; i++) {
            const date = new Date();
            date.setDate(date.getDate() + i);
            labels.push(date.toLocaleDateString('ru-RU', { weekday: 'short' }));
            humidity.push(Math.round(50 + Math.random() * 30));
        }
    }
    
    return { labels, humidity };
}

// Обработка данных для тепловой карты
function processHeatmapData(events) {
    return events.map(event => {
        const coords = event.geometry.coordinates;
        const intensity = getEventIntensity(event.properties);
        return [coords[1], coords[0], intensity];
    });
}

// Получение интенсивности события
function getEventIntensity(properties) {
    const severityMap = {
        'critical': 1.0,
        'warning': 0.7,
        'advisory': 0.4,
        'info': 0.2
    };
    
    return severityMap[properties.severity] || 0.5;
}

// Загрузка тестовых данных
function loadTestData() {
    const testEvents = {
        features: [
            {
                geometry: { coordinates: [74.5698, 42.8746] },
                properties: { type: 'earthquake', severity: 'warning', created_at: new Date().toISOString() }
            },
            {
                geometry: { coordinates: [74.6000, 42.9000] },
                properties: { type: 'fire', severity: 'advisory', created_at: new Date().toISOString() }
            }
        ]
    };
    
    const testWeather = {
        current: { temperature: 22, wind_speed: 3.5 },
        forecast: [
            { date: '2024-01-01', temp_max: 25, humidity: 60 },
            { date: '2024-01-02', temp_max: 23, humidity: 65 },
            { date: '2024-01-03', temp_max: 20, humidity: 70 }
        ]
    };
    
    updateStatCards(testEvents, testWeather);
    createEventsTimelineChart(testEvents);
    createEventsPieChart(testEvents);
    createTemperatureChart(testWeather);
    createHumidityChart(testWeather);
    createHeatmap(testEvents);
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php' ?>
