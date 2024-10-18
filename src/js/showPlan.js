document.addEventListener('DOMContentLoaded', () => {
    const planButtons = document.querySelectorAll('.btn-customizado');

    planButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            event.preventDefault(); // Impede o envio do formulário
            const form = event.target.closest('form');
            const produtoId = form.querySelector('input[name="produto_id"]').value;
            const nomePlano = form.querySelector('input[name="nome_plano"]').value;

            // Armazena as informações no localStorage ou em variáveis para uso posterior
            localStorage.setItem('produto_id', produtoId);
            localStorage.setItem('nome_plano', nomePlano);

            // Exibe a div de planos
            document.getElementById('confirmPlan').style.display = 'block';
            document.querySelector('.overlay').style.display = 'block';
        });
    });

    // Fecha a div de planos se o overlay for clicado
    document.getElementById("cancelBtn").addEventListener("click", function() {
        // Esconder a div de confirmação
        document.getElementById("confirmPlan").style.display = "none";
        // Esconder o fundo escuro
        document.querySelector(".overlay").style.display = "none";
    });})