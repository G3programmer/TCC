// Arquivo: botoes.js

function scrollToSection(sectionId) {
  var section = $(sectionId);

  if (section.length) {
      // Calcula a posição da seção em relação ao topo da página
      var offsetTop = section.offset().top;

      // Realiza o deslizamento suave até a seção usando jQuery
      $('html, body').animate({
          scrollTop: offsetTop
      }, 800); // 800 milissegundos (ajuste conforme necessário)
  }
}

// Outras funções relacionadas a botões podem estar aqui, se necessário
