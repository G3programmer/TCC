<?php
// Conecta ao banco de dados 'crud' no servidor local (localhost) com o usuário 'root' e senha vazia
include_once('../conexao.php');

// Verifica se o método de requisição é POST (indicando que a requisição é para deletar um registro)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém o corpo da requisição JSON e decodifica para um array associativo
    $data = json_decode(file_get_contents('php://input'), true);
    // Extrai o campo 'id' do array associativo
    $id = $data['id'];

    // Prepara uma declaração SQL para deletar um registro da tabela 'carros' com o id especificado
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id=?");
    // Associa a variável $id ao parâmetro na declaração preparada
    $stmt->bind_param("i", $id); // "i" indica que o parâmetro é um inteiro

    // Executa a declaração preparada e verifica se foi bem-sucedida
    if ($stmt->execute()) {
        // Se a execução foi bem-sucedida, retorna uma resposta JSON indicando sucesso
        echo json_encode(['success' => true]);
    } else {
        // Se a execução falhou, retorna uma resposta JSON indicando falha
        echo json_encode(['success' => false]);
    }
}
?>
