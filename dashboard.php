<?php
session_start();
include_once('src/php/conexao.php');

if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: login.html');
    exit;
}

$senha = $_SESSION['senha'];
$logado = $_SESSION['email'];

$sql = "SELECT nome, foto FROM usuario WHERE email = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $logado);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nomeUsuario = $row['nome'];
    $fotoUsuario = $row['foto'] ?: 'default.png'; // Imagem padrão se a foto não for encontrada
} else {
    $fotoUsuario = 'default.png';
}

$stmt = $conn->prepare("SELECT is_admin FROM usuario WHERE email = ? AND senha = ?");
$stmt->bind_param("ss", $logado, $senha);
$stmt->execute();
$resulte = $stmt->get_result();

if ($resulte->num_rows > 0) {
    $row = $resulte->fetch_assoc();
    $redirectPage = $row['is_admin'] == 1 ? 'dashboard.php' : 'perfil.php';

    if (basename($_SERVER['PHP_SELF']) !== $redirectPage) {
        header("Location: $redirectPage");
        exit;
    }
} else {
    header('Location: login.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=devicel-width, initial-scale=1.0">
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
            <a href="funcionario.html">
                <img src="src/imagem/logos/VanguardLogo - titulo.png" alt="Logo da Vanguard" />
            </a>
        </div>
    </header>
    <main class="home">
        <div class="painel">
            <h1 class="titulo">Sistema</h1>
            <ul class="lista">
                <li><button><a href="contas.php">Lista de Usuários</a></button></li>
                <li><button><a href="estoque.php">Lista de Produtos</a></button></li>
                <li><button><a href="src/php/logout.php">Logout</a></button></li>
            </ul>
        </div>

        <form class="perfil" action="perfil.php">
            <div class="area-foto">
                <img src="src/imagem/pessoas/<?php echo htmlspecialchars($fotoUsuario); ?>" alt="">
            </div>
            <div class="info">
                <h1 class="bem-vindo">Seja Bem Vindo(a)</h1>
                <h2 class='nome'><p><?php echo htmlspecialchars($nomeUsuario); ?></p></h2>
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <button class="btn btn-light">
                            <a href="editarPerfil.php"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24">
                                    <path
                                        d="M14.078 7.061l2.861 2.862-10.799 10.798-3.584.723.724-3.585 10.798-10.798zm0-2.829l-12.64 12.64-1.438 7.128 7.127-1.438 12.642-12.64-5.691-5.69zm7.105 4.277l2.817-2.82-5.691-5.689-2.816 2.817 5.69 5.692z" />
                                </svg>               </a>
                            <p class="editar">Editar o Perfil</p>
                        </button>
                    </li>
                </ul>
            </div>
        </form>
    </main>
</body>
</html>