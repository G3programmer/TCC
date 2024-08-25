<?php
// Conecta ao banco de dados 'crud' no servidor local (localhost) com o usuário 'root' e senha vazia
include_once('../conexao.php');
// Verifica se o método de requisição é GET e se o parâmetro 'id' está definido na URL
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    // Obtém o valor do parâmetro 'id' da URL
    $id = $_GET['id'];

    // Prepara uma declaração SQL para selecionar todos os campos de um registro na tabela 'carros' com o id especificado
    $stmt = $conn->prepare("SELECT * FROM usuarios WHERE id = ?");
    // Associa a variável $id ao parâmetro na declaração preparada
    $stmt->bind_param("i", $id); // "i" indica que o parâmetro é um inteiro
    // Executa a declaração preparada
    $stmt->execute();
    // Obtém o resultado da execução da declaração
    $result = $stmt->get_result();

    // Verifica se há alguma linha no resultado
    if ($result->num_rows > 0) {
        // Se há pelo menos uma linha, converte a primeira linha do resultado em um array associativo e retorna como JSON
        echo json_encode($result->fetch_assoc());
    } else {
        // Se não há nenhuma linha, retorna uma resposta JSON indicando que o carro não foi encontrado
        echo json_encode(['success' => false, 'error' => 'Carro não encontrado.']);
    }
}
?>
