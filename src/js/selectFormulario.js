document.getElementById('estado').addEventListener('change', function() {
    const estadoId = this.value;
    const cidadeSelect = document.getElementById('cidade');

    if (estadoId) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'src/php/fetch_cities.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        xhr.onload = function() {
            if (this.status === 200) {
                cidadeSelect.innerHTML = this.responseText;
            }
        };

        xhr.send('estado_id=' + estadoId);
    } else {
        cidadeSelect.innerHTML = '<option value="">Selecione uma cidade</option>';
    }
});
