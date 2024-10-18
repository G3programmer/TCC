<?php
session_start();
include_once('src/php/conexao.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
    header('Location: login.html');
    exit;
}

// Processamento do formulário
if (isset($_POST['plano'])) {
    $plano_id = $_POST['plano_id'];
    $plano_nome = $_POST['nome_plano'];
    $plano_preco = $_POST['preco_plano'];
    $plano_tempo = $_POST['tempo'];
    $produto_id = $_POST['produto_id'];

    // Verifica se o produto já existe no carrinho
    $select_plan = mysqli_query($conn, "SELECT * FROM `plano` WHERE nome_plano = '$plano_nome'");

    if (mysqli_num_rows($select_plan) > 0) {
        echo "<script>alert('Assinatura já guardada');</script>";
    } else {
        // Corrigindo a consulta de inserção
        $insert_plan = mysqli_query($conn, "INSERT INTO `plano` (produto_id, nome_plano, preco_plano, tempo) 
               VALUES ('$produto_id', '$plano_nome', '$plano_preco', '$plano_tempo')");

        if ($insert_plan) {
            echo "<script>alert('Produto adicionado ao carrinho com sucesso!');</script>";
        } else {
            echo "<script>alert('Falha ao adicionar o produto!');</script>";
        }
    }
}

$sql_code_plan = "SELECT * FROM plano ORDER BY nome_plano ASC";
$sql_query_plan = $conn->query($sql_code_plan) or die($conn->error);

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
                        <img src="src/imagem/produtos/3.png" class="d-block w-100" alt="...">
                    </a>
                </div>

                <div class="carousel-item" data-bs-interval="5000">
                    <a href="#ferramentas">
                        <img src="src/imagem/produtos/2.png" class="d-block w-100" alt="...">
                    </a>
                </div>
                <div class="carousel-item" data-bs-interval="5000">
                    <a href="#protecao">
                        <img src="src/imagem/produtos/1.png" class="d-block w-100" alt="...">
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
            <form method="POST" enctype="multipart/form-data">

                <?php
                $select_sistema = mysqli_query($conn, "SELECT * FROM `produtos` WHERE classe LIKE '%sistem%' OR classe LIKE '%opera%'");
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

                                <input type="hidden" name="produto_id" value="<?php echo $row['produto_id']; ?>">
                                <input type="hidden" name="nome_plano" value="<?php echo $row['nome_produto']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['nome_produto']; ?></h5>
                                    <p class="card-text"><?php echo $row['classe']; ?></p>
                                    <br>
                                    <p class="card-text descricao"><?php echo $row['descricao']; ?></p>

                                    <button id="plano" class="btn btn-primary btn-customizado">Assine agora!</button>
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
                $select_ferramenta = mysqli_query($conn, "SELECT * FROM `produtos` WHERE classe LIKE '%errament%'");
                if (mysqli_num_rows($select_ferramenta) > 0) {
                    ?>
                    <div class="grid-container" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                        <?php
                        while ($row = mysqli_fetch_assoc($select_ferramenta)) {
                            ?>
                            <div class="card" style="background:black; color:#fff; padding: 20px; text-align:center;">
                                <img src="src/imagem/produtos/<?php echo $row['imagem']; ?>" class="card-img-top"
                                    style="height:130px; width:100%; object-fit: contain; margin-bottom: 15px;">

                                <input type="hidden" name="produto_id" value="<?php echo $row['produto_id']; ?>">

                                <input type="hidden" name="produto_id" value="<?php echo $row['produto_id']; ?>">
                                <input type="hidden" name="nome_plano" value="<?php echo $row['nome_produto']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['nome_produto']; ?></h5>
                                    <p class="card-text"><?php echo $row['classe']; ?></p>
                                    <br>
                                    <p class="card-text descricao"><?php echo $row['descricao']; ?></p>

                                    <button id="plano" class="btn btn-primary btn-customizado">Assine agora!</button>
                                </div>

                            </div>

                            <?php
                        } ?>
                    </div>
                    <?php
                }
                ?>


                <!-- Terceira parte -->

                <h1 class="titulo" id="protecao">Produtos Vanguard</h1>

                <?php
                $select_protecao = mysqli_query($conn, "SELECT * FROM `produtos` WHERE classe LIKE '%prote%'");
                if (mysqli_num_rows($select_protecao) > 0) {
                    ?>
                    <div class="grid-container" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                        <?php
                        while ($row = mysqli_fetch_assoc($select_protecao)) {
                            ?>
                            <div class="card" style="background:black; color:#fff; padding: 20px; text-align:center;">
                                <img src="src/imagem/produtos/<?php echo $row['imagem']; ?>" class="card-img-top"
                                    style="height:130px; width:100%; object-fit: contain; margin-bottom: 15px;">

                                <input type="hidden" name="produto_id" value="<?php echo $row['produto_id']; ?>">
                                <input type="hidden" name="nome_plano" value="<?php echo $row['nome_produto']; ?>">
                                <div class="card-body">
                                    <input type="hidden" name="produto_id" value="<?php echo $row['produto_id']; ?>">

                                    <h5 class="card-title"><?php echo $row['nome_produto']; ?></h5>
                                    <p class="card-text"><?php echo $row['classe']; ?></p>
                                    <br>
                                    <p class="card-text"><?php echo $row['descricao']; ?></p>
                                    <button id="plano" class="btn btn-primary btn-customizado">Assine agora!</button>
                                </div>
                            </div>
                            <?php
                        } ?>

                    </div>

                    <?php
                }
                ?>
            </form>

        </div>
    </section>

<!-- Fundo escuro -->
<?php
// Conectar ao banco de dados
// ...

// Obter o ID do usuário a partir da sessão
$usuario_id = $_SESSION['usuario_id']; // Ajuste conforme sua lógica de autenticação

// Consulta para verificar se o usuário tem um plano ativo
$querye = "SELECT * FROM usuario WHERE usuario_id = ?";
$stmt = $conn->prepare($querye);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resulter = $stmt->get_result();

// Verifica se o usuário tem um plano ativo
if ($resulter->num_rows > 0) {
    $user = $resulter->fetch_assoc();
    
    // Exibe aviso se o usuário tem um plano ativo
    if ($user['plano_id'] != 0) {
        // Exibe uma mensagem informando que o usuário já possui um plano
        echo '<div class="alert alert-warning">Você já possui um plano ativo. Para assinar um novo plano, cancele seu plano atual.</div>';
    }           
} else {
    // Se o usuário não tem plano ativo, mostra as opções de planos
    ?>
    <div id="confirmPlan" class="plan">
        <div class="plan-content">
            <h2>Veja nossos planos</h2>
            <p>Escolha um de nossos planos para assinar</p>

            <!-- Exibição de planos -->
            <div class="plan-options">
                <?php
                // Seleção de planos do banco de dados
                $query = "SELECT * FROM plano"; // Ajuste conforme sua tabela de planos
                $result = $conn->query($query);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="plan-item">';
                        echo '<h4>' . $row['nome_plano'] . '</h4>';
                        echo '<p>Preço: R$ ' . number_format($row['preco_plano'], 2, ',', '.') . '</p>';
                        echo '<p>Sobre: ' . $row['descricao'] . '</p>';
                        // Enviar o plano_id como parâmetro na URL para checkout.php
                        echo '<a href="checkout.php?plano_id=' . $row['plano_id'] . '" class="btn btn-primary">Selecionar</a>';
                        echo '</div>';
                    }
                } else {
                    echo '<p>Não há planos disponíveis.</p>';
                }
                ?>
            </div>

            <!-- Botão de cancelar -->
            <button type="button" id="cancelBtn" class="btn btn-danger">Cancelar</button>
        </div>
    </div>
    <?php
}
?>



</body>
<script src="src/js/index.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
<script src="src/js/botoes.js"></script>
<script src="src/js/showPlan.js"></script>

</html>
