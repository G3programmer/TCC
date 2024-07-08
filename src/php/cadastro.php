<?php
// Initialize database connection
$conn = new mysqli("localhost", "username", "password", "database");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $nome = $_POST['nome'];
    $dt_nasc = $_POST['dt_nasc'];
    $nome_estado = $_POST['estado']; // Sigla do estado
    $nome_cidade = $_POST['cidade']; // Nome da cidade
    $cep = $_POST['cep'];
    $bairro = $_POST['bairro'];
    $rua = $_POST['rua'];
    $num_predial = $_POST['num_predial'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepare and execute INSERT query
    $stmt = $conn->prepare("INSERT INTO Usuario (nome, dt_nasc, cep, bairro, rua, num_predial, Cidades_id, Cidades_Estado_id, cpf, email, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $nome, $dt_nasc, $cep, $bairro, $rua, $num_predial, $cidade_id, $estado_id, $cpf, $email, $senha);
    $stmt->execute();

    // Get estado ID
    $stmt = $conn->prepare("SELECT id FROM Estado WHERE nome_estado = ? LIMIT 1");
    $stmt->bind_param("s", $nome_estado);
    $stmt->execute();
    $stmt->bind_result($estado_id);
    $stmt->fetch();
    $stmt->close();

    if (empty($estado_id)) {
        die("Estado não encontrado");
    }

    // Get cidade ID
    $stmt = $conn->prepare("SELECT id FROM Cidades WHERE nome_cidade = ? AND Estado_id = ? LIMIT 1");
    $stmt->bind_param("si", $nome_cidade, $estado_id);
    $stmt->execute();
    $stmt->bind_result($cidade_id);
    $stmt->fetch();
    $stmt->close();

    if (empty($cidade_id)) {
        die("Cidade não encontrada");
    }

    // Redireciona o usuário para a página 'indexLogado.html'
    header("Location: ../../indexLogado.html");
    exit;
}
?>