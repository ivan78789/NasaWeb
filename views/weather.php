<?php 
require_once __DIR__ . '/../config/db.php';

$TitleName = "Disaster Alert / TerraAlert - Погода";
?>

<?php require_once __DIR__ . '/../layout/header.php' ?>
<?php require_once __DIR__ . '/../layout/nav.php' ?>

<div class="container-fluid">
    <!-- Заголовок страницы -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="hero-section">
                <h1 class="display-4 fw-bold text-center mb-3">
                    <i class="bi bi-cloud-sun me-3"></i>
                    <span class="translatable">Погодные условия</span>
                </h1>
                <p class="lead text-center text-muted">
                    <span class="translatable">Текущая погода и прогноз на 5 дней</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Поиск местоположения -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <i class="bi bi-geo-alt me-2"></i>
                                <span class="translatable">Местоположение</span>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" id="location-search" placeholder="Введите город или координаты">
                                <button class="btn btn-outline-primary" id="search-location">
                                    <i class="bi bi-search me-1"></i>
                                    <span class="translatable">Поиск</span>
                                </button>
                                <button class="btn btn-outline-success" id="get-current-location">
                                    <i class="bi bi-geo-alt me-1"></i>
                                    <span class="translatable">Мое местоположение</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Текущая погода -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card weather-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <div class="current-weather">
                                <div class="weather-icon">
                                    <i class="bi bi-cloud-sun display-1" id="weather-icon"></i>
                                </div>
                                <div class="weather-info">
                                    <h2 class="temperature" id="current-temp">--°C</h2>
                                    <h4 class="weather-description" id="weather-description">Загрузка...</h4>
                                    <p class="location" id="current-location">Определение местоположения...</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="weather-details">
                                <div class="detail-item">
                                    <i class="bi bi-thermometer-half"></i>
                                    <span class="translatable">Ощущается как:</span>
                                    <strong id="feels-like">--°C</strong>
                                </div>
                                <div class="detail-item">
                                    <i class="bi bi-droplet"></i>
                                    <span class="translatable">Влажность:</span>
                                    <strong id="humidity">--%</strong>
                                </div>
                                <div class="detail-item">
                                    <i class="bi bi-wind"></i>
                                    <span class="translatable">Ветер:</span>
                                    <strong id="wind-speed">-- м/с</strong>
                                </div>
                                <div class="detail-item">
                                    <i class="bi bi-eye"></i>
                                    <span class="translatable">Видимость:</span>
                                    <strong id="visibility">-- км</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Прогноз на 5 дней -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-calendar-week me-2"></i>
                        <span class="translatable">Прогноз на 5 дней</span>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row" id="forecast-container">
                        <div class="col-12 text-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Загрузка...</span>
                            </div>
                            <p class="mt-3 text-muted">
                                <span class="translatable">Загружаем прогноз...</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Погодные предупреждения -->
    <div class="row mb-4" id="weather-alerts-container" style="display: none;">
        <div class="col-12">
            <div class="card border-warning">
                <div class="card-header bg-warning text-dark">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <span class="translatable">Погодные предупреждения</span>
                    </h5>
                </div>
                <div class="card-body" id="weather-alerts-content">
                    <!-- Содержимое предупреждений -->
                </div>
            </div>
        </div>
    </div>

    <!-- Подписка на уведомления -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="bi bi-bell me-2"></i>
                        <span class="translatable">Уведомления о погоде</span>
                    </h5>
                </div>
                <div class="card-body">
                    <form id="weather-subscription-form">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="weather-email" class="form-label">
                                        <span class="translatable">Email для уведомлений</span>
                                    </label>
                                    <input type="email" class="form-control" id="weather-email" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="weather-radius" class="form-label">
                                        <span class="translatable">Радиус уведомлений (км)</span>
                                    </label>
                                    <input type="number" class="form-control" id="weather-radius" value="50" min="1" max="500">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">
                                <span class="translatable">Типы уведомлений</span>
                            </label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="extreme_temperature" id="temp-alerts">
                                <label class="form-check-label" for="temp-alerts">
                                    <span class="translatable">Экстремальные температуры</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="storm" id="storm-alerts">
                                <label class="form-check-label" for="storm-alerts">
                                    <span class="translatable">Штормы и осадки</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="wind" id="wind-alerts">
                                <label class="form-check-label" for="wind-alerts">
                                    <span class="translatable">Сильный ветер</span>
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-bell me-1"></i>
                            <span class="translatable">Подписаться на уведомления</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.hero-section {
    background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
    color: white;
    padding: 3rem 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
}

.weather-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.current-weather {
    display: flex;
    align-items: center;
    gap: 2rem;
}

