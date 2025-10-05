    </div>
    
    <!-- Footer -->
    <footer class="bg-dark text-light py-5 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <h5 class="text-white mb-3">
                        <i class="bi bi-shield-check me-2"></i>
                        <span class="translatable">Disaster Alert</span>
                    </h5>
                    <p class="text-muted">
                        <span class="translatable">Мониторинг природных катастроф в реальном времени. Спасаем жизни через технологии.</span>
                    </p>
                    <div class="d-flex gap-3">
                        <a href="#" class="text-light">
                            <i class="bi bi-twitter"></i>
                        </a>
                        <a href="#" class="text-light">
                            <i class="bi bi-facebook"></i>
                        </a>
                        <a href="#" class="text-light">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="#" class="text-light">
                            <i class="bi bi-github"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white mb-3">
                        <span class="translatable">Навигация</span>
                    </h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/" class="text-muted text-decoration-none">
                            <span class="translatable">Главная</span>
                        </a></li>
                        <li class="mb-2 text-white"><a href="/news" class="text-muted text-decoration-none">
                            <span class="translatable">Новости</span>
                        </a></li>
                        <li class="mb-2"><a href="/map" class="text-muted text-decoration-none">
                            <span class="translatable">Карта</span>
                        </a></li>
                        <li class="mb-2"><a href="/weather" class="text-muted text-decoration-none">
                            <span class="translatable">Погода</span>
                        </a></li>
                    </ul>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <h6 class="text-white mb-3">
                        <span class="translatable">Информация</span>
                    </h6>
                    <ul class="list-unstyled">
                        <li class="mb-2"><a href="/about" class="text-muted text-decoration-none">
                            <span class="translatable">О проекте</span>
                        </a></li>
                        <li class="mb-2"><a href="/visualization" class="text-muted text-decoration-none">
                            <span class="translatable">Аналитика</span>
                        </a></li>
                        <li class="mb-2"><a href="/subscribe" class="text-muted text-decoration-none">
                            <span class="translatable">Подписка</span>
                        </a></li>
                    </ul>
                </div>
                <div class="col-lg-4 mb-4">
                    <h6 class="text-white mb-3">
                        <span class="translatable">Контакты</span>
                    </h6>
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-envelope me-2"></i>
                        <span class="text-muted">info@terraalert.kg</span>
                    </div>
                    <div class="d-flex align-items-center mb-2">
                        <i class="bi bi-telephone me-2"></i>
                        <span class="text-muted">+996 (555) 123-456</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-geo-alt me-2"></i>
                        <span class="text-muted">
                            <span class="translatable">Бишкек, Кыргызстан</span>
                        </span>
                    </div>
                </div>
            </div>
            <hr class="my-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="text-muted mb-0">
                        © 2024 Disaster Alert / TerraAlert. 
                        <span class="translatable">Все права защищены.</span>
                    </p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p class="text-muted mb-0">
                        <span class="translatable">Сделано с ❤️ для безопасности людей</span>
                    </p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- PWA Service Worker -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js')
                    .then(function(registration) {
                        console.log('ServiceWorker registration successful');
                    })
                    .catch(function(err) {
                        console.log('ServiceWorker registration failed');
                    });
            });
        }
    </script>
    
    <!-- Custom JavaScript -->
    <script>
        // Анимация появления элементов при скролле
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in-up');
                }
            });
        }, observerOptions);
        
        // Наблюдаем за элементами при загрузке страницы
        document.addEventListener('DOMContentLoaded', function() {
            const animatedElements = document.querySelectorAll('.card, .hero-section, .stat-item');
            animatedElements.forEach(element => {
                observer.observe(element);
            });
        });
        
        // Плавная прокрутка для якорных ссылок
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>