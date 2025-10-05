<?php 
require_once __DIR__ . '/../config/db.php';

$TitleName = "Disaster Alert / TerraAlert - О проекте";
?>

<?php require_once __DIR__ . '/../layout/header.php' ?>
<?php require_once __DIR__ . '/../layout/nav.php' ?>

<div class="container-fluid">
    <!-- Заголовок страницы -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="hero-section">
                <h1 class="display-3 fw-bold text-center mb-4">
                    <i class="bi bi-info-circle me-3"></i>
                    <span class="translatable">О проекте</span>
                </h1>
                <p class="lead text-center text-white">
                    <span class="translatable">Спасаем жизни через технологии</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Миссия проекта -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-lg">
                <div class="card-body p-5">
                    <div class="row align-items-center">
                        <div class="col-lg-6">
                            <h2 class="display-5 fw-bold mb-4">
                                <span class="translatable">Наша миссия</span>
                            </h2>
                            <p class="lead mb-4">
                                <span class="translatable">Disaster Alert / TerraAlert — это инновационная платформа для мониторинга природных катастроф и экстремальных погодных условий в реальном времени.</span>
                            </p>
                            <p class="mb-4">
                                <span class="translatable">Мы объединяем данные от NASA, USGS, OpenWeatherMap и других авторитетных источников, чтобы предоставить пользователям актуальную информацию о потенциальных угрозах.</span>
                            </p>
                            <div class="d-flex gap-3">
                                <div class="stat-item">
                                    <h3 class="text-primary mb-0">24/7</h3>
                                    <small class="text-muted">
                                        <span class="translatable">Мониторинг</span>
                                    </small>
                                </div>
                                <div class="stat-item">
                                    <h3 class="text-success mb-0">100%</h3>
                                    <small class="text-muted">
                                        <span class="translatable">Бесплатно</span>
                                    </small>
                                </div>
                                <div class="stat-item">
                                    <h3 class="text-info mb-0">5+</h3>
                                    <small class="text-muted">
                                        <span class="translatable">Источников данных</span>
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="text-center">
                                <i class="bi bi-shield-check display-1 text-primary mb-4"></i>
                                <h4 class="mb-3">
                                    <span class="translatable">Защита через информацию</span>
                                </h4>
                                <p class="text-muted">
                                    <span class="translatable">Знание — это сила. Мы даем людям возможность быть готовыми к любым природным вызовам.</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Источники данных -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center mb-5">
                <i class="bi bi-database me-2"></i>
                <span class="translatable">Источники данных</span>
            </h2>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-rocket display-4 text-primary mb-3"></i>
                    <h5 class="card-title">
                        <span class="translatable">NASA API</span>
                    </h5>
                    <p class="card-text">
                        <span class="translatable">Космические новости, изображения Земли, данные о природных катастрофах</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-geo-alt display-4 text-danger mb-3"></i>
                    <h5 class="card-title">
                        <span class="translatable">USGS</span>
                    </h5>
                    <p class="card-text">
                        <span class="translatable">Данные о землетрясениях, вулканической активности, геологических событиях</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-cloud-sun display-4 text-info mb-3"></i>
                    <h5 class="card-title">
                        <span class="translatable">OpenWeatherMap</span>
                    </h5>
                    <p class="card-text">
                        <span class="translatable">Текущая погода, прогнозы, экстремальные погодные условия</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card h-100 text-center">
                <div class="card-body">
                    <i class="bi bi-fire display-4 text-warning mb-3"></i>
                    <h5 class="card-title">
                        <span class="translatable">NASA FIRMS</span>
                    </h5>
                    <p class="card-text">
                        <span class="translatable">Данные о пожарах, тепловых аномалиях, лесных пожарах</span>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Возможности платформы -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center mb-5">
                <i class="bi bi-gear me-2"></i>
                <span class="translatable">Возможности платформы</span>
            </h2>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-map"></i>
                </div>
                <h4 class="feature-title">
                    <span class="translatable">Интерактивная карта</span>
                </h4>
                <p class="feature-description">
                    <span class="translatable">Визуализация природных катастроф в реальном времени с возможностью фильтрации по типам событий</span>
                </p>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-bell"></i>
                </div>
                <h4 class="feature-title">
                    <span class="translatable">Push-уведомления</span>
                </h4>
                <p class="feature-description">
                    <span class="translatable">Мгновенные оповещения о критических событиях в вашем регионе</span>
                </p>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-graph-up"></i>
                </div>
                <h4 class="feature-title">
                    <span class="translatable">Аналитика данных</span>
                </h4>
                <p class="feature-description">
                    <span class="translatable">Статистика и тренды природных катастроф для научного анализа</span>
                </p>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-globe"></i>
                </div>
                <h4 class="feature-title">
                    <span class="translatable">Многоязычность</span>
                </h4>
                <p class="feature-description">
                    <span class="translatable">Поддержка русского, английского и кыргызского языков</span>
                </p>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-phone"></i>
                </div>
                <h4 class="feature-title">
                    <span class="translatable">Мобильная версия</span>
                </h4>
                <p class="feature-description">
                    <span class="translatable">Адаптивный дизайн для всех устройств с поддержкой PWA</span>
                </p>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="feature-card">
                <div class="feature-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <h4 class="feature-title">
                    <span class="translatable">Безопасность</span>
                </h4>
                <p class="feature-description">
                    <span class="translatable">Защита персональных данных и безопасная передача информации</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Технологии -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card bg-light">
                <div class="card-body p-5">
                    <h2 class="text-center mb-5">
                        <i class="bi bi-code-slash me-2"></i>
                        <span class="translatable">Технологический стек</span>
                    </h2>
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="tech-item">
                                <i class="fab fa-php display-4 text-primary mb-3"></i>
                                <h5>PHP 8.2</h5>
                                <p class="text-muted">
                                    <span class="translatable">Серверная логика и API</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="tech-item">
                                <i class="fas fa-database display-4 text-success mb-3"></i>
                                <h5>MySQL 8.0</h5>
                                <p class="text-muted">
                                    <span class="translatable">База данных</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="tech-item">
                                <i class="fab fa-js-square display-4 text-warning mb-3"></i>
                                <h5>JavaScript</h5>
                                <p class="text-muted">
                                    <span class="translatable">Клиентская логика</span>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="tech-item">
                                <i class="fab fa-docker display-4 text-info mb-3"></i>
                                <h5>Docker</h5>
                                <p class="text-muted">
                                    <span class="translatable">Контейнеризация</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Контактная форма -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title mb-0">
                        <i class="bi bi-envelope me-2"></i>
                        <span class="translatable">Свяжитесь с нами</span>
                    </h3>
                </div>
                <div class="card-body">
                    <form id="contact-form">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="contact-name" class="form-label">
                                    <span class="translatable">Имя</span>
                                </label>
                                <input type="text" class="form-control" id="contact-name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="contact-email" class="form-label">
                                    <span class="translatable">Email</span>
                                </label>
                                <input type="email" class="form-control" id="contact-email" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="contact-subject" class="form-label">
                                <span class="translatable">Тема</span>
                            </label>
                            <input type="text" class="form-control" id="contact-subject" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact-message" class="form-label">
                                <span class="translatable">Сообщение</span>
                            </label>
                            <textarea class="form-control" id="contact-message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-send me-2"></i>
                            <span class="translatable">Отправить сообщение</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Команда -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="text-center mb-5">
                <i class="bi bi-people me-2"></i>
                <span class="translatable">Команда проекта</span>
            </h2>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="team-card">
                <div class="team-avatar">
                    <i class="bi bi-person-circle display-1"></i>
                </div>
                <h4 class="team-name">
                    <span class="translatable">Разработчики</span>
                </h4>
                <p class="team-role">
                    <span class="translatable">Full Stack разработка</span>
                </p>
                <p class="team-description">
                    <span class="translatable">Создание и поддержка платформы</span>
                </p>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="team-card">
                <div class="team-avatar">
                    <i class="bi bi-shield-check display-1"></i>
                </div>
                <h4 class="team-name">
                    <span class="translatable">Эксперты</span>
                </h4>
                <p class="team-role">
                    <span class="translatable">Специалисты по ЧС</span>
                </p>
                <p class="team-description">
                    <span class="translatable">Консультации по безопасности</span>
                </p>
            </div>
        </div>
        <div class="col-lg-4 mb-4">
            <div class="team-card">
                <div class="team-avatar">
                    <i class="bi bi-graph-up display-1"></i>
                </div>
                <h4 class="team-name">
                    <span class="translatable">Аналитики</span>
                </h4>
                <p class="team-role">
                    <span class="translatable">Обработка данных</span>
                </p>
                <p class="team-description">
                    <span class="translatable">Анализ и интерпретация данных</span>
                </p>
            </div>
        </div>
    </div>