.weather-icon {
    font-size: 4rem;
    opacity: 0.9;
}

.weather-info h2 {
    font-size: 3rem;
    font-weight: 300;
    margin: 0;
    line-height: 1;
}

.weather-info h4 {
    font-size: 1.5rem;
    font-weight: 400;
    margin: 0.5rem 0;
    opacity: 0.9;
}

.weather-info p {
    font-size: 1.1rem;
    opacity: 0.8;
    margin: 0;
}

.weather-details {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.detail-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1rem;
}

.detail-item i {
    width: 20px;
    text-align: center;
}

.forecast-day {
    text-align: center;
    padding: 1rem;
    border-radius: 10px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.forecast-day:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
}

.forecast-day.active {
    background: #e3f2fd;
    border: 2px solid #2196f3;
}

.forecast-icon {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.forecast-temp {
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0.5rem 0;
}

.forecast-date {
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 0.5rem;
}

.forecast-desc {
    font-size: 0.8rem;
    color: #888;
}

.weather-alert {
    border-left: 4px solid #ff9800;
    padding: 1rem;
    margin-bottom: 1rem;
    background: #fff3e0;
    border-radius: 0 8px 8px 0;
}

.weather-alert.critical {
    border-left-color: #f44336;
    background: #ffebee;
}

.weather-alert.warning {
    border-left-color: #ff9800;
    background: #fff3e0;
}

.weather-alert.info {
    border-left-color: #2196f3;
    background: #e3f2fd;
}

.alert-icon {
    font-size: 1.5rem;
    margin-right: 0.5rem;
}

.alert-title {
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.alert-description {
    color: #666;
    line-height: 1.4;
}

@media (max-width: 768px) {
    .current-weather {
        flex-direction: column;
        text-align: center;
        gap: 1rem;
    }
    
    .weather-info h2 {
        font-size: 2.5rem;
    }
    
    .weather-details {
        margin-top: 1rem;
    }
}
</style>

<script>
let currentLocation = { lat: 42.8746, lon: 74.5698 }; // Бишкек по умолчанию
let weatherData = null;

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    loadWeather();
    setupEventListeners();
    
    // Попытка получить текущее местоположение
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function(position) {
                currentLocation = {
                    lat: position.coords.latitude,
                    lon: position.coords.longitude
                };
                loadWeather();
            },
            function(error) {
                console.log('Геолокация недоступна, используем местоположение по умолчанию');
                loadWeather();
            }
        );
    } else {
        loadWeather();
    }
});

// Настройка обработчиков событий
function setupEventListeners() {
    // Поиск местоположения
    document.getElementById('search-location').addEventListener('click', function() {
        const location = document.getElementById('location-search').value;
        if (location) {
            searchLocation(location);
        }
    });
    
    // Получение текущего местоположения
    document.getElementById('get-current-location').addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    currentLocation = {
                        lat: position.coords.latitude,
                        lon: position.coords.longitude
                    };
                    loadWeather();
                },
                function(error) {
                    alert('Не удалось получить местоположение');
                }
            );
        } else {
            alert('Геолокация не поддерживается');
        }
    });
    
    // Подписка на уведомления
    document.getElementById('weather-subscription-form').addEventListener('submit', function(e) {
        e.preventDefault();
        subscribeToWeatherAlerts();
    });
}

// Поиск местоположения
async function searchLocation(location) {
    try {
        // Простой поиск по названию города
        const response = await fetch(`https://api.openweathermap.org/geo/1.0/direct?q=${encodeURIComponent(location)}&limit=1&appid=9000fe7f9a0a1200deb20cf9cfa17c28`);
        const data = await response.json();
        
        if (data.length > 0) {
            currentLocation = {
                lat: data[0].lat,
                lon: data[0].lon
            };
            loadWeather();
        } else {
            alert('Местоположение не найдено');
        }
    } catch (error) {
        console.error('Ошибка поиска местоположения:', error);
        alert('Ошибка поиска местоположения');
    }
}

// Загрузка погодных данных
async function loadWeather() {
    try {
        const response = await fetch(`/api/weather?lat=${currentLocation.lat}&lon=${currentLocation.lon}`);
        const data = await response.json();
        
        if (data.status === 'success') {
            weatherData = data;
            displayCurrentWeather(data.current);
            displayForecast(data.forecast);
            checkWeatherAlerts(data.current);
        } else {
            console.warn('Ошибка API погоды, используем тестовые данные');
            displayTestWeather();
        }
    } catch (error) {
        console.error('Ошибка загрузки погоды:', error);
        displayTestWeather();
    }
}

<?php
require_once 'config.php';

