<?php

require "conexao.php";

$titulo = $_POST ['titulo'];
$comentario = $_POST ['comentario'];

        $sql = "INSERT INTO relatorio (titulo, comentario) VALUES ('titulo', 'comentario')"; 

        if (mysqli_query($conn, $sql)) {
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
mysqli_close($conn);
?>
