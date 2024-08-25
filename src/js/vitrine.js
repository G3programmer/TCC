const track = document.querySelector('.carrossel-track');
const slides = Array.from(track.children);
const nextButton = document.querySelector('.next');
const prevButton = document.querySelector('.prev');
let currentIndex = 0;

function updateSlide() {
    const slideWidth = track.getBoundingClientRect().width / 2;
    track.style.transform = 'translateX(-' + currentIndex * slideWidth + 'px)';
}

function nextSlide() {
    if (currentIndex < Math.ceil(slides.length / 3) - 1) {
        currentIndex++;
    } else {
        currentIndex = 0;
    }
    updateSlide();
}

function prevSlide() {
    if (currentIndex > 0) {
        currentIndex--;
    } else {
        currentIndex = Math.ceil(slides.length / 3) - 1;
    }
    updateSlide();
}

window.addEventListener('resize', () => {
    updateSlide();
});

updateSlide();