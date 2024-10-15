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

    // Consultar o plano do usuário
    $sqlPlano = "SELECT plano_id FROM usuario WHERE usuario_id = ? LIMIT 1";
    $stmtPlano = $conn->prepare($sqlPlano);
    $stmtPlano->bind_param("i", $user_Id);
    $stmtPlano->execute();
    $resultPlano = $stmtPlano->get_result();

    if ($resultPlano->num_rows > 0) {
        $rowPlano = $resultPlano->fetch_assoc();
        $planoId = $rowPlano['plano_id'];

        // Consultar os produtos relacionados ao plano
        $sqlProdutos = "SELECT produtos.* FROM produto_plano 
                        JOIN produtos ON produto_plano.produto_id = produtos.produto_id 
                        WHERE produto_plano.plano_id = ?";
        $stmtProdutos = $conn->prepare($sqlProdutos);
        $stmtProdutos->bind_param("i", $planoId);
        $stmtProdutos->execute();
        $resultProdutos = $stmtProdutos->get_result();

     
        $produtos = [];
        while ($rowProduto = $resultProdutos->fetch_assoc()) {
            $produtos[] = $rowProduto;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vanguard | Planos</title>
    <!-- Font Awesome CDN link -->
    <link rel="shortcut icon" href="src/imagem/icones/escudo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.cdnfonts.com/css/eingrantch-mono" rel="stylesheet">
    <link rel="stylesheet" href="src/css/index-plano.css">
    <link rel="stylesheet" href="src/css/style-acesso.css">
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
                    <a href="indexLogadoCliente.html">Página inicial</a>

                </li>
                <li>
                    <a href="servicos.html" target="_blank">Serviços</a>
                </li>
                <li>
                    <a href="perfil.php">Perfil</a>
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
        <div class="lista">
            <h2>Produtos disponíveis no seu plano:</h2>
            <!-- <div class="produtos-lista"> -->
            <?php foreach ($produtos as $produto): ?>
                <ul>
                    <li>
                        <img src="src/imagem/produtos/<?php echo htmlspecialchars($produto['imagem']); ?>" alt="Produto"
                            style="width: 150px; height: auto; border-radius: 10px;">
                        <h3><?php echo htmlspecialchars($produto['nome_produto']); ?></h3>
                        <p><?php echo htmlspecialchars($produto['descricao']); ?></p>
                    </li>
                <?php endforeach; ?>

            </ul>

        </div>
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