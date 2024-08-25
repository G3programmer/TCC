function fetchCities(estadoId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "../php/fetch_cities.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('cidade').innerHTML = xhr.responseText;
        }
    };
    xhr.send("estado_id=" + estadoId);
}

document.addEventListener("DOMContentLoaded", function() {
    document.getElementById('estado').addEventListener('change', function() {
        var estadoId = this.value;
        fetchCities(estadoId);
    });
});