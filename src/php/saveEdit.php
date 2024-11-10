<?php
// saveEdit.php

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

    // Obtém a imagem atual do banco de dados
    $stmt = $conn->prepare("SELECT foto FROM usuario WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_data = $result->fetch_assoc();
    $fotoNome = $user_data['foto']; // Mantém a foto atual por padrão

    // Verifica se um novo arquivo foi enviado
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        // Obtenha os detalhes do arquivo
        $fotoTmpName = $_FILES['foto']['tmp_name'];
        $fotoNome = $_FILES['foto']['name'];
        $fotoFolder = '../imagem/pessoas/' . $fotoNome;

        // Move o arquivo para a pasta designada
        if (!move_uploaded_file($fotoTmpName, $fotoFolder)) {
            echo "<script>alert('Erro ao carregar a imagem.');</script>";
            exit;
        }
    }

    // Inicializa a variável para determinar se o usuário será deslogado
    $deslogar = false;

    // Verifica se algum dos valores foi alterado
    if ($email !== $user_data['email']) {
        $deslogar = true;
    }
    if ($senha !== $user_data['senha']) {
        $deslogar = true;
    }
    if ($cpf !== $user_data['cpf']) {
        $deslogar = true;
    }

    // Atualiza os dados no banco de dados
    $stmt = $conn->prepare("UPDATE usuario SET nome = ?, email = ?, senha = ?, cpf = ?, dt_nasc = ?, estado_id = ?, cidade_id = ?, foto = ? WHERE usuario_id = ?");
    $stmt->bind_param("ssssssiss", $nome, $email, $senha, $cpf, $dt_nasc, $estado, $cidade, $fotoNome, $usuario_id);

    if ($stmt->execute()) {
        // Se os valores foram alterados, desloga o usuário
        if ($deslogar) {
            unset($_SESSION['email']);
            unset($_SESSION['senha']);
            header('Location: ../../login.html');
            exit;
        } else {
            // Redireciona para o perfil se não houve alteração relevante
            header('Location: ../../perfil.php');
            exit;
        }
    } else {
        // Lida com erro de execução
        echo "Erro ao atualizar: " . $stmt->error;
    }
}
?>
