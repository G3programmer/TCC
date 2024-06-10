<?php

require 'index.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
$nome = $_POST['nome'];
$dt_nasc = $_POST['dt_nasc'];
$estado = $_POST['estado'];
$cidade = $_POST['cidade'];
$cep = $_POST['cep'];
$bairro = $_POST['bairro'];
$rua = $_POST['rua'];
$num_predial = $_POST['username'];
$email = $_POST['email'];
$senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);


/* Confirmar se já existe o email */

$sql = "SELECT id FROM Usuario WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
  
    if ($stmt->num_rows > 0) {
        echo "Email já registrado.";
    } else {
        $sql = "INSERT INTO Usuario (nome, dt_nasc, estado, cidade, cep, bairro, rua, numero_predial, email, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssssssss", $nome, $dt_nasc, $estado, $cidade, $cep, $bairro, $rua, $numero_predial, $email, $senha);

        if ($stmt->execute()) {
            echo "Cadastro realizado com sucesso!";
        } else {
            echo "Erro: " . $sql . "<br>" . $conn->error;
        }
    }

    $stmt->close();
    $conn->close();
}
?>