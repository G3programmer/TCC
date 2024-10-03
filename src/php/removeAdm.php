<?php
session_start();
include_once('conexao.php'); // Inclui a conexão com o banco de dados

// Verifica se o usuário está logado, caso contrário, redireciona para a página de login
if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
    header('Location: login.html');
    exit;
}

$logado = $_SESSION['email'];
$senha = $_SESSION['senha'];

// Atualiza o campo is_admin no banco de dados para 0 (remove o status de administrador)
$stmt = $conn->prepare("UPDATE usuario SET is_admin = 0 WHERE email = ? AND senha = ?");
$stmt->bind_param("ss", $logado, $senha);

if ($stmt->execute()) {
    // Atualiza a sessão para refletir a mudança
    $_SESSION['is_admin'] = 0;

    // Redireciona para a página de perfil após a atualização
    header("Location: ../../perfil.php");
    exit;
} else {
    // Se ocorrer um erro, exibe um alerta e redireciona de volta para o perfil
    echo "<script>alert('Erro ao remover status de administrador');</script>";
    echo "<script>window.location.href = '../../perfil.php';</script>";
}

?>