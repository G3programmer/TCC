<?php
session_start();
include_once('src/php/conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
    unset($_SESSION['email'], $_SESSION['senha']);
    header('Location: login.html');
    exit;
}

$logado = $_SESSION['email'];

$email = $_SESSION['email']; // Assumindo que o email do usuário está na sessão
$result = $conn->query("SELECT plano_id FROM usuario WHERE email = '$email'");

if ($result) {
    $usuario = $result->fetch_assoc();
    if (!empty($usuario['plano_id'])) {
        // Se o plano_id não estiver vazio, redireciona para perfil.php
        header('Location: acesso.php');
        exit;
    }
}

function exibirProdutos($conn, $classe) {
    $stmt = $conn->prepare("SELECT * FROM produtos WHERE classe LIKE ?");
    $searchTerm = '%' . $classe . '%';
    $stmt->bind_param("s", $searchTerm);
    $stmt->execute();
    return $stmt->get_result();
}
?>




<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/index-produto.css">
    <link rel="stylesheet" href="src/css/style-produtos.css">
    <link rel="stylesheet" href="src/css/responsividade/responsivo.css">
    <link rel="shortcut icon" href="src/imagem/icones/escudo.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.cdnfonts.com/css/milestone-one" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">
    <title>Vanguard | Produtos</title>
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
                    <a href="equipeLogado.html"> Sobre nós</a>
                </li>
                <li class="contato">
                    solicite um teste: <br><strong>(42) 984276920 </strong>
                </li>
                <li>
                    <a href="perfil.php">Perfil</a>
                </li>
                <li>
                    <a href="src/php/logout.php">Logout</a>
                </li>
            </ul>
        </nav>
    </header>
    <main class="home">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">

                <div class="carousel-item active" data-bs-interval="4000">
                    <a href="#sistema">
                        '' <img src="src/imagem/produtos/3.png" class="d-block w-100" alt="...">
                    </a>
                </div>

                <div class="carousel-item" data-bs-interval="4000">
                    <a href="#ferramentas">
                        <img src="src/imagem/produtos/2.png" class="d-block w-100" alt="...">
                    </a>
                </div>
                <div class="carousel-item" data-bs-interval="4000">
                    <a href="#protecao">
                        <img src="src/imagem/produtos/1.png" class="d-block w-100" alt="...">
                    </a>
                </div>
            </div>
        </div>
        </div>
    </main>
    
    <section class="compre-ja">
    <div class="guias">
  <?php
    $produto_id = isset($_GET['produto_id']) ? $_GET['produto_id'] : null;
if ($produto_id) {
    $query = $conn->prepare("SELECT * FROM guias_instalacao WHERE produto_id = ?");
    $query->bind_param("i", $produto_id);
    $query->execute();
    $result = $query->get_result();
    // Exibe os guias ou uma mensagem caso não exista
if ($result->num_rows > 0) {
    while ($guia = $result->fetch_assoc()) {
        echo "<h2>{$guia['titulo']}</h2>";
        echo "<p>{$guia['conteudo']}</p>";
    }
} else {
    echo "<p>Nenhum guia de instalação disponível para este produto.</p>";
}
}
?>
    </div>


    <h1 class="titulo">Faça você mesmo!</h1>
    <p class="text">Utilize das distribuições de sistemas e ferramentas que ofertamos aqui também! <br> Ou se preferir, das ferramentas Vanguard!</p>

    <div class="produtos">


    <h1 class="titulo" id="sistema">Sistemas Operacionais</h1>
<?php
$select_sistema = exibirProdutos($conn, 'sistem');
if (mysqli_num_rows($select_sistema) > 0) {
    echo '<div class="grid-container" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">';
    while ($row = mysqli_fetch_assoc($select_sistema)) {
        ?>
        <div class="card" style="background:black; color:#fff; padding: 20px; text-align:center;">
            <img src="src/imagem/produtos/<?php echo $row['imagem']; ?>" class="card-img-top"
                style="height:130px; width:100%; object-fit: contain; margin-bottom: 15px;">

                <div class="card-body">

                <h5 class="card-title"><?php echo $row['nome_produto']; ?></h5>
                <p class="card-text"><?php echo $row['classe']; ?></p>
                <p class="card-text descricao"><?php echo $row['descricao']; ?></p>

                <button class="btn btn-secondary btn-leia-mais" onclick="toggleDescricao(this)">Ler mais</button>

                <a href="Arquivo-simulando-instalação.bat" onclick="mostrarMensagem()" download>
                    <button class="btn btn-primary btn-customizado assinar-btn">Baixe agora!</button>
                </a>
            </div>
        </div>
        <?php
    }
    echo '</div>';
} else {
    echo '<p>Nenhum produto encontrado na categoria Sistemas Operacionais.</p>';
}
?>



