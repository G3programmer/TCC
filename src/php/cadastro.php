<?php

if (isset($_POST['submit'])) {
    include_once('index.php');

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


    $result = mysqli_query($index, "INSERT INTO Usuario (nome, dt_nasc, cep, bairro, rua, num_predial, Cidades_id, Cidades_Estado_id, cpf, email, senha) VALUES ( '$nome', '$dt_nasc', '$cep', '$bairro', '$rua', '$num_predial', '$cidade_id', '$estado_id', '$cpf', '$email', '$senha')");

    include_once('index.php');
    $result = $conn->query("SELECT nome_estado FROM Estado");
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['nome_estado']}'>{$row['nome_estado']}</option>";
    }

    $result = $conn->query("SELECT nome_cidade FROM Cidades");
    while ($row = $result->fetch_assoc()) {
        echo "<option value='{$row['nome_cidade']}'>{$row['nome_cidade']}</option>";
    }

     // Buscar o ID do estado a partir do nome do estado
     $stmt = $conn->prepare("SELECT id FROM Estado WHERE nome_estado = ? LIMIT 1");
     $stmt->bind_param("s", $nome_estado);
     $stmt->execute();
     $stmt->bind_result($estado_id);
     $stmt->fetch();
     $stmt->close();
 
     if (empty($estado_id)) {
         die("Estado não encontrado");
     }
 
     // Buscar o ID da cidade a partir do nome da cidade e do ID do estado
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
                header("Location: ../../index.html");
         }
?>
