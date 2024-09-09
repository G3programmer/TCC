<?php
    include_once('conexao.php');
    if(isset($_POST['update']))
    {
        $id = $_POST['usuario_id'];
        $nome = $_POST['nome'];
        $dt_nasc = $_POST['dt_nasc'];
        $email = $_POST['email'];
        $senha = $_POST['senha'];
        $cpf = $_POST['cpf'];
        $estado = $_POST['estado'];
        $cidade = $_POST['cidade'];
       // $foto = $_POST['foto'];
        
        $sqlInsert = "UPDATE usuario 
        SET nome='$nome', senha='$senha', email='$email', dt_nasc = '$dt_nasc', cpf = '$cpf', estado_id ='$estado', cidade_id ='$cidade'/*,foto='$foto*/'
        WHERE usuario_id = $id";
        $result = $conn->query($sqlInsert);
        print_r($result);
    }
    if ($result) {
        echo "Atualização bem-sucedida!";
    } else {
        echo "Erro: " . $conn->error;
    }
    header('Location: ../../contas.php');
?>