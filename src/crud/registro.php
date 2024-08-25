<?php
// Conecta ao banco de dados 'crud' no servidor local (localhost) com o usuário 'root' e senha vazia
include_once('../conexao.php');
// Verifica se o método de requisição é POST (indicando que o formulário foi enviado)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados enviados pelo formulário e armazena em variáveis
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $foto = $_POST['foto'];

    // Prepara uma declaração SQL para inserir os dados na tabela 'carros'
    $stmt = $conn->prepare("INSERT INTO usuario (nome, email, senha, cpf, foto) VALUES (?, ?, ?, ?, ?)");
    // Associa as variáveis aos parâmetros na declaração preparada
    $stmt->bind_param("sssis", $nome, $email, $senha, $cpf, $foto);

    // Executa a declaração preparada e verifica se foi bem-sucedida
    if ($stmt->execute()) {
        // Se a execução foi bem-sucedida, retorna uma resposta JSON indicando sucesso
        echo json_encode(['success' => true]);
    } else {
        // Se a execução falhou, retorna uma resposta JSON indicando falha e inclui o erro
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
}
?>
