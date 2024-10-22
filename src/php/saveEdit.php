<?php
session_start();
include_once('conexao.php');

$id = $_POST['usuario_id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];
$cpf = $_POST['cpf'];
$estado = $_POST['estado'];
$cidade = $_POST['cidade']; // Corrigido para "cidade"
$dt_nasc = $_POST['dt_nasc'];

// Atualizar os dados no banco de dados
$stmt = $conn->prepare("UPDATE usuario SET nome = ?, email = ?, senha = ?, cpf = ?, cidade_id = ?, estado_id = ?, dt_nasc = ? WHERE usuario_id = ?");
$stmt->bind_param('sssiiisi', $nome, $email, $senha, $cpf, $cidade, $estado, $dt_nasc, $id);

$stmt->execute();

// Atualizar foto, se houver upload
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $fotoData = file_get_contents($_FILES['foto']['tmp_name']); // Lê o conteúdo do arquivo

    // Prepara a atualização da foto como BLOB
    $stmt = $conn->prepare("UPDATE usuario SET foto = ? WHERE usuario_id = ?");
    $stmt->bind_param('si', $fotoData, $id);
    $stmt->execute();
}

header("Location: ../../login.html");
exit;
?>
