# Disaster Alert / TerraAlert

Веб-платформа для оповещений о чрезвычайных ситуациях, погоды и научного контента NASA.

## 🚀 Возможности

- **Интерактивная карта рисков** с отображением землетрясений, пожаров и других ЧС
- **Погодные данные** в реальном времени с прогнозом на 5 дней
- **Новости NASA** с красивыми изображениями космоса
- **Push уведомления** для критических оповещений
- **Многоязычность** (Русский, English, Кыргызча)
- **Админ панель** для управления оповещениями
- **PWA поддержка** для установки как приложение

## 🛠 Технологический стек

- **Backend**: PHP 8.2 + MySQL 8.0
- **Frontend**: Vanilla JavaScript + Bootstrap 5 + Leaflet
- **APIs**: NASA, USGS, OpenWeatherMap, NASA FIRMS
- **Контейнеризация**: Docker + Docker Compose
- **Кеширование**: Redis

## 📋 Требования

- Docker и Docker Compose
- Git
- Минимум 2GB RAM
- Порты 8084, 8085, 3307, 6379 должны быть свободны

## 🚀 Быстрый старт

### 1. Клонирование репозитория

```bash
git clone <repository-url>
cd NasaWeb
```

### 2. Настройка API ключей

Отредактируйте файл `config/nasa.php` и добавьте ваши API ключи:

```php
define('NASA_API_KEY', 'YOUR_NASA_API_KEY_HERE');
define('OPENWEATHER_API_KEY', 'YOUR_OPENWEATHER_API_KEY_HERE');
define('FIREBASE_SERVER_KEY', 'YOUR_FIREBASE_SERVER_KEY_HERE');
```

**Получение API ключей:**
- **NASA API**: https://api.nasa.gov/ (бесплатно)
- **OpenWeatherMap**: https://openweathermap.org/api (бесплатный план)
- **Firebase**: https://console.firebase.google.com/ (для push уведомлений)

### 3. Запуск проекта

```bash
# Запуск всех сервисов
docker-compose up -d

# Просмотр логов
docker-compose logs -f
```

### 4. Инициализация базы данных

```bash
# Добавление тестовых данных
docker-compose exec web php database/seed.php
```

### 5. Открытие приложения

- **Основной сайт**: http://localhost:8084
- **Админ панель**: http://localhost:8084/admin
- **phpMyAdmin**: http://localhost:8085

## 📁 Структура проекта

```
NasaWeb/
├── api/                    # API endpoints
│   ├── alerts/            # Оповещения о ЧС
│   ├── news/              # Новости NASA
│   ├── weather/           # Погодные данные
│   ├── subscribe/         # Подписки
│   ├── devices/           # Устройства для push
│   └── admin/             # Админ API
├── assets/                # Статические файлы
│   ├── css/               # Стили
│   ├── js/                # JavaScript
│   ├── img/               # Изображения
│   └── fonts/             # Шрифты
├── config/                # Конфигурация
│   ├── db.php             # База данных
│   └── nasa.php           # API ключи
├── cron/                  # Cron задачи
│   └── update_data.php    # Обновление данных
├── database/              # База данных
│   ├── db.sql             # Схема БД
│   └── seed.php           # Тестовые данные
├── include/               # Вспомогательные классы
│   ├── usgs.php           # USGS Earthquakes
│   ├── firms.php          # NASA FIRMS
│   └── weather.php        # OpenWeatherMap
├── layout/                # Шаблоны
│   ├── header.php         # Заголовок
│   ├── footer.php         # Подвал
│   └── nav.php            # Навигация
├── views/                 # Страницы
│   ├── index.php          # Главная
│   ├── admin.php          # Админ панель
│   └── profile.php        # Профиль
├── docker-compose.yml     # Docker Compose
├── Dockerfile             # Docker образ
└── README.md              # Документация
```

## 🔧 API Endpoints

### Публичные API

| Endpoint | Метод | Описание |
|----------|-------|----------|
| `/api/weather` | GET | Погодные данные |
| `/api/alerts` | GET | Оповещения о ЧС |
| `/api/news` | GET | Новости NASA |
| `/api/subscribe` | POST | Подписка на уведомления |
| `/api/devices` | POST | Регистрация устройства |

### Админ API

| Endpoint | Метод | Описание |
|----------|-------|----------|
| `/api/admin/alerts` | GET/POST | Управление оповещениями |

