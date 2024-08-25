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

