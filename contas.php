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

$email = $_SESSION['email'];
$senha = $_SESSION['senha'];

$stmt = $conn->prepare("SELECT is_admin FROM usuario WHERE email = ? AND senha = ?");
$stmt->bind_param("ss", $email, $senha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verifica se o usuário é administrador
    if ($row['is_admin'] == 1) {
        if (basename($_SERVER['PHP_SELF']) !== 'contas.php') {
            header('Location: contas.php');
            exit;
        }
    } else {
        if (basename($_SERVER['PHP_SELF']) !== 'perfil.php') {
            header('Location: perfil.php');
            exit;
        }
    }
} else {
    header('Location: login.html');
    exit;
}

$logado = $_SESSION['email'];

// Busca todos os usuários administradores
$sql_admins = "SELECT * FROM usuario WHERE is_admin = 1 ORDER BY usuario_id DESC";
$resulte_admins = $conn->query($sql_admins);

// Verifica se a consulta para administradores foi bem-sucedida
if (!$resulte_admins) {
    die("Erro ao executar consulta: " . $conn->error);
}

// Busca todos os usuários comuns
$sql_users = "SELECT * FROM usuario WHERE is_admin = 0 ORDER BY usuario_id DESC";
$resulte_users = $conn->query($sql_users);

// Verifica se a consulta para usuários comuns foi bem-sucedida
if (!$resulte_users) {
    die("Erro ao executar consulta: " . $conn->error);
}


?>

<!-- Código HTML e PHP para exibir as tabelas continua aqui -->


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
        crossorigin="anonymous">
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
                <li> <a href="dashboard.php">Home</a> </li>
                <li><a href="guia.php">Visualizar guias</a></li>
                <li> <a href="estoque.php">Visualizar os produtos</a> </li>
                <li> <a href="plano.php">Visualizar os Planos</a> </li>
                <li> <a href="log.php">Visualizar os Checkouts</a> </li>
                <li> <a href="src/php/logout.php">Logout</a></li>
            </ul>
        </nav>
        </nav>
    </header>

    <main class="home">
        <div class="container">
            <div class="area">
                <table class="table table-dark table-hover">
                    <h4 class="titulo">Lista de Administradores</h4>

                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Email</th>
                            <th scope="col">Senha</th>
                            <th scope="col">CPF</th>
                            <th scope="col">Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($user_data = mysqli_fetch_assoc($resulte_admins)) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($user_data['usuario_id']) . "</td>";
                            echo "<td>" . htmlspecialchars($user_data['nome']) . "</td>";
                            echo "<td>" . htmlspecialchars($user_data['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($user_data['senha']) . "</td>";
                            echo "<td>" . htmlspecialchars($user_data['cpf']) . "</td>";

                            if (!empty($user_data['foto'])) {
                                echo "<td><img src='src/imagem/pessoas/" . htmlspecialchars($user_data['foto']) . "' alt='Foto do usuário' width='100'></td>";
                            } else {
                                echo "<td><img src='src/imagem/icones/default.png' alt='Foto padrão' width='100'></td>";
                            }
                        } ?>

                        <br>
                        <section class="selecao">
                            <table class="table table-dark table-hover">
                                <h4 class="titulo">Lista de usuários</h4>
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Senha</th>
                                        <th scope="col">CPF</th>
                                        <th scope="col">Foto</th>
                                        <th scope="col">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($user_data = mysqli_fetch_assoc($resulte_users)) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($user_data['usuario_id']) . "</td>";
                                        echo "<td>" . htmlspecialchars($user_data['nome']) . "</td>";
                                        echo "<td>" . htmlspecialchars($user_data['email']) . "</td>";
                                        echo "<td>" . htmlspecialchars($user_data['senha']) . "</td>";
                                        echo "<td>" . htmlspecialchars($user_data['cpf']) . "</td>";

                                        // Exibe a foto do usuário, assumindo que ela está em formato BLOB no banco de dados
                                        if (!empty($user_data['foto'])) {
                                            echo "<td><img src='src/imagem/pessoas/" . htmlspecialchars($user_data['foto']) . "' alt='Foto do usuário' width='100'></td>";
                                        } else {
                                            // Exibe uma imagem padrão se não houver foto
                                            echo "<td><img src='src/imagem/icones/default.png' alt='Foto padrão' width='100'></td>";
                                        }

                                        echo "<td>
                            <a class='btn btn-sm btn-primary' href='editarPerfilFunc.php?usuario_id={$user_data['usuario_id']}' title='Editar'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-pencil' viewBox='0 0 16 16'>
                                    <path d='M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z'/>
                                </svg>
                            </a> 
                            <a class='btn btn-sm btn-danger' href='src/php/deleteContas.php?id={$user_data['usuario_id']}' title='Deletar'>
                                <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
                                    <path d='M2.5  1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0  2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0  0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0  0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zm4 0a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5z'/>
                                </svg>
                            </a>
                        </td>";
                                        echo "</tr>";
                                    }


                                    ?>

                                </tbody>
                            </table>
                        </section>
            </div>
        </div>
    </main>
</body>
<script src="src/js/script.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
    integrity="sha384-5nA/Uft8AHT9n9p+5DxiBJGVl3LmYYbs4k6e7uFS/NVUb5+slJHCG5dB0+jhAs5Y"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
    integrity="sha384-kQhL2e3Ez08lSKTn8tpT6qQ9U5esNm1xJMSx5Oe1x6TFo/V2SMZ0J4mP7tqDRgVq"
    crossorigin="anonymous"></script>


</html>