<!-- Inclua o CSS do Bootstrap (opcional) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Div de agradecimento -->
<div id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); z-index: 1040;"></div>
<div id="confirmacaoDiv" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: rgb(0, 109, 0); color: #fff; padding: 20px; border-radius: 10px; text-align: center; font-size: 24px; max-width: 400px; z-index: 1050;">
    <span id="fechar" onclick="fecharDiv()" style="position: absolute; margin-top: -20px; right: 10px; font-size: 24px; cursor: pointer;">×</span>
    <p>Obrigado por baixar! Preparando sua instalação!</p>
    <button onclick="verManual()" style="background-color: #4CAF50; color: white; border: none; padding: 10px 20px; margin-top: 15px; cursor: pointer; border-radius: 5px;">
        Ver Manual
    </button>
</div>

</div>
<div class="guide">
<a href="manual.php" target="_blank"><button class="guia">Acesse os guias de <br> instalação aqui!</button></a>
</div>





<h1 class="titulo" id="ferramentas">Ferramentas</h1>
            <div class="subscription-info">
                <p>Para ter acesso a outras ferramentas, assine um plano.</p>
                <a href="#" class="btn-assinar">Assinar Plano</a>
            </div>

            <h1 class="titulo" id="protecao">Produtos Vanguard</h1>
            <div class="subscription-info">
                <p>Para ter acesso a outras ferramentas, assine um plano.</p>
                <a href="#" class="btn-assinar">Assinar Plano</a>
            </div>

    </div>
</section>


    <!-- Fundo escuro -->
    <div class="overlay" style="display: none;"></div>

    <div id="confirmPlan" class="plan" style="display: none;">
        <div class="plan-content">
            <h2>Veja nossos planos</h2>
            <p>Escolha um de nossos planos para assinar</p>
            <!-- Exibição de planos -->
            <div class="plan-options">
                <form method="POST" enctype="multipart/form-data">
                    <div class="plan-options">
                        <?php
                        $query = "SELECT * FROM plano"; // Ajuste conforme sua tabela de planos
                        $result = $conn->query($query);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo '<div class="plan-item">';
                                echo '<h4>' . $row['nome_plano'] . '</h4>';
                                echo '<p>Preço: R$ ' . number_format($row['preco_plano'], 2, ',', '.') . '</p>';
                                echo '<p>Sobre: ' . $row['descricao'] . '</p>';
                                echo '<a class="btn btn-primary selectPlanBtn" href="checkout.php?plano_id=' . $row['plano_id'] . '">Selecionar</a>';
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </form>
            </div>

            <!-- Botão de Cancelar -->
            <button type="button" id="cancelBtn" class="btn btn-danger">Cancelar</button>
        </div>
    </div>

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
                <h6>Entre em contato: <br><strong>(42) 984276920 </strong></h6>
                </a>
                <hr />
                <a
                    href="malito:g3hunterbugs@gmail.com?subject=Mensagem para Vanguard de um cliente&body=Preciso de ajuda">
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
<script src="src/js/index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="src/js/botoes.js"></script>

<script>
    function mostrarMensagem() {
        const confirmacaoDiv = document.getElementById('confirmacaoDiv');
        confirmacaoDiv.style.display = 'block';

        // Ocultar a mensagem após 10 segundos
        setTimeout(() => {
            confirmacaoDiv.style.display = 'none';
        }, 10000);
    }
</script>

<script>
function toggleDescricao(button) {
    const descricao = button.previousElementSibling;
    if (descricao.classList.contains('expandido')) {
        descricao.classList.remove('expandido');
        button.textContent = 'Ler mais';
    } else {
        descricao.classList.add('expandido');
        button.textContent = 'Ler menos';
    }
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
    // Função para mostrar a div
    function mostrarMensagem() {
        var confirmacaoDiv = document.getElementById('confirmacaoDiv');
        var overlay = document.getElementById('overlay');
        
        // Mostrar a div de confirmação
        confirmacaoDiv.style.display = 'block';
        overlay.style.display = 'block';

        // Após 10 segundos, esconder a div
        setTimeout(function() {
            confirmacaoDiv.style.display = 'none';
            overlay.style.display = 'none';
        }, 10000); // 10000 milissegundos = 10 segundos
    }

    // Chamar a função mostrarMensagem quando a página carregar
    window.onload = function() {
        mostrarMensagem();
    };

    // Função para fechar a div manualmente
    function fecharDiv() {
        var confirmacaoDiv = document.getElementById('confirmacaoDiv');
        var overlay = document.getElementById('overlay');
        confirmacaoDiv.style.display = 'none';
        overlay.style.display = 'none';
    }

    // Função para mostrar o manual
    function verManual() {
        window.location.href = 'manual.php';
    }
</script>




<script src="src/js/showPlan.js"></script>

</html>