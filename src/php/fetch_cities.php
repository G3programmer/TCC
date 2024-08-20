<?php
include('conexao.php'); // Inclua a conexão com o banco de dados

// Obtenha o ID do estado do parâmetro POST
$estado_id = $_POST['estado_id'];

// Consulte as cidades com base no ID do estado
$sql = "SELECT * FROM cidades WHERE estado_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $estado_id);
$stmt->execute();
$result = $stmt->get_result();

// Gere as opções para o dropdown de cidades
$options = '<option value="">Selecione uma cidade</option>';
while ($row = $result->fetch_assoc()) {
    $options .= '<option value="' . $row['cidade_id'] . '">' . $row['nome_cidade'] . '</option>';
}

$stmt->close();
$conn->close();

echo $options;
?>