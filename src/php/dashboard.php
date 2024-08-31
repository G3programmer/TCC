<?php

require "conexao.php";

$titulo = filter_input(INPUT_POST, 'relatorio');
$comentario = filter_input(INPUT_POST, 'description');

if(isset($titulo) && !empty($titulo) && isset($comentario) && !empty($comentario)) {
       
    $sql = $pdo->prepare("INSERT INTO solicitacao (titulo, comentario) VALUES (:titulo, :description)");
    $sql->bindValue(':titulo', $titulo);
    $sql->bindValue(':description', $comentario);
    $sql->execute();

    echo "
    <script>
        alert('Cadastrado com sucesso!');
        window.location.href = '../indexLogado.html';
    </script>
    ";
    exit;
} else {
    echo "
    <script>
        alert('Por favor, preencha todos os campos!');
        window.location.href = '../relatar.html';
    </script>
    ";
    exit;
}

?>