<?php
session_start();
include_once('conexao.php');

if (isset($_POST['update'])) {
    $id = $_POST['usuario_id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $dt_nasc = $_POST['dt_nasc'];
    $estado = $_POST['estado']; // Certifique-se de que o nome do campo no HTML é 'estado'
    $cidade = $_POST['cidade']; // Certifique-se de que o nome do campo no HTML é 'cidade'

    // Verifica se uma nova imagem foi enviada
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
        $foto = $_FILES['foto'];
        $nomeFoto = $foto['name'];
        $tempFoto = $foto['tmp_name'];
        $caminhoFoto = '../imagem/pessoas/' . $nomeFoto;

        // Move o arquivo para o diretório de destino
        if (move_uploaded_file($tempFoto, $caminhoFoto)) {
            // Sucesso no upload, agora salvamos o nome da imagem no banco de dados
            $sqlUpdate = "UPDATE usuario SET nome='$nome', email='$email', senha='$senha', cpf='$cpf', dt_nasc='$dt_nasc', estado_id='$estado', cidades_id='$cidade', foto='$nomeFoto' WHERE usuario_id='$id'";
        } else {
            echo "Erro ao fazer o upload da imagem.";
            exit;
        }
    } else {
        // Se nenhuma nova imagem foi enviada, atualize os outros dados sem modificar a foto
        $sqlUpdate = "UPDATE usuario SET nome='$nome', email='$email', senha='$senha', cpf='$cpf', dt_nasc='$dt_nasc', estado_id='$estado', cidades_id='$cidade' WHERE usuario_id='$id'";
    }

    // Verifique se a cidade e o estado existem
    $checkStateCity = "SELECT COUNT(*) as count FROM cidades WHERE cidade_id='$cidade' AND estado_id='$estado'";
    $result = $conn->query($checkStateCity);
    $row = $result->fetch_assoc();

    if ($row['count'] > 0) {
        // Executa a query de atualização
        if ($conn->query($sqlUpdate) === TRUE) {
            header('Location: ../../contas.php');
            exit;
        } else {
            echo "Erro ao atualizar o perfil: " . $conn->error;
        }
    } else {
        echo "Cidade ou estado inválido.";
    }
}
?>