**Пример запроса погоды:**
```bash
curl "http://localhost:8084/api/weather?lat=42.8746&lon=74.5698"
```

**Пример создания оповещения:**
```bash
curl -X POST "http://localhost:8084/api/admin/alerts?admin_key=admin123" \
  -H "Content-Type: application/json" \
  -d '{
    "type": "earthquake",
    "severity": "warning",
    "magnitude": 5.5,
    "latitude": 42.8746,
    "longitude": 74.5698,
    "message_ru": "Тестовое землетрясение"
  }'
```

## 🗄 База данных

### Основные таблицы

- **users** - Пользователи системы
- **user_devices** - Устройства для push уведомлений
- **alerts** - Оповещения о ЧС
- **subscriptions** - Подписки пользователей
- **news_items** - Новости NASA
- **audit_logs** - Логи рассылки

### Схема оповещения

```json
{
  "id": 1,
  "source": "usgs",
  "type": "earthquake",
  "magnitude": 5.2,
  "severity": "warning",
  "latitude": 42.8746,
  "longitude": 74.5698,
  "radius_km": 100,
  "message_ru": "Землетрясение магнитудой 5.2",
  "message_en": "Earthquake magnitude 5.2",
  "message_kg": "Жер титирөө магнитудасы 5.2",
  "created_at": "2024-01-01 12:00:00",
  "status": "active"
}
```

## 🔄 Автоматическое обновление данных

Для автоматического обновления данных настройте cron задачу:

```bash
# Каждые 5 минут
*/5 * * * * docker-compose exec web php /var/www/html/cron/update_data.php

# Или добавьте в crontab
crontab -e
```

## 🎯 Использование

### Для пользователей

1. **Просмотр карты рисков** - откройте главную страницу
2. **Подписка на уведомления** - заполните форму подписки
3. **Просмотр погоды** - виджет погоды обновляется автоматически
4. **Чтение новостей NASA** - прокрутите вниз до раздела новостей

### Для администраторов

1. **Откройте админ панель**: http://localhost:8084/admin
2. **Создайте тестовое оповещение** через форму
3. **Просмотрите статистику** в верхней части панели
4. **Проверьте логи рассылки** в нижней части

## 🐛 Отладка

### Просмотр логов

```bash
# Все сервисы
docker-compose logs

# Конкретный сервис
docker-compose logs web
docker-compose logs db
```

### Проверка базы данных

```bash
# Подключение к MySQL
docker-compose exec db mysql -u root -p nasaveb

# Проверка таблиц
SHOW TABLES;
SELECT COUNT(*) FROM alerts;
```

### Тестирование API

```bash
# Проверка статуса
curl http://localhost:8084/api/weather

# Проверка оповещений
curl http://localhost:8084/api/alerts
```

## 🔒 Безопасность

- Все API endpoints имеют CORS заголовки
- Админ API защищен ключом `admin123` (измените в продакшене)
- Пароли хешируются с помощью bcrypt
- Все входные данные валидируются

## 🚀 Развертывание в продакшене

1. **Измените пароли** в `docker-compose.yml`
2. **Настройте SSL** сертификаты
3. **Обновите API ключи** в `config/nasa.php`
4. **Настройте домен** в Apache конфигурации
5. **Настройте мониторинг** и логирование

## 📊 Мониторинг

- **Статус сервисов**: `docker-compose ps`
- **Использование ресурсов**: `docker stats`
- **Логи приложения**: `docker-compose logs -f web`

## 🤝 Вклад в проект

1. Форкните репозиторий
2. Создайте ветку для новой функции
3. Внесите изменения
4. Создайте Pull Request

## 📝 Лицензия

MIT License - см. файл LICENSE

## 🆘 Поддержка

Если у вас возникли проблемы:

1. Проверьте логи: `docker-compose logs`
2. Убедитесь, что все порты свободны
3. Проверьте API ключи в `config/nasa.php`
4. Создайте Issue в репозитории

## 🎉 Демо

После запуска проекта вы можете:

1. **Создать тестовое оповещение** через админ панель
2. **Подписаться на уведомления** с вашего email
3. **Просмотреть карту** с различными типами ЧС
4. **Изучить новости NASA** с красивыми изображениями

---

**Disaster Alert / TerraAlert** - Спасаем жизни через технологии! 🚨🌍