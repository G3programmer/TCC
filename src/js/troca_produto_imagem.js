document.querySelectorAll('.imagem img').forEach(img => {
    img.addEventListener('click', function() {
        const cartao = this.closest('.cartao');
        document.querySelectorAll('.cartao').forEach(c => c.classList.remove('ativo'));
        cartao.classList.add('ativo');
    });
});