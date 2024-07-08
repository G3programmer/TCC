const botao = document.querySelector(".btn-suporte");
const elementolista = document.querySelector(".btn-suporte .lista");

botao.addEventListener("click", () => {

   
    
    const botaoEstaAberto = elementolista.classList.contains("ativo");
  
    
    if (botaoEstaAberto) {
        elementolista.classList.remove("ativo");
    }
    else {
    elementolista.classList.add("ativo")
    }

});