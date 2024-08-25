document.addEventListener("DOMContentLoaded", function() {
    fetch('../php/cadastro.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('estado').innerHTML += data;
        })
        .catch(error => console.error('Error fetching estados:', error));
});

(function(win,doc){
    'use strict';

    doc.querySelector('#estado').addEventListener('change',async(e)=>{
       let reqs = await fetch('../php/controllers/cidadeController.php',{
           method:'post',
           headers:{
               'Content-Type':'application/x-www-form-urlencoded'
           },
           body:`estado=${e.target.value}`
       });
       let ress = await reqs.json();
       let selCidade = doc.querySelector('#cidade');
       selCidade.options.length = 1;
       ress.map((elem,ind,obj)=>{
           let opt = doc.createElement('option');
           opt.value = elem.id;
           opt.innerHTML = elem.nome;
           selCidade.appendChild(opt);
       });
       selCidade.removeAttribute('disabled');
    });
})(window,document);