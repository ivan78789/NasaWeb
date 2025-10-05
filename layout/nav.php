<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container">
        <a class="navbar-brand fw-bold" href="/">
            <i class="bi bi-shield-check me-2"></i>
            <span class="translatable">Disaster Alert</span>
        </a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">
                        <i class="bi bi-house me-1"></i>
                        <span class="translatable">Главная</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/news">
                        <i class="bi bi-newspaper me-1"></i>
                        <span class="translatable">Новости</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/map">
                        <i class="bi bi-map me-1"></i>
                        <span class="translatable">Карта</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/weather">
                        <i class="bi bi-cloud-sun me-1"></i>
                        <span class="translatable">Погода</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/visualization">
                        <i class="bi bi-graph-up me-1"></i>
                        <span class="translatable">Аналитика</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/about">
                        <i class="bi bi-info-circle me-1"></i>
                        <span class="translatable">О проекте</span>
                    </a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-globe me-1"></i>
                        <span class="translatable">Язык</span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#" onclick="changeLanguage('ru')">
                            <i class="bi bi-flag me-1"></i>Русский
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="changeLanguage('en')">
                            <i class="bi bi-flag me-1"></i>English
                        </a></li>
                        <li><a class="dropdown-item" href="#" onclick="changeLanguage('kg')">
                            <i class="bi bi-flag me-1"></i>Кыргызча
                        </a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/subscribe">
                        <i class="bi bi-bell me-1"></i>
                        <span class="translatable">Подписка</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
// Функция смены языка
function changeLanguage(lang) {
    // Сохраняем выбранный язык в localStorage
    localStorage.setItem('selectedLanguage', lang);
    
    // Обновляем страницу для применения языка
    location.reload();
}

// Загружаем сохраненный язык при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    const savedLang = localStorage.getItem('selectedLanguage') || 'ru';
    
    // Здесь можно добавить логику для применения языка
    // Например, скрытие/показ элементов в зависимости от языка
    console.log('Текущий язык:', savedLang);
});
</script>