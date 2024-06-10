<?php
//inicia uma sessão
session_start();

// Conecta o banco de dados no localhost como root
$conn = new mysqli('localhost', 'root', '', 'vanguard');

// Verifica se o método de requisição é POST (indicando que o formulário de login foi enviado)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados enviados pelo formulário e armazena em variáveis
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se o nome de usuário existe na tabela 'usuarios'
    $stmt = $conn->prepare("SELECT id, senha FROM Usuario WHERE email = ?");

    // Associa a variável $nome ao parâmetro na declaração preparada

    $stmt->bind_param("s", $email); 
    // "s" indica que o parâmetro é uma string
   
    // Executa a declaração preparada
    $stmt->execute();

    // Obtém o resultado da execução da declaração
    $result = $stmt->get_result();

      // Verifica se foi encontrado algum um usuário com o nome de usuário dado

      if ($result->num_rows == 1) {

        // Obtém os dados do usuário encontrado
        $row = $result->fetch_assoc();

        // Verifica se a senha fornecida corresponde à senha armazenada
        if ($senha === $row['senha']) {

            // Autenticação bem-sucedida
            // Armazena o ID do usuário na sessão

            $_SESSION['id'] = $row['id'];
            // Redireciona o usuário para a página 'indexLogado.html'
            header("Location: ../../index.html");
            exit(); // Encerra a execução do script
        } else {
            // Senha incorreta
            echo "Senha incorreta.";
        } 
    } else {
        // Nome de usuário não encontrado
        echo "email de usuário não encontrado.";
    }
}
?>
