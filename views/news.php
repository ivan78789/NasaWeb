<?php 
require_once __DIR__ . '/../config/db.php';

$TitleName = "Disaster Alert / TerraAlert - Новости";
?>

<?php require_once __DIR__ . '/../layout/header.php' ?>
<?php require_once __DIR__ . '/../layout/nav.php' ?>

<div class="container-fluid">
    <!-- Заголовок страницы -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="hero-section">
                <h1 class="display-4 fw-bold text-center mb-3">
                    <i class="bi bi-newspaper me-3"></i>
                    <span class="translatable">Новости о планете</span>
                </h1>
                <p class="lead text-center text-muted">
                    <span class="translatable">Последние новости о природных катастрофах, космосе и экологии</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Фильтры -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="mb-0">
                                <span class="translatable">Фильтры</span>
                            </h5>
                        </div>
                        <div class="col-md-6">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary active" data-filter="all">
                                    <span class="translatable">Все</span>
                                </button>
                                <button type="button" class="btn btn-outline-primary" data-filter="earth">
                                    <i class="bi bi-globe me-1"></i>
                                    <span class="translatable">Земля</span>
                                </button>
                                <button type="button" class="btn btn-outline-primary" data-filter="space">
                                    <i class="bi bi-rocket me-1"></i>
                                    <span class="translatable">Космос</span>
                                </button>
                                <button type="button" class="btn btn-outline-primary" data-filter="weather">
                                    <i class="bi bi-cloud-sun me-1"></i>
                                    <span class="translatable">Погода</span>
                                </button>
                                <button type="button" class="btn btn-outline-primary" data-filter="disaster">
                                    <i class="bi bi-exclamation-triangle me-1"></i>
                                    <span class="translatable">Катастрофы</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Загрузка новостей -->
    <div class="row" id="news-container">
        <div class="col-12 text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Загрузка...</span>
            </div>
            <p class="mt-3 text-muted">
                <span class="translatable">Загружаем новости...</span>
            </p>
        </div>
    </div>

    <!-- Кнопка "Загрузить еще" -->
    <div class="row mt-4" id="load-more-container" style="display: none;">
        <div class="col-12 text-center">
            <button class="btn btn-outline-primary btn-lg" id="load-more-btn">
                <i class="bi bi-arrow-clockwise me-2"></i>
                <span class="translatable">Загрузить еще</span>
            </button>
        </div>
    </div>
</div>

<!-- Модальное окно для детального просмотра новости -->
<div class="modal fade" id="newsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newsModalTitle"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="newsModalContent"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <span class="translatable">Закрыть</span>
                </button>
                <a href="#" class="btn btn-primary" id="newsModalLink" target="_blank">
                    <span class="translatable">Читать полностью</span>
                </a>
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

.news-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
}

.news-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.news-card .card-img-top {
    height: 200px;
    object-fit: cover;
    border-radius: 10px 10px 0 0;
}

.news-card .card-body {
    padding: 1.5rem;
}

.news-category {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 1rem;
}

.news-category.earth {
    background: #e8f5e8;
    color: #2d5a2d;
}

.news-category.space {
    background: #e3f2fd;
    color: #1565c0;
}

.news-category.weather {
    background: #fff3e0;
    color: #ef6c00;
}

.news-category.disaster {
    background: #ffebee;
    color: #c62828;
}

.news-title {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 0.75rem;
    line-height: 1.4;
}

.news-summary {
    color: #666;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.news-meta {
    display: flex;
    justify-content: between;
    align-items: center;
    font-size: 0.9rem;
    color: #888;
}

.news-date {
    margin-right: auto;
}

.news-source {
    font-weight: 600;
    color: #007bff;
}

.fade-in {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.loading-skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
</style>

<script>
let currentFilter = 'all';
let currentPage = 1;
let isLoading = false;

// Инициализация при загрузке страницы
document.addEventListener('DOMContentLoaded', function() {
    loadNews();
    setupFilters();
    setupLoadMore();
});

// Настройка фильтров
function setupFilters() {
    const filterButtons = document.querySelectorAll('[data-filter]');
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Убираем активный класс со всех кнопок
            filterButtons.forEach(btn => btn.classList.remove('active'));
            // Добавляем активный класс к текущей кнопке
            this.classList.add('active');
            
            // Устанавливаем новый фильтр
            currentFilter = this.dataset.filter;
            currentPage = 1;
            
            // Загружаем новости с новым фильтром
            loadNews();
        });
    });
}

// Настройка кнопки "Загрузить еще"
function setupLoadMore() {
    const loadMoreBtn = document.getElementById('load-more-btn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            currentPage++;
            loadNews(true);
        });
    }
}

// Загрузка новостей
async function loadNews(append = false) {
    if (isLoading) return;
    
    isLoading = true;
    
    try {
        // Показываем скелетон загрузки
        if (!append) {
            showLoadingSkeleton();
        }
        
        const response = await fetch(`/api/news?lang=ru&limit=12&page=${currentPage}&filter=${currentFilter}`);
        const data = await response.json();
        
        if (data.status === 'success') {
            displayNews(data.data, append);
        } else {
            showError('Ошибка загрузки новостей: ' + data.message);
        }
    } catch (error) {
        console.error('Ошибка загрузки новостей:', error);
        showError('Ошибка загрузки новостей');
    } finally {
        isLoading = false;
    }
}

