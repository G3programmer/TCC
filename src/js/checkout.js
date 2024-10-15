document.getElementById('p_plano').addEventListener('change', function () {
    var planoId = this.value;
 
    if (planoId) {
       var xhr = new XMLHttpRequest();
       xhr.open('POST', 'fetch_plan.php', true);
       xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
 
       xhr.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
             var response = JSON.parse(this.responseText);
             if (response.erro) {
                document.getElementById('planInfo').innerHTML = response.erro;
             } else {
                document.getElementById('planInfo').innerHTML =
                   '<p>Nome do Plano: ' + response.nome_plano + '</p>' +
                   '<p>Preço: R$ ' + parseFloat(response.preco_plano).toFixed(2).replace('.', ',') + '</p>' +
                   '<p>Descrição: ' + response.descricao + '</p>';
             }
          }
       };
 
       xhr.send('plano_id=' + planoId);
    } else {
       document.getElementById('planInfo').innerHTML = 'Nenhum plano selecionado.';
    }
 });
 