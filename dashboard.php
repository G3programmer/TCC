<?php
session_start();
include_once('src/php/conexao.php');

if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: login.html');
    exit;
}

$logado = $_SESSION['email'];

// Obtém os dados do usuário
$sql = "SELECT * FROM usuario WHERE email = ? LIMIT 1";
$stmtUser = $conn->prepare($sql);
$stmtUser->bind_param("s", $logado);
$stmtUser->execute();
$resultUser = $stmtUser->get_result();

if ($resultUser->num_rows > 0) {
    $row = $resultUser->fetch_assoc();
    $user_Id = $row['usuario_id']; // ID do usuário
    $nomeUsuario = htmlspecialchars($row['nome']);
    $fotoUsuario = htmlspecialchars($row['foto']) ?: 'default.png';
} else {
    $nomeUsuario = 'Usuário';
    $fotoUsuario = 'default.png';
}


?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vanguard | Painel do funcionário</title>
    <link rel="shortcut icon" href="src/imagem/icones/escudo.png" type="image/x-icon">
    <link rel="stylesheet" href="src/css/index-dashboard.css">
    <link rel="stylesheet" href="src/css/style-dashboard.css">
    <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <header class="cabecalho">
        <div class="logo">
            <img src="src/imagem/logos/VanguardLogo - titulo.png" alt="Logo da Vanguard" />
        </div>
    </header>
    <main class="home">
        <div class="painel">
            <h1 class="titulo">Sistema</h1>
            <ul class="lista">
                <li><button><a href="contas.php">Lista de Usuários</a></button></li>
                <li><button><a href="estoque.php">Lista de Produtos</a></button></li>
                <li><button><a href="plano.php">Lista de planos</a></button></li>
                
                <li><button><a href="log.php">Lista de usuarios assinantes</a></button></li>
                <li><button><a href="src/php/logout.php">Logout</a></button></li>
            </ul>
        </div>

        <!-- Formulário correto com método POST -->
        <form class="perfil" method="post">
            <?php if (isset($user_Id) && !empty($fotoUsuario)): ?>
                <div class="area-foto">
                    <img src="src/imagem/pessoas/<?php echo htmlspecialchars($fotoUsuario); ?>" alt="">
                </div>
                <div class="info">
                    <h1 class="bem-vindo">Seja Bem Vindo(a)</h1>
                    <h2 class='nome'>
                        <p><?php echo htmlspecialchars($nomeUsuario); ?></p>
                    </h2>
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <a href="editarPerfilADM.php?usuario_id=<?php echo $user_Id; ?>" class="btn btn-light"
                                title="Editar">

                                <p class="editar">Editar o Perfil</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a id="removeAdmBtn" class="btn btn-danger">
                                <p class="editar">Tornar usuário padrão</p>
                            </a>
                    </ul>
                </div>
            </form>
            <div id="confirmModal" class="modal">
                <div class="modal-content">
                    <h2>Confirmação</h2>
                    <p>Você tem certeza de que deseja abandonar o status de administrador?</p>
                    <button type="button" id="confirmBtn" class="btn btn-success">Confirmar</button>
                    <button type="button" id="cancelBtn" class="btn btn-danger">Cancelar</button>
                </div>
            </div>
        <?php endif; ?>
    </main>

    <!-- Script para controlar o modal -->
    <script src="src/js/dashboard.js"></script>
</body>

</html>