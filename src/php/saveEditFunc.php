<?php
session_start();
include_once('conexao.php');

// Verifica se o usuário está logado
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
    $is_admin = isset($_POST['is_admin']) ? 1 : 0; // Corrigido aqui

    var_dump($is_admin); // Isso mostrará se o valor está sendo capturado corretamente

    // Inicializa a variável para a imagem
    $fotoNome = '';

    // Verifica se um arquivo foi enviado
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $fotoTmpName = $_FILES['foto']['tmp_name'];
        $fotoNome = $_FILES['foto']['name'];
        $fotoFolder = '../imagem/pessoas/' . $fotoNome;

        if (!move_uploaded_file($fotoTmpName, $fotoFolder)) {
            echo "<script>alert('Erro ao carregar a imagem.');</script>";
            exit;
        }
    } else {
        // Mantém a imagem atual
        $fotoNome = $_POST['foto_atual']; 
    }

    // Atualiza os dados no banco de dados, incluindo o campo is_admin
    $stmt = $conn->prepare("UPDATE usuario SET nome = ?, email = ?, senha = ?, cpf = ?, dt_nasc = ?, estado_id = ?, cidade_id = ?, foto = ?, is_admin = ? WHERE usuario_id = ?");
    $stmt->bind_param("ssssssissi", $nome, $email, $senha, $cpf, $dt_nasc, $estado, $cidade, $fotoNome, $is_admin, $usuario_id);

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
