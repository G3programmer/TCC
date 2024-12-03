<?php
include_once('src/php/conexao.php');

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                <li><a href="index.html">Página inicial</a></li>
                <li><a href="equipe.html">Sobre nós</a></li>
                <li class="contato">Solicite um teste: <br><strong>(42) 984276920</strong></li>
                <li><a href="formulario.php">Cadastre-se</a></li>
                <li><a href="login.html">Login</a></li>
            </ul>
        </nav>
    </header>

    <main class="home">
        <div id="carouselExampleCaptions" class="carousel slide">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <a href="#sistema">
                        <img src="src/imagem/produtos/3.png" class="d-block w-100" alt="Slide 1">
                    </a>
                </div>
                <div class="carousel-item">
                    <a href="#ferramentas">
                        <img src="src/imagem/produtos/2.png" class="d-block w-100" alt="Slide 2">
                    </a>
                </div>
                <div class="carousel-item">
                    <a href="#protecao">
                        <img src="src/imagem/produtos/1.png" class="d-block w-100" alt="Slide 3">
                    </a>
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
        <p class="text">Utilize nossas distribuições de sistemas e ferramentas!</p>

        <div class="produtos">
    <h1 class="titulo" id="sistema">Sistemas Operacionais</h1>
    <?php
    $select_sistema = exibirProdutos($conn, 'sistem');
    if ($select_sistema->num_rows > 0) {
        echo '<div class="grid-container" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">';
        while ($row = $select_sistema->fetch_assoc()) {
            ?>
            <div class="card" style="background:black; color:#fff; padding: 20px; text-align:center;">
                <img src="src/imagem/produtos/<?php echo $row['imagem']; ?>" class="card-img-top" style="height:130px; width:100%; object-fit: contain; margin-bottom: 15px;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['nome_produto']; ?></h5>
                    <p class="card-text"><?php echo $row['classe']; ?></p>
                    <p class="card-text descricao"><?php echo $row['descricao']; ?></p>
                    <button class="btn btn-secondary btn-leia-mais" onclick="toggleDescricao(this)">Ler mais</button>
            
                        <a href="login.html">
                            <button class="btn btn-primary btn-customizado assinar-btn">Logue ou crie uma conta e baixe</button>
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
</div>


<div class="produtos">
    <h1 class="titulo" id="ferramentas">Ferramentas</h1>
    <?php
    $select_ferramentas = exibirProdutos($conn, 'ferramentas');
    if ($select_ferramentas->num_rows > 0) {
        echo '<div class="grid-container" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">';
        while ($row = $select_ferramentas->fetch_assoc()) {
            ?>
            <div class="card" style="background:black; color:#fff; padding: 20px; text-align:center;">
                <img src="src/imagem/produtos/<?php echo $row['imagem']; ?>" class="card-img-top" style="height:130px; width:100%; object-fit: contain; margin-bottom: 15px;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['nome_produto']; ?></h5>
                    <p class="card-text"><?php echo $row['classe']; ?></p>
                    <p class="card-text descricao"><?php echo $row['descricao']; ?></p>
                    <button class="btn btn-secondary btn-leia-mais" onclick="toggleDescricao(this)">Ler mais</button>

                    <a href="login.html">
                        <button class="btn btn-primary btn-customizado assinar-btn">Logue ou crie uma conta e baixe</button>
                    </a>
                </div>
            </div>
            <?php
        }
        echo '</div>';
    } else {
        echo '<p>Nenhum produto encontrado na categoria Ferramentas.</p>';
    }
    ?>
</div>

<div class="produtos">
    <h1 class="titulo" id="protecao">Proteção</h1>
    <?php
    $select_protecao = exibirProdutos($conn, 'protecao');
    if ($select_protecao->num_rows > 0) {
        echo '<div class="grid-container" style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">';
        while ($row = $select_protecao->fetch_assoc()) {
            ?>
            <div class="card" style="background:black; color:#fff; padding: 20px; text-align:center;">
                <img src="src/imagem/produtos/<?php echo $row['imagem']; ?>" class="card-img-top" style="height:130px; width:100%; object-fit: contain; margin-bottom: 15px;">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $row['nome_produto']; ?></h5>
                    <p class="card-text"><?php echo $row['classe']; ?></p>
                    <p class="card-text descricao"><?php echo $row['descricao']; ?></p>
                    <button class="btn btn-secondary btn-leia-mais" onclick="toggleDescricao(this)">Ler mais</button>

                    <a href="login.html">
                        <button class="btn btn-primary btn-customizado assinar-btn">Logue ou crie uma conta e baixe</button>
                    </a>
                </div>
            </div>
            <?php
        }
        echo '</div>';
    } else {
        echo '<p>Nenhum produto encontrado na categoria Proteção.</p>';
    }
    ?>
</div>



    </section>


    <!-- Fundo escuro -->
    <div class="overlay" style="display: none;"></div>

    <div id="confirmPlan" class="plan" style="display: none;">
        <div class="plan-content">
            <h2>Veja nossos planos</h2>
            <p>Escolha um de nossos planos para assinar</p>
            <!-- Exibição de planos -->
            <div id="confirmPlan" class="plan" style="display: none;">
        <div class="plan-content">
            <h2>Veja nossos planos</h2>
            <p>Escolha um de nossos planos para assinar</p>
            <div class="plan-options">
                <?php
                $query = "SELECT * FROM plano";
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
    // Seleciona o botão de download e a div de agradecimento
    document.getElementById("downloadButton").addEventListener("click", function(event) {
        event.preventDefault(); // Impede o download imediato

        // Exibe a div de agradecimento e o overlay
        document.getElementById("confirmacaoDiv").style.display = "block";
        document.getElementById("overlay").style.display = "block";
        
        // Aguarda um momento antes de iniciar o download
        setTimeout(function() {
            window.location.href = "Arquivo-simulando-instalação.bat";
        }, 1000); // Inicia o download após 1 segundo
    });

    // Função para fechar a div de agradecimento
    function fecharDiv() {
        document.getElementById("confirmacaoDiv").style.display = "none";
        document.getElementById("overlay").style.display = "none";
    }

    // Função para visualizar o manual
    function verManual() {
        window.open("manual.php", "_blank");
    }
</script>





<script src="src/js/showPlan.js"></script>

</html>