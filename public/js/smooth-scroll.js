/**
 * Файл для управления плавной прокруткой на сайте
 */
document.addEventListener('DOMContentLoaded', function() {
    console.log('Smooth scroll initialized');
    
    // Автоматическая прокрутка к основному контенту при загрузке страницы
    scrollToMainContent();
    
    // Плавная прокрутка для всех внутренних ссылок
    setupSmoothScrolling();
    
    // Добавим обработку для пунктов меню
    setupMenuScrolling();
});

/**
 * Настраивает обработчики для пунктов меню
 */
function setupMenuScrolling() {
    // Находим все ссылки в главном меню
    const menuLinks = document.querySelectorAll('.top-right-menu a, .top-menu a, footer .f-menu a');
    
    menuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Получаем href ссылки
            const href = this.getAttribute('href');
            
            // Если это не внутренняя ссылка или если она указывает на якорь, 
            // то передаем обработку setupSmoothScrolling
            if (!href || href.startsWith('#') || href === '/') return;
            
            // Сохраняем URL для навигации с плавной прокруткой при загрузке страницы
            localStorage.setItem('smoothScrollTarget', 'true');
        });
    });
}

/**
 * Прокручивает к основному содержимому страницы в зависимости от её типа
 */
function scrollToMainContent() {
    // Определяем текущую страницу по URL
    const currentPath = window.location.pathname;
    console.log('Current path:', currentPath);
    
    // Проверяем, было ли переключение между страницами
    const shouldScroll = localStorage.getItem('smoothScrollTarget') === 'true';
    
    // Очищаем флаг плавной прокрутки
    localStorage.removeItem('smoothScrollTarget');
    
    // Если не было переключения между страницами, прекращаем выполнение
    if (!shouldScroll && currentPath === '/') return;
    
    // Небольшая задержка для корректной работы после полной загрузки страницы
    setTimeout(() => {
        let targetElement = null;
        
        // В зависимости от страницы, выбираем целевой элемент для скролла
        if (currentPath.includes('/tours')) {
            // Страница тура
            targetElement = document.querySelector('.tour-header');
        } else if (currentPath.includes('/schedule')) {
            // Страница расписания
            targetElement = document.querySelector('.schedule-content');
        } else if (currentPath.includes('/excursions')) {
            // Страница экскурсий
            targetElement = document.querySelector('.excursions-list');
        } else if (currentPath.includes('/contacts')) {
            // Страница контактов
            targetElement = document.querySelector('.contacts-container');
        } else if (currentPath.includes('/tourists')) {
            // Страница для туристов
            targetElement = document.querySelector('.tourist-info');
        } else if (currentPath.includes('/calculate')) {
            // Страница калькулятора
            targetElement = document.querySelector('.calculator-container');
        } else {
            // Если не нашли специфичный элемент, ищем общий контейнер контента
            targetElement = document.querySelector('main .max') ||
                           document.querySelector('main');
        }
        
        // Если нашли целевой элемент, скроллим к нему
        if (targetElement) {
            console.log('Scrolling to:', targetElement);
            
            // Получаем высоту хедера для правильного позиционирования
            const headerHeight = document.querySelector('header') ? 
                document.querySelector('header').offsetHeight : 0;
            
            const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
            const offsetPosition = targetPosition - headerHeight - 20; // Дополнительный отступ для комфорта
            
            window.scrollTo({
                top: offsetPosition,
                behavior: 'smooth'
            });
        } else {
            console.log('Target element not found for auto-scrolling');
        }
    }, 500); // Полсекунды задержки, чтобы страница полностью загрузилась
}

/**
 * Настраивает плавную прокрутку для всех внутренних ссылок
 */
function setupSmoothScrolling() {
    // Находим все ссылки на странице
    const links = document.querySelectorAll('a[href^="#"]');
    
    // Для каждой ссылки добавляем обработчик для плавной прокрутки
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            // Если ссылка указывает на якорь на текущей странице
            if (this.getAttribute('href').startsWith('#')) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                if (targetId === '#') return; // Игнорируем пустые якоря
                
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    // Высота хедера для корректного позиционирования
                    const headerHeight = document.querySelector('header') ? 
                        document.querySelector('header').offsetHeight : 0;
                    
                    const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset;
                    const offsetPosition = targetPosition - headerHeight - 20;
                    
                    window.scrollTo({
                        top: offsetPosition,
                        behavior: 'smooth'
                    });
                }
            }
        });
    });
} 