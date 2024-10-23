document.addEventListener('DOMContentLoaded', function() {
    // Seleciona os elementos do DOM
    const planoBtn = document.getElementById('plano');
    const confirmPlan = document.getElementById('confirmPlan');
    const overlay = document.querySelector('.overlay');
    const cancelBtn = document.getElementById('cancelBtn');

    // Adiciona um evento de clique ao botão "Assine agora!"
    planoBtn.addEventListener('click', function(e) {
        e.preventDefault(); // Impede o comportamento padrão do botão
        confirmPlan.style.display = 'block'; // Mostra a div de confirmação
        overlay.style.display = 'block'; // Mostra o fundo escuro
    });

    // Adiciona um evento de clique ao botão "Cancelar"
    cancelBtn.addEventListener('click', function() {
        confirmPlan.style.display = 'none'; // Esconde a div de confirmação
        overlay.style.display = 'none'; // Esconde o fundo escuro
    });
});
