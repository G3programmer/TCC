window.onload = function () {
    const slideContainer = document.querySelector('.slide');
    const slides = document.querySelectorAll('.slide img');
    let currentSlide = 0;

    setInterval(() => {
        currentSlide = (currentSlide + 1) % slides.length;
        slideContainer.style.transform = `translateX(-${currentSlide * 100}%)`;
    }, 5000); // Altera o slide a cada 5 segundos
};