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



// Verifica se o botão de cancelar plano foi pressionado
if (isset($_POST['cancelar_plano'])) {
    $cancelarPlanoQuery = "UPDATE usuario SET plano_id = NULL WHERE usuario_id = ?";
    $stmtCancel = $conn->prepare($cancelarPlanoQuery);
    $stmtCancel->bind_param("i", $user_Id);
    
    if ($stmtCancel->execute()) {
        header('Location: perfil.php?msg=Plano cancelado com sucesso.');
        exit;
    } else {
        header('Location: perfil.php?msg=Erro ao cancelar o plano.');
        exit;
    }
}
// Obter o plano_id associado ao último checkout do usuário

$checkoutQuery = "SELECT plano_id FROM usuario WHERE usuario_id = ?";
$stmtCheckout = $conn->prepare($checkoutQuery);
$stmtCheckout->bind_param("i", $user_Id);
$stmtCheckout->execute();
$resultCheckout = $stmtCheckout->get_result();

if ($resultCheckout->num_rows > 0) {
    // Lógica para quando há um plano ativo
    $checkoutRow = $resultCheckout->fetch_assoc();
    $plano_id = $checkoutRow['plano_id'];
    // Mais lógica...
} else {
    // Aqui deve ser o else correspondente
    $nome_plano = "Nenhum plano ativo encontrado.";
    $dataVencimento = null; // Nenhuma data de vencimento se não houver plano
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

$sql_query_plan = "SELECT * FROM plano ORDER BY nome_plano ASC";
$sql_result = $conn->query($sql_query_plan) or die($conn->error);
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
                <li><a class="btn-quem-somos" href="indexLogadoCliente.html">Página inicial</a></li>
                <li><a href="produtos.php">Produtos</a></li>
                <li><a class="btn-servicos" href="equipeLogado.html">Sobre nós</a></li>
                <li class="contato">Entre em contato: <br><strong>(42) 984276920 </strong></li>

                <li><a href="src/php/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="home">
        <img class="imagem-fundo" src="src/imagem/Fundo/fundo-perfil.png" alt="fundo de uma cidade de noite">
        <div class="painel">
        <form class="perfil" action="perfil.php" method="POST">
                <?php if (isset($user_Id) && !empty($fotoUsuario)): ?>
                    <div class="area-foto">
                        <img src="src/imagem/pessoas/<?php echo htmlspecialchars($fotoUsuario); ?>" alt="">
                    </div>
                    <div class="info">
                        <h1 class="bem-vindo">Seja Bem Vindo(a)</h1>
                        <h2 class='nome'><p><?php echo htmlspecialchars($nomeUsuario); ?></p></h2>
                        <ul class="nav nav-pills" style="gap:20px; justify-content:center;">
                            <li class="nav-item">
                                <a href="editarPerfil.php?usuario_id=<?= htmlspecialchars($user_Id) ?>" title="Editar Perfil" class="btn btn-outline-light">Editar <br> Perfil</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-outline-light" href="acesso.php">Buscar <br> produto</a>
                            </li>
                            <li class="nav-item">
                                <a id="plano" class="btn btn-outline-light">Assine agora! / <br> Atualize seu plano</a>
                            </li>
                            <li class="nav-item">
                                <input type="hidden" name="cancelar_plano" value="1">
                                <button type="submit" class="btn btn-danger">Cancelar Plano</button>
                            </li>
                        </ul>

                        <br><br><br>
                        <div class="descricao">
                            <h1 class="titulo">Planos Ativos</h1>
                            <p><?php echo $nome_plano; ?></p>
                            <?php if ($dataVencimento): ?>
                                <p>Data de Vencimento: <?php echo date('d/m/Y', strtotime($dataVencimento)); ?></p>
                            <?php else: ?>
                                <p>Nenhum plano ativo.</p><br>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </form>
        </div>



        <!-- Fundo escuro -->
        <div class="overlay"></div>

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
<script src="src/js/showPlan.js"></script>
<script>
        // Exibir a div de planos ao clicar no botão "Assine agora! / Atualize seu plano"
        document.getElementById('plano').addEventListener('click', function () {
            document.getElementById('confirmPlan').style.display = 'block';
            document.querySelector('.overlay').style.display = 'block'; // Exibir o fundo escuro
        });

        // Fechar a div de planos ao clicar no botão "Cancelar"
        document.getElementById('cancelBtn').addEventListener('click', function () {
            document.getElementById('confirmPlan').style.display = 'none';
            document.querySelector('.overlay').style.display = 'none'; // Ocultar o fundo escuro
        });
    </script>

</html>