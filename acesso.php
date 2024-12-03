<!--CONTROLE DE SESSÃO PARA USUÁRIOS E SEUS PLANOS-->
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

        // Redireciona se o usuário não tiver um plano
        if (empty($planoId)) {
            header('Location: produtos.php');
            exit;
        }

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
} else {
    // Redireciona para login caso o usuário não seja encontrado
    header('Location: login.html');
    exit;
}
?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vanguard | Seus produtos</title>
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
            <h2 class="titulo">Produtos disponíveis no seu plano:</h2>
    <br>
            <div class="guide">
                <a href="manual.php" target="_blank"><button class="guia">Acesse os guias de <br> instalação
                        aqui!</button></a>
            </div>
    
    <br>        <!-- <div class="produtos-lista"> -->
            <?php foreach ($produtos as $produto): ?>

                <div class="card" style="height:auto;">
                    <img src="src/imagem/produtos/<?php echo htmlspecialchars($produto['imagem']); ?>" alt="Produto"
                        style="width: 10pc; height: auto; border-radius: 10px; margin:auto;">
                    <div class="card-body">
                        <h3><?php echo htmlspecialchars($produto['nome_produto']); ?></h3>
                        <h5><?php echo htmlspecialchars($produto['classe']); ?></h5>
                        <br>
                        <p><?php echo htmlspecialchars($produto['descricao']); ?></p>

                        <a href="Arquivo-simulando-instalação.bat" onclick="mostrarMensagem()" download>
                            <button class="btn btn-primary btn-customizado assinar-btn">Baixe agora!</button>
                        </a>

                    </div>
                </div>
            <?php endforeach; ?>

        </div>
        <br>

        <div id="overlay"
            style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); z-index: 1040;">
        </div>
        <div id="confirmacaoDiv"
            style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgb(0, 109, 0); color: #fff; padding: 20px; border-radius: 10px; text-align: center; font-size: 24px; max-width: 400px; z-index: 1050;">
            <span id="fechar" onclick="fecharDiv()"
                style="position: absolute; margin-top: -20px; right: 10px; font-size: 24px; cursor: pointer;">×</span>
            <p>Obrigado por baixar! Preparando sua instalação!</p>
            <button onclick="verManual()"
                style="background-color: #4CAF50; color: white; border: none; padding: 10px 20px; margin-top: 15px; cursor: pointer; border-radius: 5px;">
                Ver Manual
            </button>
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
        
        <a href="malito:g3hunterbugs@gmail.com?subject=Mensagem para Vanguard de um cliente&body=Preciso de ajuda">
            <h6>
                Suporte
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
<script>
    function mostrarMensagem() {
        // Mostra a mensagem de confirmação
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('confirmacaoDiv').style.display = 'block';

        // Iniciar o download do arquivo após 3 segundos
        setTimeout(() => {
            window.location.href = '/instalador.bat';
        }, 3000);
    }

</script>

<script>
    function mostrarMensagem() {
        document.getElementById("confirmacaoDiv").style.display = "block";
        setTimeout(() => {
            document.getElementById("confirmacaoDiv").style.display = "none";
        }, 10000);
    }
</script>

<script>
    function mostrarMensagem() {
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('confirmacaoDiv').style.display = 'block';
    }

    function fecharDiv() {
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('confirmacaoDiv').style.display = 'none';
    }

    function verManual() {
        alert('Direcionando para o manual!');
        // Aqui você pode adicionar a lógica para redirecionar para o manual
    }
</script>
<script>

    function mostrarDiv() {
        document.getElementById("overlay").style.display = "block";
        document.getElementById("confirmacaoDiv").style.display = "block";
    }

    function fecharDiv() {
        document.getElementById("overlay").style.display = "none";
        document.getElementById("confirmacaoDiv").style.display = "none";
    }

    function verManual() {
        window.open('manual.php', '_blank');
    }
</script>
<script>
    function baixarArquivo(nomeArquivo) {
        const link = document.createElement('a');
        link.href = 'src/downloads/' + nomeArquivo; // Caminho para o arquivo de download
        link.download = nomeArquivo; // Nome do arquivo que será baixado
        link.click();
    }
</script>


</html>