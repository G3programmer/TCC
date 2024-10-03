      // Seleciona elementos do DOM
      const removeAdmBtn = document.getElementById('removeAdmBtn');
      const confirmModal = document.getElementById('confirmModal');
      const confirmBtn = document.getElementById('confirmBtn');
      const cancelBtn = document.getElementById('cancelBtn');

      // Abre o modal ao clicar no botão
      removeAdmBtn.onclick = function() {
          confirmModal.style.display = 'block';
      }

      // Fecha o modal ao clicar em cancelar
      cancelBtn.onclick = function() {
          confirmModal.style.display = 'none';
      }

      // Ação de confirmação
      confirmBtn.onclick = function() {
          window.location.href = 'src/php/removeAdm.php'; // Redireciona para a ação de remoção
      }

      // Fecha o modal se o usuário clicar fora dele
      window.onclick = function(event) {
          if (event.target == confirmModal) {
              confirmModal.style.display = 'none';
          }
      }