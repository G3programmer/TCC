let currentIndex = 0;
const itemsToShow = 3; // Altere o número de itens que deseja mostrar
const track = document.querySelector('.carousel-track');
const items = document.querySelectorAll('.carousel-item');
const totalItems = items.length;

function updateCarousel() {
    const itemWidth = items[0].clientWidth;
    track.style.transform = `translateX(${-itemWidth * currentIndex}px)`;
}

function nextSlide() {
    if (currentIndex < totalItems - itemsToShow) {
        currentIndex++;
    } else {
        currentIndex = 0;
    }
    updateCarousel();
}

function prevSlide() {
    if (currentIndex > 0) {
        currentIndex--;
    } else {
        currentIndex = totalItems - itemsToShow;
    }
    updateCarousel();
}

// Inicialize o carrossel na posição inicial
updateCarousel();
