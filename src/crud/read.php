<?php
// Conecta ao banco de dados 'crud' no servidor local (localhost) com o usuário 'root' e senha vazia
include_once('../conexao.php');
// Executa uma consulta SQL para selecionar todos os registros da tabela 'carros'
$result = $conn->query("SELECT * FROM usuarios");

// Inicializa um array vazio para armazenar os dados dos carros
$users = [];

// Loop através de cada linha do resultado da consulta
while ($row = $result->fetch_assoc()) {
    // Adiciona a linha (um array associativo) ao array $carros
    $users[] = $row;
}

// Converte o array $carros em formato JSON e o imprime
echo json_encode($users);
?>
