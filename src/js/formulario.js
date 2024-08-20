// src/js/form-multi-step.js

document.addEventListener('DOMContentLoaded', () => {
    const nextBtn = document.querySelector('.next-btn');
    const prevBtn = document.querySelector('.prev-btn');
    const formSteps = document.querySelectorAll('.form-step');
    
    let formStepsNum = 0;
    
    nextBtn.addEventListener('click', () => {
        formSteps[formStepsNum].classList.remove('form-step-active');
        formStepsNum++;
        formSteps[formStepsNum].classList.add('form-step-active');
    });
    
    prevBtn.addEventListener('click', () => {
        formSteps[formStepsNum].classList.remove('form-step-active');
        formStepsNum--;
        formSteps[formStepsNum].classList.add('form-step-active');
    });
});


function fetchCities(estadoId) {
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "src/php/fetch_cities.php", true);
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