</div>

<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 4rem 2rem;
    border-radius: 20px;
    margin-bottom: 3rem;
}

.stat-item {
    text-align: center;
    padding: 1rem;
}

.feature-card {
    text-align: center;
    padding: 2rem;
    border-radius: 15px;
    transition: all 0.3s ease;
    height: 100%;
}

.feature-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: white;
    font-size: 2rem;
}

.feature-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: #333;
}

.feature-description {
    color: #666;
    line-height: 1.6;
}

.tech-item {
    text-align: center;
    padding: 1.5rem;
    border-radius: 10px;
    transition: all 0.3s ease;
}

.tech-item:hover {
    background: #f8f9fa;
    transform: translateY(-2px);
}

.team-card {
    text-align: center;
    padding: 2rem;
    border-radius: 15px;
    background: #f8f9fa;
    transition: all 0.3s ease;
}

.team-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.team-avatar {
    margin-bottom: 1.5rem;
    color: #667eea;
}

.team-name {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: #333;
}

.team-role {
    font-weight: 600;
    color: #667eea;
    margin-bottom: 1rem;
}

.team-description {
    color: #666;
    line-height: 1.6;
}

.contact-form {
    max-width: 800px;
    margin: 0 auto;
}

@media (max-width: 768px) {
    .hero-section {
        padding: 2rem 1rem;
    }
    
    .feature-card,
    .team-card {
        margin-bottom: 2rem;
    }
}
</style>

