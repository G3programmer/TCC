window.onload = function () {
    const slideContainer = document.querySelector('.slide');
    const slides = document.querySelectorAll('.slide img');
    const slideIndicatorsContainer = document.querySelector('.slide-indicators');
    let currentSlide = 0;

    const showSlide = (index) => {
        slideContainer.style.transition = 'transform 1s ease';
        slideContainer.style.transform = `translateX(-${index * 100}%)`;
        updateIndicators(index);
    };

    const updateIndicators = (index) => {
        const indicators = document.querySelectorAll('.slide-indicator');
        indicators.forEach((indicator, i) => {
            if (i === index) {
                indicator.classList.add('active');
            } else {
                indicator.classList.remove('active');
            }
        });
    };

    // Criando indicadores para cada slide
    slides.forEach((slide, index) => {
        const indicator = document.createElement('div');
        indicator.classList.add('slide-indicator');
        if (index === 0) indicator.classList.add('active');
        indicator.addEventListener('click', () => {
            showSlide(index);
        });
        slideIndicatorsContainer.appendChild(indicator);
    });

    setInterval(() => {
        currentSlide = (currentSlide + 1) % slides.length;
        showSlide(currentSlide);
    }, 5000); // Altera o slide a cada 5 segundos

    // Exibir o primeiro slide ao carregar a página
    showSlide(currentSlide);
};
