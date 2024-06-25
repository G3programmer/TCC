<?php
require "index.php";

$titulo = filter_input(INPUT_POST, 'titulo');
$descricao = filter_input(INPUT_POST, 'descricao');

if(isset($title_relatorio) && !empty($titulo) && isset($descricao) && !empty($descricao)) {
       
    $sql = $pdo->prepare("INSERT INTO relatorio (titulo, descricao) VALUES (:titulo, :descricao)");
    $sql->bindValue(':titulo', $titulo);
    $sql->bindValue(':descricao', $descricao);
    $sql->execute();

    echo "
    <script>
        alert('Enviado com sucesso!');
        window.location.href = '../../dashboard.html';
    </script>
    ";
    exit;
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