// Проверяем наличие координат
$lat = isset($_GET['lat']) ? $_GET['lat'] : null;
$lon = isset($_GET['lon']) ? $_GET['lon'] : null;

if (!$lat || !$lon) {
    echo json_encode(['error' => 'Не указаны координаты.']);
    exit;
}

// URL запроса к OpenWeatherMap
$url = "https://api.openweathermap.org/data/2.5/weather?lat={$lat}&lon={$lon}&units=metric&lang=ru&appid=" . OPENWEATHER_API_KEY;

// Получаем ответ
$response = file_get_contents($url);

if ($response === FALSE) {
    echo json_encode(['error' => 'Ошибка получения данных от OpenWeatherMap.']);
    exit;
}

// Отдаём JSON
header('Content-Type: application/json');
echo $response;

?>

<div id="weather">
  <h2 id="current-location">Загрузка...</h2>
  <img id="weather-icon" class="weather-icon" src="" alt="">
  <p id="weather-description"></p>
  <h1 id="current-temp">--°C</h1>
  <p>Ощущается как: <span id="feels-like">--°C</span></p>
  <p>Влажность: <span id="humidity">--%</span></p>
  <p>Ветер: <span id="wind-speed">-- м/с</span></p>
  <p>Видимость: <span id="visibility">-- км</span></p>
</div>

<script>
// Обновление иконки
function updateWeatherIcon(iconCode) {
  document.getElementById('weather-icon').src = `https://openweathermap.org/img/wn/${iconCode}@2x.png`;
}

// Отображение погоды
function displayCurrentWeather(data) {
  document.getElementById('current-location').textContent = `${data.name}`;
  document.getElementById('current-temp').textContent = `${Math.round(data.main.temp)}°C`;
  document.getElementById('feels-like').textContent = `${Math.round(data.main.feels_like)}°C`;
  document.getElementById('humidity').textContent = `${data.main.humidity}%`;
  document.getElementById('wind-speed').textContent = `${data.wind.speed} м/с`;
  document.getElementById('visibility').textContent = `${data.visibility / 1000} км`;
  document.getElementById('weather-description').textContent = data.weather[0].description;
  updateWeatherIcon(data.weather[0].icon);
}

// Определяем местоположение пользователя
function getWeatherByLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(success => {
      const lat = success.coords.latitude;
      const lon = success.coords.longitude;

      fetch(`getWeather.php?lat=${lat}&lon=${lon}`)
        .then(response => response.json())
        .then(data => {
          if (data.error) {
            alert(data.error);
          } else {
            displayCurrentWeather(data);
          }
        })
        .catch(() => alert('Ошибка получения данных.'));
    }, () => {
      alert('Разрешите доступ к местоположению для получения погоды.');
    });
  } else {
    alert('Геолокация не поддерживается вашим браузером.');
  }
}

// Запускаем
getWeatherByLocation();
</script>

</body>
</html>

// Обновление иконки погоды
function updateWeatherIcon(iconCode) {
    const iconElement = document.getElementById('weather-icon');
    const iconMap = {
        '01d': 'bi-sun',
        '01n': 'bi-moon',
        '02d': 'bi-cloud-sun',
        '02n': 'bi-cloud-moon',
        '03d': 'bi-cloud',
        '03n': 'bi-cloud',
        '04d': 'bi-clouds',
        '04n': 'bi-clouds',
        '09d': 'bi-cloud-rain',
        '09n': 'bi-cloud-rain',
        '10d': 'bi-cloud-rain',
        '10n': 'bi-cloud-rain',
        '11d': 'bi-cloud-lightning',
        '11n': 'bi-cloud-lightning',
        '13d': 'bi-snow',
        '13n': 'bi-snow',
        '50d': 'bi-cloud-fog',
        '50n': 'bi-cloud-fog'
    };
    
    const iconClass = iconMap[iconCode] || 'bi-cloud-sun';
    iconElement.className = `bi ${iconClass} display-1`;
}

