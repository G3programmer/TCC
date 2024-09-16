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
$sql = "SELECT * FROM usuario WHERE email = '$logado' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_Id = $row['usuario_id']; // ID do usuário
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">


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
                    <a href="produtos.php">Produtos</a>
                </li>
                <li>
                    <a class="btn-servicos" href="serviços.html">Serviços</a>
                </li>
                <li>
                    <a class="btn-servicos" href="equipe.html">Sobre nós</a>
                </li>
                <li>
                    <a href="avaliar.php" target="_blank">Avalie-nos</a>
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
                    echo "<h2 class='nome'><p>$nomeUsuario</p></h2>";
                    ?>
                    <br>
                    <p class="descricao">pequeno exemplo se um usuário escrevesse aqui</p>
                    <ul class="nav nav-pills">
                        <li class="nav-item">
                            <?php
                           
                                echo "    
                        <button class='btn btn-light'>
                                
                          <a 
                         href='editarPerfil.php?usuario_id=$user_Id' title='Editar Perfil'><svg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24'><path d='M14.078 7.061l2.861 2.862-10.799 10.798-3.584.723.724-3.585 10.798-10.798zm0-2.829l-12.64 12.64-1.438 7.128 7.127-1.438 12.642-12.64-5.691-5.69zm7.105 4.277l2.817-2.82-5.691-5.689-2.816 2.817 5.69 5.692z'/></svg></a></button>";
                            

                            ?>

                        </li>
                    </ul>
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
                <a href="produtos.php">
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