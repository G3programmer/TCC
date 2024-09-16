<?php
include ('conexao.php');

if (!isset($_GET['busca'])) {
    echo "Nenhum termo de busca foi fornecido.";
} else {
    $pesquisa = $conn->real_escape_string($_GET['busca']);
    $sql_code = "SELECT * FROM produtos WHERE nome_produto LIKE '%$pesquisa%' OR classe LIKE '%$pesquisa%'";
    $sql_query = $conn->query($sql_code) or die("ERRO ao consultar! " . $conn->error); 
    

    if ($sql_query->num_rows == 0) {
        echo "<h3 class='aviso'>Nenhum resultado encontrado...</h3>";
    } else {
        while ($dados = $sql_query->fetch_assoc()) {
            $binary = $dados['imagem'];
            ?>


        <input name="busca" value="<?php if(isset($_GET['busca'])) echo $_GET['busca']; ?>" type="text">

        <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/index-produto.css">
    <link rel="stylesheet" href="../css/style-produtos.css">
    <link rel="shortcut icon" href="../imagem/icones/escudo.png" type="image/x-icon">
    ">
    <link href="https://fonts.cdnfonts.com/css/milestone-one" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">
    <title>Vanguard | Produtos</title>
</head>

<form id="formBusca" action="src/php/pesquisaProdutos.php" method="GET">
            <div class="caixa-pesquisa">

                <input type="text" name="busca" class="barra" placeholder="Busco por...">
                <button type="submit" class="pesquisa-btn">
                    <img src="src/imagem/icones/lupa-azul.png" alt="" class="lupa-azul" width="25px" height="25px">
                    </button>
            </div>
        </form>
        <h1 class="titulo">Nossos Produtos</h1>
                <!--começa o carrossel aqui-->
<?php
if ($sql_query->num_rows == 0) {
        echo "
        <div class='aviso'>
        <h3>Nenhum resultado encontrado...</h3>
        </div>";
             } else {
            while ($dados = $sql_query->fetch_assoc()) {
                $binary = $dados['imagem'];
            }
        }
            ?>
      <h1 class="titulo">Nossos Produtos</h1>

      <div class="aviso">
        <h3>Nenhum resultado encontrado...</h3>
        </div>    

       <h1 class="titulo">Sistemas Operacionais</h1>                        
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
            <?php
        }
    }
}
    ?>