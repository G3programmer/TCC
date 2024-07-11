<?php
include ('index.php');

if (!isset($_GET['busca'])) {
    echo "Nenhum termo de busca foi fornecido.";
} else {
    $pesquisa = $conn->real_escape_string($_GET['busca']);
    $sql_code = "SELECT * FROM produto WHERE nome LIKE '%$pesquisa%' OR classe LIKE '%$pesquisa%'";
    $sql_query = $conn->query($sql_code) or die("ERRO ao consultar! " . $conn->error); 
    

    if ($sql_query->num_rows == 0) {
        echo "<p>Nenhum resultado encontrado...</p>";
    } else {
        while ($dados = $sql_query->fetch_assoc()) {
            $binary = $dados['imagem']; // Supondo que a coluna com o BLOB da imagem seja 'imagem_blob'
            ?>


        <input name="busca" value="<?php if(isset($_GET['busca'])) echo $_GET['busca']; ?>" type="text">

        <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/index-produto.css">
    <link rel="stylesheet" href="src/css/style-produtos.css">
    <link rel="shortcut icon" href="src/imagem/icones/escudo.png" type="image/x-icon">
    ">
    <link href="https://fonts.cdnfonts.com/css/milestone-one" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">
    <title>Vanguard | Produtos</title>
</head>
            <div class="cartao">
                <div class="informacoes"> 
                <img src="data:image/jpeg;base64,<?= base64_encode($binary) ?>" alt="Imagem do produto" class="imagem" />

                <h3 class="titulo"><?php echo $dados['nome']; ?></h3>

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
