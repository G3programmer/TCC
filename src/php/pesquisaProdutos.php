<?php
include ('index.php');

if (!isset($_GET['busca'])) {
    echo "<p>Nenhum termo de busca foi fornecido.</p>";
} else {
    $pesquisa = $conn->real_escape_string($_GET['busca']);
    $sql_code = "SELECT * 
                 FROM produto 
                 WHERE nome LIKE '%$pesquisa%' 
                    OR cor LIKE '%$pesquisa%'
                    OR preco LIKE '%$pesquisa%'";

    $sql_query = $conn->query($sql_code) or die("Erro na consulta: " . $conn->error);

    if ($sql_query->num_rows == 0) {
        echo "<p>Nenhum resultado encontrado...</p>";
    } else {
        while ($dados = $sql_query->fetch_assoc()) {
            ?>


<!--analisar ainda se vale a pena-->
            <?php
            // Caminho base para as imagens
            $caminho_imagens = '../imagens/produtos/';

            $produtos = [
                [
                    'nome' => 'AP360',
                    'descricao' => 'Descrição do Produto 1',
                    'imagem' => [
                        $imagem . '../imagem/produtos/ap360.png'
                    ]
                ],
                [
                    'nome' => 'AP 1350',
                    'descricao' => 'Descrição do Produto 2',
                    'imagem' => [
                        $imagem . ''
                    ]
                ],
                // Adicione mais produtos conforme necessário
            ];
            ?>





            <?php foreach ($produtos as $produto): ?>
                <div class="cartao">
                    <div class="informacoes">
                        <h3 class="titulo"><?php echo $produto['nome']; ?></h3>
                        <p class="texto"><?php echo $produto['descricao']; ?></p>
                        <div class="imagens-produto">
                            <?php foreach ($produto['imagens'] as $imagem): ?>
                                <img src="<?php echo $imagem; ?>" alt="<?php echo $produto['nome']; ?>">
                            <?php endforeach; ?>
                        </div>
                        <a href="#" class="btn-comprar">Comprar</a>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php
        }
    }
}


?>