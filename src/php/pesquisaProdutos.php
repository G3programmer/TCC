<?php
include('conexao.php');

// Verifica se o termo de busca foi fornecido
if (!isset($_GET['busca'])) {
    echo "<h3 class='aviso'>Nenhum termo de busca foi fornecido.</h3>";
} else {
    $pesquisa = $conn->real_escape_string($_GET['busca']);
    
    // Consulta SQL para buscar produtos que tenham o nome ou a classe que correspondem à pesquisa
    $sql_code = "SELECT * FROM produtos WHERE nome_produto LIKE '%$pesquisa%' OR classe LIKE '%$pesquisa%'";
    $sql_query = $conn->query($sql_code) or die("ERRO ao consultar! " . $conn->error); 

    // Verifica se houve resultados
    if ($sql_query->num_rows == 0) {
        echo "<h3 class='aviso'>Nenhum resultado encontrado...</h3>";
    } else {
        // Exibe os produtos encontrados
        while ($dados = $sql_query->fetch_assoc()) {
            $binary = $dados['imagem'];
            ?>

            <!DOCTYPE html>
            <html lang="pt-BR">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="../css/index-produto.css">
                <link rel="stylesheet" href="../css/style-produtos.css">
                <link rel="shortcut icon" href="../imagem/icones/escudo.png" type="image/x-icon">
                <link href="https://fonts.cdnfonts.com/css/milestone-one" rel="stylesheet">
                <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">
                <title>Vanguard | Produtos</title>
            </head>
            <body>

            <!-- Formulário de busca -->
            <form id="formBusca" action="pesquisaProdutos.php" method="GET">
                <div class="caixa-pesquisa">
                    <input type="text" name="busca" class="barra" placeholder="Busco por..." value="<?php echo isset($_GET['busca']) ? $_GET['busca'] : ''; ?>">
                    <button type="submit" class="pesquisa-btn">
                        <img src="../imagem/icones/lupa-azul.png" alt="Lupa" class="lupa-azul" width="25px" height="25px">
                    </button>
                </div>
            </form>

            <!-- Título da página -->
            <h1 class="titulo">Nossos Produtos</h1>

            <!-- Exibe os produtos em cartões -->
            <div class="lista">
                <div class="cartao">
                    <div class="informacoes"> 
                        <img src="data:image/jpeg;base64,<?= base64_encode($binary) ?>" alt="Imagem do produto" class="imagem" />
                        <h3 class="titulo"><?php echo $dados['nome_produto']; ?></h3>
                        <p class="texto"><?php echo $dados['descricao']; ?></p>
                    </div>
                    <a href="#" class="btn-comprar">Comprar</a>
                </div>
            </div>

            </body>
            </html>

            <?php
        }
    }
}
?>