<script>
// Обработка контактной формы
document.getElementById('contact-form').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const name = document.getElementById('contact-name').value;
    const email = document.getElementById('contact-email').value;
    const subject = document.getElementById('contact-subject').value;
    const message = document.getElementById('contact-message').value;
    
    // Простая валидация
    if (!name || !email || !subject || !message) {
        alert('Пожалуйста, заполните все поля');
        return;
    }
    
    // Отправка данных (в реальном проекте здесь будет AJAX запрос)
    fetch('/api/contact', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            name: name,
            email: email,
            subject: subject,
            message: message
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Сообщение успешно отправлено!');
            document.getElementById('contact-form').reset();
        } else {
            alert('Ошибка отправки сообщения: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Ошибка:', error);
        alert('Ошибка отправки сообщения');
    });
});

// Анимация появления элементов при скролле
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver(function(entries) {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
        }
    });
}, observerOptions);

// Наблюдаем за элементами
document.addEventListener('DOMContentLoaded', function() {
    const animatedElements = document.querySelectorAll('.feature-card, .tech-item, .team-card');
    
    animatedElements.forEach(element => {
        element.style.opacity = '0';
        element.style.transform = 'translateY(30px)';
        element.style.transition = 'all 0.6s ease';
        observer.observe(element);
    });
});
</script>

<?php require_once __DIR__ . '/../layout/footer.php' ?>
