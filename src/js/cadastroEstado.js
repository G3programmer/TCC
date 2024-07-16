document.addEventListener('DOMContentLoaded', function() {
    fetch('get_estados.php')
        .then(response => response.json())
        .then(data => {
            const estadoSelect = document.getElementById('estado');
            data.forEach(estado => {
                const option = document.createElement('option');
                option.value = estado.estado_id;
                option.textContent = estado.nome;
                estadoSelect.appendChild(option);
            });
        });
});