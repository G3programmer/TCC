<?php
session_start();
include_once('src/php/conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: login.html');
    exit;
}

$logado = $_SESSION['email'];

// Buscar o nome do usuário do banco de dados
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

// Obter o plano_id associado ao último checkout do usuário
$checkoutQuery = "SELECT plano_id FROM usuario WHERE usuario_id = ?";
$stmtCheckout = $conn->prepare($checkoutQuery);
$stmtCheckout->bind_param("i", $user_Id);
$stmtCheckout->execute();
$resultCheckout = $stmtCheckout->get_result();

if ($resultCheckout->num_rows > 0) {
    $checkoutRow = $resultCheckout->fetch_assoc();
    $plano_id = $checkoutRow['plano_id']; // Obtemos o plano_id

    // Obter a duração do plano (em meses) do banco de dados
    $duracaoPlanoQuery = "SELECT tempo FROM plano WHERE plano_id = ?";
    $stmtDuracao = $conn->prepare($duracaoPlanoQuery);
    $stmtDuracao->bind_param("i", $plano_id);
    $stmtDuracao->execute();
    $resultDuracao = $stmtDuracao->get_result();

    if ($resultDuracao->num_rows > 0) {
        $duracaoRow = $resultDuracao->fetch_assoc();
        $duracaoPlanoMeses = (int) $duracaoRow['tempo']; // Duração em meses

        // Calcule a data de vencimento com base na data atual e na duração do plano
        $dataVencimento = date('Y-m-d', strtotime("+$duracaoPlanoMeses months"));
    } else {
        $duracaoPlanoMeses = 0; // Valor padrão caso não encontre
        $dataVencimento = date('Y-m-d'); // Define como a data atual se não encontrar
    }

    // Buscar o nome do plano usando o plano_id
    $nomePlanoQuery = "SELECT nome_plano FROM plano WHERE plano_id = ?";
    $stmtNomePlano = $conn->prepare($nomePlanoQuery);
    $stmtNomePlano->bind_param("i", $plano_id);
    $stmtNomePlano->execute();
    $resultNomePlano = $stmtNomePlano->get_result();

    if ($resultNomePlano->num_rows > 0) {
        $rowPlano = $resultNomePlano->fetch_assoc();
        $nome_plano = htmlspecialchars($rowPlano['nome_plano']);
    } else {
        $nome_plano = "Nenhum plano ativo encontrado.";
    }
} else {
    $nome_plano = "Nenhum plano ativo encontrado.";
    $dataVencimento = null; // Nenhuma data de vencimento se não houver plano
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
                <li><a class="btn-quem-somos" href="indexLogadoCliente.html">Home</a></li>
                <li><a href="produtos.php">Produtos</a></li>
                <li><a class="btn-servicos" href="serviços.html">Serviços</a></li>
                <li><a class="btn-servicos" href="equipe.html">Sobre nós</a></li>
                <li><a href="avaliar.php" target="_blank">Avalie-nos</a></li>
                <li><a href="src/php/logout.php">Logout</a></li>
                <li><a
                        href="mailto:g3hunterbugs@gmail.com?subject=Mensagem para Vanguard de um cliente&body=Preciso de ajuda">Suporte</a>
                </li>
            </ul>
        </nav>
    </header>

    <main class="home">
        <img class="imagem-fundo" src="src/imagem/Fundo/fundo-perfil.png" alt="fundo de uma cidade de noite">
        <div class="painel">
            <form class="perfil" action="perfil.php">
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
                                <a href="editarPerfil.php?usuario_id=<?= htmlspecialchars($user_Id) ?>"
                                    title="Editar Perfil" class="btn btn-light">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                        <path
                                            d="M14.078 7.061l2.861 2.862-10.799 10.798-3.584.723.724-3.585 10.798-10.798zm0-2.829l-12.64 12.64-1.438 7.128 7.127-1.438 12.642-12.64-5.691-5.69zm7.105 4.277l2.817-2.82-5.691-5.689-2.816 2.817 5.69 5.692z" />
                                    </svg>
                                </a>
                            </li>

                            <li class="nav-item"><a class="btn btn-outline-light" href="acesso.php">Buscar produto</a></li>
                        </ul>

                        <br><br><br>

                        <div class="descricao">
                            <h1 class="titulo">Planos Ativos</h1>
                            <p><?php echo $nome_plano; ?></p>
                            <?php if ($dataVencimento): ?>
                                <p>Data de Vencimento: <?php echo date('d/m/Y', strtotime($dataVencimento)); ?></p>
                            <?php else: ?>
                                <p>Nenhum plano ativo.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
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

            <a href="instagram link" id="instagram" title="Instagram" target="_blank"><img
                    src="src/imagem/icones/instagram.png" alt="botão do perfil do instagram da Vanguard"></a>

            <a href="discord" title="discord" id="discord" target="_blank"><img src="src/imagem/icones/discord.png"
                    alt="botão do chat do discord da Vanguard "></a>

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

                <a href="avaliar.html">
                  <h6>Avaliar</h6>
                </a>
                <hr />
                <a href="serviços.html">
                    <h6>Nossos serviços</h6>
                </a>
                <hr />
                <a href="cronograma.html">
                
                    <h6>
                        Nosso cronograma
                    </h6>
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