<?php
session_start();
include_once('src/php/conexao.php');
// Verifica se o usuário está logado, caso contrário redireciona para o login
if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: login.html');
    exit;
}

$logado = $_SESSION['email'];

if(!empty($_GET['search']))
{
    $data = $_GET['search'];
    $sql = "SELECT * FROM usuario WHERE id LIKE '%$data%' or nome LIKE '%$data%' or email LIKE '%$data%' ORDER BY id DESC";
}
else
{
    $sql = "SELECT * FROM usuario ORDER BY usuario_id DESC";
}
$result = $conn->query($sql);
?>



<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/index-contas.css">
    <link rel="stylesheet" href="src/css/style-contas.css">
    <link rel="stylesheet" href="src/css/responsivo-contas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.cdnfonts.com/css/eingrantch-mono" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/milestone-one" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">
    <title>Vanguard | Lista de usuários</title>
    <link rel="shortcut icon" href="src/imagem/icones/escudo.png" type="image/x-icon">
</head>

<body>
    <header class="cabecalho">
        <div class="logo">
            <img src="src/imagem/logos/VanguardLogo - titulo.png" alt="Logo da Vanguard" />
        </div>

        <button id="OpenMenu">&#9776;</button>

        <nav id="menu">
            <button id="CloseMenu">X</button>
            <ul class="menu">
                <li><a href="dashboard.html">Dashboard</a></li>
                <li><a href="avaliar.html">Avaliações</a></li>
                <li><a class="btn-servicos" href="servicos.html" target="_blank">Serviços</a></li>
                <li><a href="produtos.php" target="_blank">Produtos</a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a class="btn-login" href="login.html">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="home">
        <div class="container">
            <div class="area">
                <h2 class="titulo">Lista de usuários</h2>
                <form class="formulario" id="crud-form">
                    <input type="hidden" id="user-id"> <!-- Campo oculto para o ID do usuário -->
                    <input type="text" id="Nome" placeholder="Nome">
                    <input type="text" id="email" placeholder="Email">
                    <input type="text" id="senha" placeholder="Senha">
                    <input type="number" id="cpf" placeholder="CPF">
                    <input type="file" id="foto" placeholder="Aqui ó">
                    <button type="button" onclick="createOrUpdate()">Salvar</button>
                </form>
            </div>
        </div>

        <!-- Lista -->
        <section class="selecao">
            <h4 class="titulo">Lista de usuários</h4>
            <table class="table table-dark table-hover">
                <tbody>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Senha</th>
                    <th scope="col">CPF</th>
                    <th scope="col">Foto</th>
                    <th scope="col">Ações</th>
                    <?php
                    while ($user_data = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $user_data['usuario_id'] . "</td>";
                        echo "<td>" . $user_data['nome'] . "</td>";
                        echo "<td>" . $user_data['email'] . "</td>";
                        echo "<td>" . $user_data['senha'] . "</td>";
                        echo "<td>" . $user_data['cpf'] . "</td>";
                        $imgData = base64_encode($user_data['foto']);
                        echo "<td><img src='data:image/png;base64,{$imgData}' alt='Foto' width='100'></td>";
                        echo "<td>
                        <a class='btn btn-sm btn-primary' href='editarPerfil.php?usuario_id=$user_data[usuario_id]' title='Editar'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                            </svg>
                        </a> 
                        <a class='btn btn-sm btn-danger' href='src/php/deleteContas.php?id=$user_data[usuario_id]' title='Deletar'>
                            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
                            </svg>
                        </a>
                        </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </main>
</body>

</html>