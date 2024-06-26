<?php

require "index.php";

$titulo_relatorio = filter_input(INPUT_POST, 'relatorio');
$descricao_relatorio = filter_input(INPUT_POST, 'description');

if(isset($titulo_relatorio) && !empty($titulo_relatorio) && isset($descricao_relatorio) && !empty($descricao_relatorio)) {
       
    $sql = $pdo->prepare("INSERT INTO relatorio (titulo_relatorio, descricao_relatorio) VALUES (:relatorio, :description)");
    $sql->bindValue(':relatorio', $titulo_relatorio);
    $sql->bindValue(':description', $descricao_relatorio);
    $sql->execute();

   echo "
    <script>
        alert('Enviado com sucesso!');
        window.location.href ='../../dashboard.html';   
    </script>
";
    } else {
    echo "
    <script>
        alert('Por favor, preencha todos os campos!');
        window.location.href = '../../relatar.html';
    </script>
    ";
    exit;
}

?>