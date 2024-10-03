<?php
session_start();
include_once('conexao.php');

// Verifica se o usuário está logado, caso contrário redireciona para o login
if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: login.html');
    exit;
}

// Verifica se o formulário foi enviado
if (isset($_POST['update'])) {
    $usuario_id = $_POST['usuario_id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $dt_nasc = $_POST['dt_nasc'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];

    // Verifica se o checkbox está marcado
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    // Atualiza os dados no banco de dados
    $stmt = $conn->prepare("UPDATE usuario SET nome = ?, email = ?, senha = ?, cpf = ?, dt_nasc = ?, estado_id = ?, cidades_id = ?, is_admin = ? WHERE usuario_id = ?");
    $stmt->bind_param("ssssiisii", $nome, $email, $senha, $cpf, $dt_nasc, $estado, $cidade, $is_admin, $usuario_id);
    
    if ($stmt->execute()) {
        // Redireciona para uma página de sucesso ou perfil
        header('Location: ../../contas.php');
        exit;
    } else {
        // Lida com erro de execução
        echo "Erro ao atualizar: " . $stmt->error;
    }
}
?>