// Отображение прогноза
function displayForecast(forecast) {
    const container = document.getElementById('forecast-container');
    
    if (!forecast || forecast.length === 0) {
        container.innerHTML = `
            <div class="col-12 text-center">
                <p class="text-muted">
                    <span class="translatable">Прогноз недоступен</span>
                </p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = forecast.map((day, index) => `
        <div class="col-md-2 col-sm-4 col-6 mb-3">
            <div class="forecast-day ${index === 0 ? 'active' : ''}" onclick="selectForecastDay(${index})">
                <div class="forecast-date">${formatForecastDate(day.date)}</div>
                <div class="forecast-icon">
                    <i class="bi ${getForecastIcon(day.icon)}"></i>
                </div>
                <div class="forecast-temp">
                    ${Math.round(day.temp_max)}° / ${Math.round(day.temp_min)}°
                </div>
                <div class="forecast-desc">${day.description}</div>
            </div>
        </div>
    `).join('');
}

// Форматирование даты прогноза
function formatForecastDate(dateString) {
    const date = new Date(dateString);
    const today = new Date();
    const tomorrow = new Date(today);
    tomorrow.setDate(tomorrow.getDate() + 1);
    
    if (date.toDateString() === today.toDateString()) {
        return 'Сегодня';
    } else if (date.toDateString() === tomorrow.toDateString()) {
        return 'Завтра';
    } else {
        return date.toLocaleDateString('ru-RU', { weekday: 'short' });
    }
}

// Получение иконки прогноза
function getForecastIcon(iconCode) {
    const iconMap = {
        '01d': 'bi-sun',
        '01n': 'bi-moon',
        '02d': 'bi-cloud-sun',
        '02n': 'bi-cloud-moon',
        '03d': 'bi-cloud',
        '03n': 'bi-cloud',
        '04d': 'bi-clouds',
        '04n': 'bi-clouds',
        '09d': 'bi-cloud-rain',
        '09n': 'bi-cloud-rain',
        '10d': 'bi-cloud-rain',
        '10n': 'bi-cloud-rain',
        '11d': 'bi-cloud-lightning',
        '11n': 'bi-cloud-lightning',
        '13d': 'bi-snow',
        '13n': 'bi-snow',
        '50d': 'bi-cloud-fog',
        '50n': 'bi-cloud-fog'
    };
    
    return iconMap[iconCode] || 'bi-cloud-sun';
}

// Выбор дня прогноза
function selectForecastDay(index) {
    document.querySelectorAll('.forecast-day').forEach(day => {
        day.classList.remove('active');
    });
    document.querySelectorAll('.forecast-day')[index].classList.add('active');
}

// Проверка погодных предупреждений
function checkWeatherAlerts(current) {
    const alerts = [];
    
    // Проверяем экстремальные температуры
    if (current.temperature > 35) {
        alerts.push({
            type: 'extreme_temperature',
            severity: 'warning',
            title: 'Экстремальная жара',
            description: `Температура ${Math.round(current.temperature)}°C превышает безопасные значения`
        });
    } else if (current.temperature < -20) {
        alerts.push({
            type: 'extreme_temperature',
            severity: 'warning',
            title: 'Экстремальный холод',
            description: `Температура ${Math.round(current.temperature)}°C может быть опасной для здоровья`
        });
    }
    
    // Проверяем сильный ветер
    if (current.wind_speed > 15) {
        alerts.push({
            type: 'wind',
            severity: 'warning',
            title: 'Сильный ветер',
            description: `Скорость ветра ${current.wind_speed} м/с может быть опасной`
        });
    }
    
    // Проверяем плохую видимость
    if (current.visibility < 1) {
        alerts.push({
            type: 'visibility',
            severity: 'warning',
            title: 'Плохая видимость',
            description: `Видимость ${current.visibility} км может затруднить движение`
        });
    }
    
    displayWeatherAlerts(alerts);
}

// Отображение погодных предупреждений
function displayWeatherAlerts(alerts) {
    const container = document.getElementById('weather-alerts-container');
    const content = document.getElementById('weather-alerts-content');
    
    if (alerts.length === 0) {
        container.style.display = 'none';
        return;
    }
    
    content.innerHTML = alerts.map(alert => `
        <div class="weather-alert ${alert.severity}">
            <div class="d-flex align-items-start">
                <i class="bi bi-exclamation-triangle alert-icon"></i>
                <div>
                    <div class="alert-title">${alert.title}</div>
                    <div class="alert-description">${alert.description}</div>
                </div>
            </div>
        </div>
    `).join('');
    
    container.style.display = 'block';
}

// Подписка на погодные уведомления
async function subscribeToWeatherAlerts() {
    const email = document.getElementById('weather-email').value;
    const radius = document.getElementById('weather-radius').value;
    const categories = Array.from(document.querySelectorAll('input[type="checkbox"]:checked')).map(cb => cb.value);
    
    if (!email) {
        alert('Введите email для подписки');
        return;
    }
    
    try {
        const response = await fetch('/api/subscribe', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                email: email,
                categories: categories,
                latitude: currentLocation.lat,
                longitude: currentLocation.lon,
                radius: radius
            })
        });
        
        const data = await response.json();
        
        if (data.status === 'success') {
            alert('Подписка на погодные уведомления успешно оформлена!');
        } else {
            alert('Ошибка: ' + data.message);
        }
    } catch (error) {
        console.error('Ошибка подписки:', error);
        alert('Ошибка оформления подписки');
    }
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php' ?>
