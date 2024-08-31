<?php
include_once('conexao.php');

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    // Buscar a imagem no banco de dados
    $sql = "SELECT foto FROM usuario WHERE email = '$email' LIMIT 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagem = $row['foto'];

        // Definir o tipo de conteúdo para a imagem e exibi-la
        header("Content-type: image/jpeg"); // Use "image/png" se for o caso
        echo $imagem;
    } else {
        // Exibir a imagem padrão se não houver imagem no banco de dados
        $imagemPadrao = '../imagem/pessoas/default.png';
        header("Content-type: image/png");
        readfile($imagemPadrao);
    }
}
?>
