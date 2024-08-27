<?php
session_start();
include_once('src/php/conexao.php');

if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: login.html');
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
    $nomeUsuario = 'Usuário';
    $fotoUsuario = 'default.png'; // Imagem padrão se a foto não for encontrada
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vanguard | Segurança eletrônica e testes de segurança</title>
    <link rel="shortcut icon" href="src/imagem/icones/escudo.png" type="image/x-icon">
    <link rel="stylesheet" href="src/css/index.css">
    <link rel="stylesheet" href="src/css/style-perfil.css">
    <link rel="stylesheet" href="src/css/responsividade/responsivo.css">
    <link href="https://fonts.cdnfonts.com/css/milestone-one" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">

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
                <li>
                    <a class="btn-quem-somos" href="#quem-somos">Quem somos</a>
                </li>
                <li>
                    <a class="btn-parcerias" href="#parcerias">Parcerias</a>
                </li>
                <li>
                    <a class="btn-avaliar" href="avaliar.html">Avaliar</a>
                </li>
                <li>
                    <a class="btn-servicos" href="servicos.html">Serviços</a>
                </li>
                <li>
                    <a href="produtos.html" target="_blank">Produtos</a>
                </li>
                <li>
                    <a href="src/php/logout.php">Logout</a>
                </li>
                <li>
                    <a
                        href="mailto:g3hunterbugs@gmail.com?subject=Mensagem para Vanguard de um cliente&body=Preciso de ajuda">Suporte</a>
                </li>
            </ul>
        </nav>
    </header>
    <main class="home">

        <img class="imagem-fundo" src="src/imagem/Fundo/fundo-perfil.png" alt="fundo de uma cidade de noite">
        <div class="painel">
            <form class="perfil" action="perfil.php">
                <div class="area-foto">
                <img id="foto" src="src/php/exibir_imagem.php?email=<?php echo $logado; ?>" alt="Foto do usuário">
            </div>

                <div class="info">
                    <h1 class="bem-vindo">Seja Bem Vindo(a)</h1>
                    <br>
                    <?php
                    echo "<h2 class='nome'><u>$nomeUsuario</u></h2>";
                    ?>
                    <br>
                    <p class="descricao">pequeno exemplo se um usuário escrevesse aqui</p>
                </div>
            </form>
        </div>
    </main>
</body>

</html>