<?php
session_start();
include_once('src/php/conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
    header('Location: login.html');
    exit;
}

// Processamento do formulário
if (isset($_GET['adicionar'])) {
    $produto_nome = $_GET['nome_produto'];
    $produto_preco = $_GET['preco'];
    $produto_classe = $_GET['classe'];
    $produto_descricao =$_GET['descricao'];

    // Verifica se a imagem foi enviada corretamente
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        // Obtenha os detalhes do arquivo
        $fileTmpPath = $_FILES['foto']['tmp_name'];
        $fileNome = $_FILES['foto']['name'];
        $fileSize = $_FILES['foto']['size'];
        $fileType = $_FILES['foto']['type'];
        $foto = addslashes(file_get_contents($fileTmpPath));

            // Verifica se o produto já existe no carrinho
            $select_cart = mysqli_query($conn, "SELECT * FROM `carrinho` WHERE nome_produto = '$produto_nome'");

            if (mysqli_num_rows($select_cart) > 0) {
                echo "<script>alert('Produto já adicionado ao carrinho!');</script>";
            } else {
                // Insere os dados no banco de dados
                $insert_product = mysqli_query($conn, "INSERT INTO `carrinho` (nome_produto, preco, classe, descricao, imagem, quantidade) VALUES ('$produto_nome', '$produto_preco', '$produto_classe', '$produto_descricao', '$imagem_nome', '$produto_quantidade')");

                if ($insert_product) {
                    echo "<script>alert('Produto adicionado ao carrinho com sucesso!');</script>";
                } else {
                    echo "<script>alert('Falha ao adicionar o produto!');</script>";
                }
            }
        } else {
            echo "<script>alert('Erro ao fazer upload da imagem!');</script>";
        }
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
    ">
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
                    <a href="servicos.html" target="_blank">Serviços</a>
                </li>
                <li>

                    <?php

                    $select_rows = mysqli_query($conn, "SELECT * FROM `carrinho`") or die('query failed');
                    $row_count = mysqli_num_rows($select_rows);

                    ?>

                <li>
                    <a href="carrinho.php"><img class="carrinho" src="src/imagem/icones/carrinho-de-compras.png"
                            alt=""><span><?php echo $row_count; ?></span> </a>
                </li>
                <li>
                    <a
                        href="mailto:g3hunterbugs@gmail.com?subject=Mensagem para Vanguard de um cliente&body=Preciso de ajuda">Suporte</a>
                </li>
            </ul>
        </nav>
    </header>
    <main class="home">
        <?php

        if (isset($message)) {
            foreach ($message as $message) {
                echo '<div class="message"><span>' . $message . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
            }
            ;
        }
        ;

        ?>
        <!-- Teste -->
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

                <div class="carousel-item active" data-bs-interval="5000">
                    <a href="#sistema">
                        <img src="src/imagem/produtos/1.png" class="d-block w-100" alt="...">
                    </a>
                </div>

                <div class="carousel-item" data-bs-interval="5000">
                    <a href="#ferramentas">
                        <img src="src/imagem/produtos/2.png" class="d-block w-100" alt="...">
                    </a>
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <a href="#protecao">
                        <img src="src/imagem/produtos/3.png" class="d-block w-100" alt="...">
                    </a>
                </div>
            </div>
        </div>
        </div>
    </main>
    <section class="compre-ja">



        <form id="formBusca" action="src/php/pesquisaProdutos.php" method="GET">
            <div class="caixa-pesquisa">

                <input type="text" name="busca" class="barra" placeholder="Busco por...">
                <button type="submit" class="pesquisa-btn">
                    <img src="src/imagem/icones/lupa-azul.png" alt="" class="lupa-azul" width="25px" height="25px">
                </button>
            </div>
        </form>
        <h1 class="titulo">Nossos Produtos</h1>

        <!--começa a lista aqui-->
        <div class="produtos">
            <h1 class="titulo" id="sistema">Sistemas Operacionais</h1>
            <form method="post" enctype="multipart/form-data">
                <?php
                $select_sistema = mysqli_query($conn, "SELECT * FROM `produtos` WHERE classe = 'Sistema Operacional'");
                if (mysqli_num_rows($select_sistema) > 0) {
                    ?>
                    <div class="grid-container" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                        <?php
                        while ($row = mysqli_fetch_assoc($select_sistema)) {
                            ?>
                            <div class="card" style="background:black; color:#fff; padding: 20px; text-align:center;">
                                <img src="src/imagem/produtos/<?php echo $row['imagem']; ?>" class="card-img-top"
                                    style="height:130px; width:100%; object-fit: contain; margin-bottom: 15px;">

                                <input type="hidden" name="produto_id" value="<?php echo $row['produto_id']; ?>">

                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['nome_produto']; ?></h5>
                                    <p class="card-text">$<?php echo $row['preco']; ?> - <?php echo $row['classe']; ?></p>
                                    <br>
                                    <p class="card-text descricao"><?php echo $row['descricao']; ?></p>

                                    <a href="checkout.php" class="btn btn-primary btn-customizado">Compre/Assine agora!</a>
                                    <button name="adicionar" type="submit" class="carrinho"><img class="carrinho-imagem"
                                            src="src/imagem/icones/carrinho-de-compras.png" alt="">
                                    </button>
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <?php
                }
                ?>
                <h1 class="titulo" id="ferramentas">Ferramentas</h1>
                <?php
                $select_ferramenta = mysqli_query($conn, "SELECT * FROM `produtos` WHERE classe = 'Ferramenta'");
                if (mysqli_num_rows($select_ferramenta) > 0) {
                    ?>
                    <div class="grid-container" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                        <?php
                        while ($row = mysqli_fetch_assoc($select_ferramenta)) {
                            ?>
                            <div class="card" style="background:black; color:#fff; padding: 20px; text-align:center;">
                                <img src="src/imagem/produtos/<?php echo $row['imagem']; ?>" class="card-img-top"
                                    style="height:130px; width:100%; object-fit: contain; margin-bottom: 15px;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['nome_produto']; ?></h5>
                                    <p class="card-text">$<?php echo $row['preco']; ?> - <?php echo $row['classe']; ?></p>
                                    <br>
                                    <p class="card-text descricao"><?php echo $row['descricao']; ?></p>

                                    <a href="checkout.php" class="btn btn-primary btn-customizado">Compre/Assine agora!</a>
                                    <button name="adicionar" type="submit" class="carrinho"><img class="carrinho-imagem"
                                            src="src/imagem/icones/carrinho-de-compras.png" alt="">
                                    </button>
                                </div>

                            </div>

                            <?php
                        } ?>
                    </div>
                    <?php
                }
                ?>


                <!-- Terceira parte -->

                <h1 class="titulo" id="protecao">Proteções</h1>

                <?php
                $select_protecao = mysqli_query($conn, "SELECT * FROM `produtos` WHERE classe = 'Proteção'");
                if (mysqli_num_rows($select_protecao) > 0) {
                    ?>
                    <div class="grid-container" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                        <?php
                        while ($row = mysqli_fetch_assoc($select_protecao)) {
                            ?>
                            <div class="card" style="background:black; color:#fff; padding: 20px; text-align:center;">
                                <img src="src/imagem/produtos/<?php echo $row['imagem']; ?>" class="card-img-top"
                                    style="height:130px; width:100%; object-fit: contain; margin-bottom: 15px;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['nome_produto']; ?></h5>
                                    <p class="card-text">$<?php echo $row['preco']; ?> - <?php echo $row['classe']; ?></p>
                                    <br>
                                    <p class="card-text"><?php echo $row['descricao']; ?></p>
                                    <a href="checkout.php" class="btn btn-primary btn-customizado">Compre/Assine agora!</a>
                                    <button name="adicionar" type="submit" class="carrinho"><img class="carrinho-imagem"
                                            src="src/imagem/icones/carrinho-de-compras.png" alt="">
                                    </button>
                                </div>
                            </div>
                    </form>
                    <?php
                        }
                        ?>
            </div>
            <?php
                }
                ?>

        <br>
        </div>
    </section>


    <script src="src/js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script src="src/js/botoes.js"></script>
    <script src="src/js/vitrine.js"></script>
</body>


</html>