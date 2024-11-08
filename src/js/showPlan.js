document.addEventListener('DOMContentLoaded', function() {
    // Seleciona os elementos do DOM
    const planoBtns = document.querySelectorAll('.btn-assinar'); // Atualize para .btn-assinar
    const confirmPlan = document.getElementById('confirmPlan');
    const overlay = document.querySelector('.overlay');
    const cancelBtn = document.getElementById('cancelBtn');

    // Adiciona um evento de clique a todos os botões "Assinar Plano"
    planoBtns.forEach(planoBtn => {
        planoBtn.addEventListener('click', function(e) {
            e.preventDefault(); // Impede o comportamento padrão do botão
            confirmPlan.style.display = 'block'; // Mostra a div de confirmação
            overlay.style.display = 'block'; // Mostra o fundo escuro
        });
    });

    // Adiciona um evento de clique ao botão "Cancelar"
    if (cancelBtn) {
        cancelBtn.addEventListener('click', function() {
            confirmPlan.style.display = 'none'; // Esconde a div de confirmação
            overlay.style.display = 'none'; // Esconde o fundo escuro
        });
    }
});
