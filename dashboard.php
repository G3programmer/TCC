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

// Buscar o nome do usuário do banco de dados
$sql = "SELECT nome, foto FROM usuario WHERE email = '$logado' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $nomeUsuario = $row['nome'];
    $fotoUsuario = $row['foto']; // Caminho ou nome da imagem
} else {
    $fotoUsuario = 'default.png'; // Imagem padrão se a foto não for encontrada
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

        <!--Aqui que é para fazer o crud de relatório-->

        <div class="painel">
            <h1 class="titulo">
                Sistema
            </h1>

            <ul class="lista">
                <li><button><a href="contas.php"> Lista de Usuários</a></button></li>
                <li><button><a href="estoque.php"> Lista de produtos</a></button></li>
                <li><button><a href="contas.php"> Lista de Usuários </a></button></li>
            </ul>
        </div>

        <form class="perfil" action="perfil.php">
            <div class="area-foto">
                <img id="foto" src="src/php/exibir_imagem.php?email=<?php echo $logado; ?>" alt="Foto do usuário">
            </div>

            <div class="info">
                <h1 class="bem-vindo">Seja Bem Vindo(a)</h1>
                <br>
                <?php
                echo "<h2 class='nome'><p>$nomeUsuario</p></h2>";
                ?>
                <ul class="nav nav-pills">
                    <li class="nav-item">
                        <button class="btn btn-light ">
                            <a aria-current="page" href="editarPerfil.php"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24">
                                    <path
                                        d="M14.078 7.061l2.861 2.862-10.799 10.798-3.584.723.724-3.585 10.798-10.798zm0-2.829l-12.64 12.64-1.438 7.128 7.127-1.438 12.642-12.64-5.691-5.69zm7.105 4.277l2.817-2.82-5.691-5.689-2.816 2.817 5.69 5.692z" />
                                </svg></a>
                            <p class="editar">Editar o Perfil</p>
                        </button>
                    </li>
                </ul>

            </div>
        </form>
        </div>

        <div>
            <!--Gráfico linha / coluna referente a semana-->
        </div>

        <div>
            <!--Check list-->
        </div>
    </main>

    <section>
        <div>
            <!--ranking funcionários-->
        </div>

        <div>
            <!--bate papo para problemas-->
        </div>
    </section>


</body>

</html>