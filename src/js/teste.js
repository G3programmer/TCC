const botao = document.querySelector(".btn-veja");
const elementolista = document.querySelector(".btn-veja .lista");

botao.addEventListener("click", () => {

   
    
    const botaoEstaAberto = elementolista.classList.contains("ativo");
  
    
    if (botaoEstaAberto) {
        elementolista.classList.remove("ativo");
    }
    else {
    elementolista.classList.add("ativo")
    }

});