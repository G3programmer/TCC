// Pegar o botão de "Assine agora!" e a div de plano
const btnAssinar = document.getElementById('plano');
const confirmPlanDiv = document.getElementById('confirmPlan');
const cancelBtn = document.getElementById('cancelBtn');

// Adicionar evento de clique ao botão para exibir a div
btnAssinar.addEventListener('click', function(event) {
    event.preventDefault(); // Previne o envio do formulário ou comportamento padrão
    confirmPlanDiv.style.display = 'grid'; // Exibe a div de planos
});


// Adicionar evento de clique ao botão de cancelar para ocultar a div
cancelBtn.addEventListener('click', function() {
    confirmPlanDiv.style.display = 'none'; // Esconde a div de planos
});

document.querySelectorAll('.selectPlanBtn').forEach(button => {
    button.addEventListener('click', function() {
        const planId = this.getAttribute('data-plan-id');
        // Redireciona para checkout.php passando o ID do plano
        window.location.href = 'checkout.php?plan_id=' + planId;
    });
});