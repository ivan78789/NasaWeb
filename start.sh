#!/bin/bash

echo "🚀 Запуск Disaster Alert / TerraAlert"
echo "======================================"

# Проверяем наличие Docker
if ! command -v docker &> /dev/null; then
    echo "❌ Docker не установлен. Установите Docker и попробуйте снова."
    exit 1
fi

# Проверяем наличие Docker Compose
if ! command -v docker-compose &> /dev/null; then
    echo "❌ Docker Compose не установлен. Установите Docker Compose и попробуйте снова."
    exit 1
fi

echo "✅ Docker и Docker Compose найдены"

# Останавливаем существующие контейнеры
echo "🛑 Останавливаем существующие контейнеры..."
docker-compose down

# Собираем и запускаем контейнеры
echo "🔨 Собираем и запускаем контейнеры..."
docker-compose up -d --build

# Ждем запуска базы данных
echo "⏳ Ждем запуска базы данных..."
sleep 30

# Проверяем статус контейнеров
echo "📊 Статус контейнеров:"
docker-compose ps

# Добавляем тестовые данные
echo "🌱 Добавляем тестовые данные..."
docker-compose exec web php database/seed.php

echo ""
echo "🎉 Проект успешно запущен!"
echo ""
echo "📱 Доступные URL:"
echo "   • Основной сайт: http://localhost:8084"
echo "   • Админ панель: http://localhost:8084/admin"
echo "   • phpMyAdmin: http://localhost:8085"
echo ""
echo "🔧 Полезные команды:"
echo "   • Просмотр логов: docker-compose logs -f"
echo "   • Остановка: docker-compose down"
echo "   • Перезапуск: docker-compose restart"
echo ""
echo "⚠️  Не забудьте настроить API ключи в config/nasa.php"
echo ""
