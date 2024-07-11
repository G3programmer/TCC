<?php
if (isset($_POST['submit'])) {
    include_once('index.php');
    

    $nome = $_POST['nome'];
    $dt_nasc = $_POST['dt_nasc'];
    $nome_estado = $_POST['estado']; // Nome do estado
    $nome_cidade = $_POST['cidade']; // Nome da cidade
    $cep = $_POST['cep'];
    $bairro = $_POST['bairro'];
    $rua = $_POST['rua'];
    $num_predial = $_POST['num_predial'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);

    

    // Verificar se o CPF já está registrado
    $stmt = $conn->prepare("SELECT id FROM Usuario WHERE cpf = ?");
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "CPF já registrado.";
    } else {
        // Inserir usuário
        $stmt = $conn->prepare("INSERT INTO Usuario (Nome, dt_nasc, cep, bairro, rua, num_predial, Cidades_id, Cidades_Estado_id, cpf, email, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssisisss", $nome, $dt_nasc, $cep, $bairro, $rua, $num_predial, $cidade_id, $estado_id, $cpf, $email, $senha);


        include ('../index.php');
        
        class ClassEstados extends ClassConect
        {
        
            public function getEstados()
            {
                $estado = $this->conectaDB()->prepare('select * from estados');
                $estado->execute();
                return $fEstados = $estado->fetchAll(\PDO::FETCH_OBJ);
            }
        }
        


        if ($stmt->execute()) {
            // Autenticação bem-sucedida
            $user_id = $stmt->insert_id;
            $_SESSION['id'] = $user_id;

            // Redireciona o usuário para a página 'indexLogado.html'
            header("Location: ../../indexLogado.html");
            exit(); // Encerra a execução do script
        } else {
            echo "Erro: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método de requisição inválido.";
}
?>