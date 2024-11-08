<?php 
include("src/php/conexao.php");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.cdnfonts.com/css/milestone-one" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">
    <title>Vanguard | Guias de instalação</title>
</head>

<body style="overflow-y:hidden;">
    <header class="cabecalho">
        <div class="logo">
            <img src="src/imagem/logos/VanguardLogo - titulo.png" alt="Logo da Vanguard" />
        </div>
        <button id="OpenMenu">&#9776;</button>
        <nav id="menu">
            <button id="CloseMenu">X</button>
            <ul class="menu">
                <li><a href="indexLogadoCliente.html">Página inicial</a></li>
                <li class="contato">solicite um teste: <br><strong>(42) 984276920 </strong></li>
                <li><a href="equipeLogado.html">Sobre nós</a></li>
                <li><a href="perfil.php">Perfil</a></li>
                <li><a href="src/php/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="home-guide">
        <div class="container" style="z-index:1000; margin-top:70px; height:600px;">
            <h1 class="titulo-guide">Lista de Produtos com Guias de Instalação</h1>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php
                // Consulta com JOIN para buscar produtos e conteúdo dos guias de instalação
                $sql = "
                    SELECT produtos.produto_id AS produto_id, produtos.nome_produto AS produto_nome, 
                           produtos.imagem, guias_instalacao.conteudo AS guia_conteudo
                    FROM produtos
                    LEFT JOIN guias_instalacao ON produtos.produto_id = guias_instalacao.produto_id
                    ORDER BY produtos.nome_produto ASC
                ";

                // Executa a consulta
                $resultado = $conn->query($sql);

                if ($resultado) {
                    if ($resultado->num_rows > 0) {
                        while ($linha = $resultado->fetch_assoc()) {
                            echo '<div class="col">';
                            // Usa o conteúdo como link
                            $link = htmlspecialchars($linha['guia_conteudo']); // Aqui usamos o conteúdo como link
                            echo '<a href="' . $link . '" class="text-decoration-none" target="_blank">'; // Link para o conteúdo do guia
                            echo '<div class="card h-100">';

                            // Verifica se a imagem é válida e exibe
                            if (!empty($linha["imagem"])) {
                                echo '<img src="src/imagem/produtos/' . htmlspecialchars($linha["imagem"]) . '" class="card-img-top" alt="' . htmlspecialchars($linha["produto_nome"]) . '" style="height: 200px; object-fit: cover;">';
                            } else {
                                echo '<img src="src/imagem/icones/default-image.png" class="card-img-top" alt="Imagem padrão" style="height: 200px; object-fit: cover;">'; // Imagem padrão
                            }

                            echo '<div class="card-body">';
                            echo '<h5 class="card-title">' . htmlspecialchars($linha["produto_nome"]) . '</h5>';

                            // Exibe o conteúdo dos guias de instalação
                            if (!empty($linha['guia_conteudo'])) {
                                echo '<p class="card-text">Clique para ver o guia de instalação.</p>'; // Mensagem para o guia
                            } else {
                                echo '<p class="card-text">Nenhum guia de instalação disponível.</p>'; // Mensagem se não houver guia
                            }

                            echo '</div>'; // Fecha card-body
                            echo '</div>'; // Fecha card
                            echo '</a>'; // Fecha link
                            echo '</div>'; // Fecha col
                        }
                    } else {
                        echo '<p>Nenhum produto encontrado.</p>'; // Mensagem se não houver produtos
                    }
                } else {
                    echo 'Erro na consulta: ' . $conn->error; // Mensagem de erro na consulta
                }

                $conn->close(); // Fecha a conexão com o banco de dados
                ?>
            </div>
        </div>
    </main>
</body>

</html>
