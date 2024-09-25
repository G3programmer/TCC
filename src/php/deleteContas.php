<?php
include_once('conexao.php');

// Verifica se o ID do usuário foi enviado via GET
if (isset($_GET['id'])) {
    $usuario_id = $_GET['id'];

    // Prepara a consulta SQL para deletar o usuário
    $sqlDelete = "DELETE FROM usuario WHERE usuario_id = ?";
    
    if ($stmt = $conn->prepare($sqlDelete)) {
        $stmt->bind_param('i', $usuario_id);  // Liga o ID do usuário
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Usuário deletado com sucesso
            header("Location: ../../contas.php");
            exit;
        } else {
            echo "Erro: Não foi possível deletar o usuário.";
        }
    } else {
        echo "Erro: Falha ao preparar a consulta SQL.";
    }
} else {
    echo "Erro: ID do usuário não fornecido.";
}
?>