document.addEventListener("DOMContentLoaded", function() {
    var image = document.querySelector('.imagem-fundo');
    setTimeout(function() {
        image.classList.add('show');
    }, 1000); // Ajuste o tempo conforme necessário
});