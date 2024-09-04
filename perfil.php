<?php
session_start();
include_once('src/php/conexao.php');

if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
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
    <title>Vanguard | Perfil</title>
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
                    <a class="btn-quem-somos" href="indexLogadoCliente.html">Home</a>
                </li>
                <li>
                    <a href="contas.php">Sistema</a>
                </li>
                </li>
                <li>
                    <a class="btn-servicos" href="cronograma.html">Agenda</a>
                </li>                <li>
                    <a class="btn-servicos" href="dashboard.html">Dashboard</a>
                </li>
                <li>
                    <a href="estoque.html" target="_blank">estoque</a>
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
    <footer class="roda-pe">

        <img src="src/imagem/logos/VanguardLogo-Escuro.png" alt="logo da Vanguard" class="logo">



        <h5 class="subtitulo">
            Nos acompanhe pelas redes sociais
        </h5>


        <div class="social_media">

            <a href="facebook link" id="facebook" title="Facebook" target="_blank"><img
                    src="src/imagem/icones/Facebook.png" alt="botão do perfil do facebook da Vanguard"></a>

            <a href="https://www.instagram.com/vanguard_security.oficial/" id="instagram" title="Instagram"
                target="_blank"><img src="src/imagem/icones/instagram.png"
                    alt="botão do perfil do instagram da Vanguard"></a>

            <a href="https://discord.gg/BpMEzwTf" title="discord" id="discord" target="_blank"><img
                    src="src/imagem/icones/discord.png" alt="botão do chat do discord da Vanguard "></a>

            <a href="linkedin" title="linkedin" id="linkedin" target="_blank"><img src="src/imagem/icones/linkedin.png"
                    alt="botão do perfil do linkedin da Vanguard"></a>

            <a href="telegram" title="telegram" id="telegram" target="_blank"><img src="src/imagem/icones/telegram.png"
                    alt="botão do chat do telegram da Vanguard"></a>

        </div>
        <div class="opcoes">
            <div class="lista">
                <a href="equipe.html">
                    <h6>
                        A equipe
                    </h6>
                </a>
                <hr />
                <a href="produtos.html">
                    <h6>
                        Nossos produtos
                    </h6>
                </a>
                <hr />
                <a href="serviços.html">
                    <h6>Nossos serviços</h6>
                </a>

                <hr />
                <a href="mailto:vanguard.seguranca.oficial@gmail.com">
                    <h6>Suporte</h6>
                </a>
            </div>
        </div>
        </div>
        <p id="copyright">
            Direitos Autorais Reservados à Vanguard&#8482;
        </p>
    </footer>
</body>

</html>