<?php

    require "conexao.php";

    $nome = filter_input(INPUT_POST, 'nome');
    $email = filter_input(INPUT_POST, 'email');
    $senha = filter_input(INPUT_POST, 'senha');
    $cpf = filter_input(INPUT_POST, 'cpf');
    $foto = filter_input(INPUT_POST, 'foto');
    

    if(isset($nome) && !empty($nome) && isset($email) && !empty($email) && isset($senha) && !empty($senha) && isset($cpf) && !empty($cpf) && isset($foto)) {
       
        $sql = $pdo->prepare("INSERT INTO usuario (nome, email, senha, cpf, foto) VALUES (:nome, :email, :senha, :cpf, :foto)");
        $sql->bindValue(':nome', $nome);
        $sql->bindValue(':email', $email);
        $sql->bindValue(':senha', $senha);
        $sql->bindValue(':cpf', $cpf);
        $sql->bindValue(':foto', $foto);
        $sql->execute();

        echo "
        <script>
            alert('Cadastrado com sucesso!');
            window.location.href = 'index.php';
        </script>
        ";
        exit;
    } else {
        echo "
        <script>
            alert('Por favor, preencha todos os campos!');
            window.location.href = 'cadastrar.php';
        </script>
        ";
        exit;
    }

?>