// Показать скелетон загрузки
function showLoadingSkeleton() {
    const container = document.getElementById('news-container');
    container.innerHTML = '';
    
    for (let i = 0; i < 6; i++) {
        const skeletonCard = document.createElement('div');
        skeletonCard.className = 'col-md-6 col-lg-4 mb-4';
        skeletonCard.innerHTML = `
            <div class="card news-card">
                <div class="card-img-top loading-skeleton" style="height: 200px;"></div>
                <div class="card-body">
                    <div class="loading-skeleton" style="height: 20px; margin-bottom: 10px;"></div>
                    <div class="loading-skeleton" style="height: 16px; margin-bottom: 8px;"></div>
                    <div class="loading-skeleton" style="height: 16px; width: 60%;"></div>
                </div>
            </div>
        `;
        container.appendChild(skeletonCard);
    }
}

// Отображение новостей
function displayNews(news, append = false) {
    const container = document.getElementById('news-container');
    
    if (!append) {
        container.innerHTML = '';
    }
    
    if (news.length === 0) {
        if (!append) {
            container.innerHTML = `
                <div class="col-12 text-center">
                    <div class="py-5">
                        <i class="bi bi-newspaper display-1 text-muted"></i>
                        <h3 class="mt-3 text-muted">
                            <span class="translatable">Новости не найдены</span>
                        </h3>
                        <p class="text-muted">
                            <span class="translatable">Попробуйте изменить фильтр или зайти позже</span>
                        </p>
                    </div>
                </div>
            `;
        }
        return;
    }
    
    news.forEach((item, index) => {
        const newsCard = createNewsCard(item);
        newsCard.style.animationDelay = `${index * 0.1}s`;
        container.appendChild(newsCard);
    });
    
    // Показываем кнопку "Загрузить еще" если есть еще новости
    if (news.length >= 12) {
        document.getElementById('load-more-container').style.display = 'block';
    } else {
        document.getElementById('load-more-container').style.display = 'none';
    }
}

// Создание карточки новости
function createNewsCard(item) {
    const col = document.createElement('div');
    col.className = 'col-md-6 col-lg-4 mb-4 fade-in';
    
    const categoryClass = getCategoryClass(item.category || item.source);
    const categoryName = getCategoryName(item.category || item.source);
    
    col.innerHTML = `
        <div class="card news-card h-100">
            ${item.media_url ? `
                <img src="${item.media_url}" class="card-img-top" alt="${item.title_ru || item.title}">
            ` : `
                <div class="card-img-top d-flex align-items-center justify-content-center bg-light">
                    <i class="bi bi-image display-4 text-muted"></i>
                </div>
            `}
            <div class="card-body d-flex flex-column">
                <div class="news-category ${categoryClass}">${categoryName}</div>
                <h5 class="news-title">${item.title_ru || item.title || 'Без заголовка'}</h5>
                <p class="news-summary flex-grow-1">${item.summary_ru || item.summary || item.description || 'Описание недоступно'}</p>
                <div class="news-meta">
                    <span class="news-date">
                        <i class="bi bi-calendar me-1"></i>
                        ${formatDate(item.published_at || item.created_at)}
                    </span>
                    <span class="news-source">${item.source || 'NASA'}</span>
                </div>
                <button class="btn btn-outline-primary btn-sm mt-3" onclick="showNewsModal(${item.id})">
                    <span class="translatable">Подробнее</span>
                </button>
            </div>
        </div>
    `;
    
    return col;
}

// Получить класс категории
function getCategoryClass(category) {
    const categoryMap = {
        'earth': 'earth',
        'space': 'space', 
        'weather': 'weather',
        'disaster': 'disaster',
        'nasa': 'space',
        'earthquake': 'disaster',
        'fire': 'disaster',
        'storm': 'weather'
    };
    return categoryMap[category] || 'earth';
}

// Получить название категории
function getCategoryName(category) {
    const nameMap = {
        'earth': 'Земля',
        'space': 'Космос',
        'weather': 'Погода', 
        'disaster': 'Катастрофы',
        'nasa': 'NASA',
        'earthquake': 'Землетрясения',
        'fire': 'Пожары',
        'storm': 'Штормы'
    };
    return nameMap[category] || 'Новости';
}

// Форматирование даты
function formatDate(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('ru-RU', {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
    });
}

// Показать модальное окно с новостью
function showNewsModal(newsId) {
    // Здесь можно загрузить полную информацию о новости
    // Пока что просто показываем модальное окно
    const modal = new bootstrap.Modal(document.getElementById('newsModal'));
    modal.show();
}

// Показать ошибку
function showError(message) {
    const container = document.getElementById('news-container');
    container.innerHTML = `
        <div class="col-12 text-center">
            <div class="alert alert-danger">
                <i class="bi bi-exclamation-triangle me-2"></i>
                ${message}
            </div>
        </div>
    `;
}
</script>

<?php require_once __DIR__ . '/../layout/footer.php' ?>
