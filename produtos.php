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
                    <a href="carrinho.php" class="cart">cart</a>
                </li>
                <li>
                    <a href="servicos.html" target="_blank">Serviços</a>
                </li>
                <li>
                    <a
                        href="mailto:g3hunterbugs@gmail.com?subject=Mensagem para Vanguard de um cliente&body=Preciso de ajuda">Suporte</a>
                </li>
            </ul>
        </nav>
    </header>
    <main class="home">
        <div class="content">
            <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" style="">
                <div class="carousel-inner" style="display:; margin-left:90%; margin-top:30%;">
                    <div class="carousel-indicators">

                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0"
                            class="active" aria-current="true" aria-label="Slide 1"></button>

                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                            aria-label="Slide 2"></button>

                        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                            aria-label="Slide 3"></button>
                    </div>


                    <div class="carousel-item active">
                        <img src="src/imagem/produtos/slide1.png" class="d-block" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="src/imagem/produtos/slide2.png" class="d-block" alt="...">
                    </div>
                    <div class="carousel-item">
                        <img src="src/imagem/produtos/slide3.png" class="d-block" alt="...">
                    </div>
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
                    <img src="src/imagem/icones/lupa-Branca.png" alt="" class="lupa-branca" width="25px" height="25px">
                    </a>
            </div>
        </form>
        <h1 class="titulo">Nossos Produtos</h1>

        <!--começa a lista aqui-->

        <h1 class="titulo">Sistemas Operacionais</h1>

        <!--parrot-->
        <div class="row" style="gap:4pc;">
            <div class="card col-1" style="width: 15rem; background:black; color:#fff; justify-content:center;">
                <img src="src/imagem/produtos/parrot.png" class="card-img-top" alt="..."
                    style="display:grid; width: 7pc; margin:auto; padding-top:10px;">
                <div class="card-body">
                    <h5 class="card-title">Parrot</h5>
                    <p class="card-text">Um dos sistemas utilizados para pentest defencivo.</p>
                    <a href="#" class="btn btn-primary">Ver mais</a>
                </div>
            </div>

            <br>
            <!--Arch-->
            <div class="card col-2" style="width: 15rem; background:black; color:#fff; justify-content:center;">
                <img src="src/imagem/produtos/BlackArch.png" class="card-img-top" alt="..."
                    style="display:grid; width: 7pc; margin:auto; padding-top:10px;">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's
                        content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>

            <br>

            <!--Kali-->
            <div class="card col-3" style="width: 15rem; background:black; color:#fff; justify-content:center;">
                <img src="src/imagem/produtos/kali.png" class="card-img-top" alt="..."
                    style="display:grid; width: 7pc; margin:auto; padding-top:10px;">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's
                        content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <br>
        <!--linha 2-->
        <!--Backbox-->
        <div class="row" style="gap:4pc;">
            <div class="card col-1" style="width: 15rem; background:black; color:#fff; justify-content:center;">
                <img src="src/imagem/produtos/backbox.png" class="card-img-top" alt="..."
                    style="display:grid; width: 7pc; margin:auto; padding-top:10px;">
                <div class="card-body">
                    <h5 class="card-title">Parrot</h5>
                    <p class="card-text">Um dos sistemas utilizados para pentest defencivo.</p>
                    <a href="#" class="btn btn-primary">Ver mais</a>
                </div>
            </div>

            <br>
            <!--Samurai-->
            <div class="card col-2" style="width: 15rem; background:black; color:#fff; justify-content:center;">
                <img src="src/imagem/produtos/Samurai-Web-Testing-Framework.png" class="card-img-top" alt="..."
                    style="display:grid; width: 7pc; margin:auto; padding-top:10px;">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's
                        content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <br>
        </div>


        <!--Segunda parte -->

        <h1 class="titulo">Ferramentas</h1>
        <!--ripper-->
        <div class="row" style="gap:4pc;">
            <div class="card col-1" style="width: 15rem; background:black; color:#fff; justify-content:center;">
                <img src="src/imagem/produtos/JTR.png" class="card-img-top" alt="..."
                    style="display:grid; width: 7pc; margin:auto; padding-top:10px;">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's
                        content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>

            <br>

            <!--nmap-->
            <div class="card col-2" style="width: 15rem; background:black; color:#fff; justify-content:center;">
                <img src="src/imagem/produtos/nmap.png" class="card-img-top" alt="..."
                    style="display:grid; width: 7pc; margin:auto; padding-top:10px;">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's
                        content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>

            <br>
            <!--metasploit-->
            <div class="card col-3" style="width: 15rem; background:black; color:#fff; justify-content:center;">
                <img src="src/imagem/produtos/metasploit.png" class="card-img-top" alt="..."
                    style="display:grid; width: 7pc; margin:auto; padding-top:10px;">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's
                        content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        </div>
        <!--linha 2-->
        <br>
        <!--maltego-->
        <div class="row" style="gap:4pc;">
            <div class="card col-1" style="width: 15rem; background:black; color:#fff; justify-content:center;">
                <img src="src/imagem/produtos/maltego.png" class="card-img-top" alt="..."
                    style="display:grid; width: 7pc; margin:auto; padding-top:10px;">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's
                        content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>

            <br>

            <!--burp-->
            <div class="card col-2" style="width: 15rem; background:black; color:#fff; justify-content:center;">
                <img src="src/imagem/produtos/burp-suite.png" class="card-img-top" alt="..."
                    style="display:grid; width: 7pc; margin:auto; padding-top:10px;">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's
                        content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>

            <br>
        </div>

        <!-- Terceira parte -->

        <h1 class="titulo">Proteções</h1>

        <div class="row" style="gap:4pc;">
            <div class="card col-1" style="width: 15rem; background:black; color:#fff; justify-content:center;">
                <img src="src/imagem/produtos/powerfull.png" class="card-img-top" alt="..."
                    style="display:grid; width: 13pc; margin:auto; padding-top:10px;">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
                        card's
                        content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
            <br>
    </section>


    <script src="src/js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

    <script src="src/js/botoes.js"></script>
    <script src="src/js/troca_produto_imagem.js"></script>
    <script src="src/js/vitrine.js"></script>
</body>


<!--Precisa alterar as flechas adicionando isso "onclick="nextSlide(this) e prevSlide(this)"-->

</html>