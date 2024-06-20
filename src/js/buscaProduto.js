document.getElementById('formBusca').addEventListener('submit', function(event) {
    event.preventDefault(); // Previne o comportamento padrão de envio do formulário
    
    var formData = new FormData(this); // Obtém os dados do formulário
    
    // Realiza uma requisição AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'src/php/pesquisaProdutos.php?' + new URLSearchParams(formData).toString(), true);
    
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            // Limpa o conteúdo atual de resultados
            var listaProdutos = document.querySelector('.lista');
            listaProdutos.innerHTML = '';

            // Adiciona os novos resultados
            listaProdutos.innerHTML = xhr.responseText;
        } else {
            console.error('Erro ao buscar produtos: ' + xhr.status);
        }
    };
    
    xhr.onerror = function() {
        console.error('Erro de conexão.');
    };
    
    xhr.send();
});
