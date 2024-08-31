<?php
// Conecta ao banco de dados 'crud' no servidor local (localhost) com o usuário 'root' e senha vazia
include_once('../conexao.php');
// Verifica se o método de requisição é POST (indicando que o formulário foi enviado para atualização)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados enviados pelo formulário e armazena em variáveis
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $foto = $_POST['foto'];

    // Prepara uma declaração SQL para atualizar um registro na tabela 'carros'
    $stmt = $conn->prepare("UPDATE usuario SET nome=?, email=?, senha=?, cpf=?, foto=? WHERE id=?");
    // Associa as variáveis aos parâmetros na declaração preparada
    $stmt->bind_param("sssisi", $nome, $email, $senha, $cpf, $foto, $id); // "ssssi" indica que os quatro primeiros parâmetros são strings e o último é um inteiro

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
