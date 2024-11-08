<!--VEJA A TABELA DE EDITAR APENAS ISSO-->

<?php
@include 'src/php/conexao.php';
session_start();

// Verifica se o usuário está logado, caso contrário redireciona para o login
if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: login.html');
    exit;
}

$email = $_SESSION['email'];
$senha = $_SESSION['senha'];

// Usa prepared statement para prevenir SQL Injection
$stmt = $conn->prepare("SELECT is_admin FROM usuario WHERE email = ? AND senha = ?");
$stmt->bind_param("ss", $email, $senha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verifica se o usuário é administrador
    if ($row['is_admin'] == 1) {
        if (basename($_SERVER['PHP_SELF']) !== 'estoque.php') { // Evita redirecionamento em loop
            header('Location: estoque.php');
            exit;
        }
    } else {
        if (basename($_SERVER['PHP_SELF']) !== 'perfil.php') { // Evita redirecionamento em loop
            header('Location: perfil.php');
            exit;
        }
    }
} else {
    header('Location: login.html');
    exit;
}


// Processa a adição de um novo produto
if (isset($_POST['add_product'])) {
    $p_nome = $_POST['p_nome'];
    $p_classe = $_POST['p_classe'];
    $p_planos = isset($_POST['p_plano']) ? $_POST['p_plano'] : []; // Verifica se p_plano está definido
    $p_descricao = $_POST['p_descricao'];
    $p_imagem = $_FILES['p_imagem']['name'];
    $p_imagem_tmp_name = $_FILES['p_imagem']['tmp_name'];
    $p_imagem_folder = 'src/imagem/produtos/' . $p_imagem;

    // Adiciona o produto
    $insert_produto = $conn->prepare("INSERT INTO `produtos` (nome_produto, classe, descricao, imagem) VALUES (?, ?, ?, ?)");
    $insert_produto->bind_param("ssss", $p_nome, $p_classe, $p_descricao, $p_imagem);

    if ($insert_produto->execute()) {
        // Obter o último ID do produto inserido
        $produto_id = $conn->insert_id;

        // Apenas executa o foreach se p_planos não estiver vazio
        if (!empty($p_planos)) {
            foreach ($p_planos as $p_plano) {
                $insert_query = $conn->prepare("INSERT INTO `produto_plano` (plano_id, produto_id) VALUES (?, ?)");
                $insert_query->bind_param("ii", $p_plano, $produto_id);
                $insert_query->execute();
            }
        } else {
            $message[] = 'Nenhum plano selecionado.';
        }

        // Move a imagem
        if (move_uploaded_file($p_imagem_tmp_name, $p_imagem_folder)) {
            $message[] = 'Produto adicionado com sucesso';
        } else {
            $message[] = 'Falha ao mover a imagem do produto';
        }
    } else {
        $message[] = 'Erro ao adicionar o produto: ' . $conn->error;
    }
}


if (isset($_GET['edit'])) {
    $edit_id = mysqli_real_escape_string($conn, $_GET['edit']);
    $product_query = mysqli_query($conn, "SELECT * FROM produtos WHERE produto_id = '$edit_id'");
    $product_data = mysqli_fetch_assoc($product_query);

    if ($product_data) {
        // Recupera os planos associados ao produto
        $planos_associados_query = mysqli_query($conn, "
            SELECT plano_id FROM produto_plano WHERE produto_id = '$edit_id'
        ");
        $planos_associados = [];
        while ($plano_row = mysqli_fetch_assoc($planos_associados_query)) {
            $planos_associados[] = $plano_row['plano_id'];
        }

        // Renderiza o formulário de edição
        ?>
        <div class="edit-form-container" style="display: block; padding-left: 29pc;">
            <h3>Editar Produto</h3>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="update_p_produto_id" value="<?php echo htmlspecialchars($edit_id, ENT_QUOTES); ?>">
                <input type="text" name="update_p_nome"
                    value="<?php echo htmlspecialchars($product_data['nome_produto'], ENT_QUOTES); ?>"
                    placeholder="Nome do produto" class="box" required>
                <textarea name="update_p_descricao" placeholder="Descrição do produto" class="box"
                    required><?php echo htmlspecialchars($product_data['descricao'], ENT_QUOTES); ?></textarea>

                <input type="text" name="update_p_classe"
                    value="<?php echo htmlspecialchars($product_data['classe'], ENT_QUOTES); ?>" placeholder="Classe do produto"
                    class="box" required>

                <span>Selecione um ou mais planos</span>
                <select name="update_p_plano[]" class="box" multiple>
                    <?php
                    // Recupera planos para o dropdown
                    $sql_plan_code = "SELECT * FROM plano ORDER BY nome_plano ASC";
                    $sql_plan_query = $conn->query($sql_plan_code) or die($conn->error);
                    while ($p_plano = $sql_plan_query->fetch_assoc()) {
                        $selected = in_array($p_plano['plano_id'], $planos_associados) ? 'selected' : '';
                        ?>
                        <option value="<?php echo $p_plano['plano_id']; ?>" <?php echo $selected; ?>>
                            <?php echo $p_plano['nome_plano']; ?>
                        </option>
                    <?php } ?>
                </select>

                <input type="file" name="update_p_imagem" accept="image/png, image/jpg, image/jpeg" class="box">

                <input type="submit" name="update_product" value="Atualizar Produto" class="btn">
                <button id="close-edit" class="btn">Fechar</button> <!-- Botão para fechar o formulário -->
            </form>
        </div>
        <?php
    } else {
        echo "<p>Produto não encontrado para edição.</p>";
    }
}



if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];

    try {
        // Primeiro, tenta excluir o produto
        $delete_query = $conn->prepare("DELETE FROM produtos WHERE produto_id = ?");
        $delete_query->bind_param("i", $delete_id);

        if ($delete_query->execute()) {
            // Exclui também os planos associados
            $delete_planos_query = $conn->prepare("DELETE FROM produto_plano WHERE produto_id = ?");
            $delete_planos_query->bind_param("i", $delete_id);
            $delete_planos_query->execute();

            // Exclui a imagem do produto, se existir
            $image_path = 'src/imagem/produtos/' . $_GET['imagem'];
            if (file_exists($image_path)) {
                unlink($image_path);
            }

            $message[] = 'Produto excluído com sucesso';
            header('location:estoque.php');
            exit;
        } else {
            throw new Exception("Não foi possível excluir o produto.");
        }
    } catch (mysqli_sql_exception $e) {
        // Se houver erro de chave estrangeira, exiba a mensagem informativa
        if ($e->getCode() == 1451) { // Código de erro para chave estrangeira no MySQL
            $error_message = "Este produto não pode ser excluído pois está associado a um tutorial de instalação, primeito exclua o tutorial!";
        } else {
            $error_message = "Ocorreu um erro ao tentar excluir o produto.";
        }
    }
}

// Processa a atualização do produto
if (isset($_POST['update_product'])) {
    $update_id = $_POST['update_p_produto_id'];
    $update_nome = $_POST['update_p_nome'];
    $update_classe = $_POST['update_p_classe'];
    $update_descricao = $_POST['update_p_descricao'];
    $update_imagem = $_FILES['update_p_imagem']['name'];
    $update_imagem_tmp_name = $_FILES['update_p_imagem']['tmp_name'];
    $update_imagem_folder = 'src/imagem/produtos/' . $update_imagem;

    // Atualiza o produto
    $update_produto = $conn->prepare("UPDATE produtos SET nome_produto = ?, classe = ?, descricao = ? WHERE produto_id = ?");
    $update_produto->bind_param("sssi", $update_nome, $update_classe, $update_descricao, $update_id);

    if ($update_produto->execute()) {
        // Se uma nova imagem foi carregada, atualize-a
        if (!empty($update_imagem)) {
            // Primeiro, obtenha a imagem atual do banco de dados
            $current_image_query = mysqli_query($conn, "SELECT imagem FROM produtos WHERE produto_id = '$update_id'");
            $current_image_data = mysqli_fetch_assoc($current_image_query);
            $current_image = $current_image_data['imagem'];

            // Tente mover a nova imagem para o diretório
            if (move_uploaded_file($update_imagem_tmp_name, $update_imagem_folder)) {
                // Exclua a imagem anterior se existir
                if (file_exists('src/imagem/produtos/' . $current_image)) {
                    unlink('src/imagem/produtos/' . $current_image);
                }
                // Atualize a imagem no banco de dados
                $update_imagem_query = $conn->prepare("UPDATE produtos SET imagem = ? WHERE produto_id = ?");
                $update_imagem_query->bind_param("si", $update_imagem, $update_id);
                $update_imagem_query->execute();
            } else {
                $message[] = 'Falha ao mover a nova imagem.';
            }
        }

        // Atualiza os planos associados (primeiro exclui os existentes)
        $delete_planos_query = $conn->prepare("DELETE FROM produto_plano WHERE produto_id = ?");
        $delete_planos_query->bind_param("i", $update_id);
        $delete_planos_query->execute();

        // Insere os novos planos
        if (isset($_POST['update_p_plano'])) {
            foreach ($_POST['update_p_plano'] as $p_plano) {
                $insert_query = $conn->prepare("INSERT INTO produto_plano (plano_id, produto_id) VALUES (?, ?)");
                $insert_query->bind_param("ii", $p_plano, $update_id);
                $insert_query->execute();
            }
        }

        $message[] = 'Produto atualizado com sucesso!';
    } else {
        $message[] = 'Erro ao atualizar o produto: ' . $conn->error;
    }
}


if (isset($_POST['update_product'])) {
    // Aqui você processa a atualização do produto

    // Depois de atualizar, você pode adicionar um script para fechar a div
    echo "<script>
            document.getElementsByClassName('edit-form-container')[0].style.display = 'none';
          </script>";
}




// Recupera planos para o dropdown
$sql_plan_code = "SELECT * FROM plano ORDER BY nome_plano ASC";
$sql_plan_query = $conn->query($sql_plan_code) or die($conn->error);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vanguard | Controle de Estoque</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="icon" href="src/imagem/icones/escudo.png" type="image/png">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/eingrantch-mono" rel="stylesheet">
    <link rel="stylesheet" href="src/css/index-estoque.css">
    <link rel="stylesheet" href="src/css/style-estoque.css">
</head>

<header class="cabecalho">
    <div class="logo">
        <a href="dashboard.html" class="logo"><img src="src/imagem/logos/VanguardLogo - titulo.png"
                alt="Logo da Vanguard" /></a>
    </div>
    <nav class="menu" id="menu">
        <li><a href="dashboard.php">Home</a></li>
        <li><a href="guia.php">Visualizar guias</a></li>
        <li><a href="contas.php">Visualizar usuários</a></li>
        <li><a href="plano.php">Visualizar Planos</a></li>
        <li><a href="log.php">Visualizar Checkouts</a> </li>
        <li><a href="src/php/logout.php">Logout</a></li>
    </nav>
    <div id="menu-btn" class="fas fa-bars"></div>
</header>

<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '<div class="message"><span>' . $msg . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i></div>';
    }
} ?>
<?php if (isset($error_message)): ?>
    <div class="error-message"
        style="font-family:'Codygoon'; padding: 10px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; margin-bottom: 10px; border-radius: 5px; font-size:16px;">
        <?php echo $error_message; ?>
    </div>
<?php endif; ?>

<div class="container">
    <section class="home">
        <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
            <h3>Adicionar novo produto</h3>
            <input type="text" name="p_nome" placeholder="Digite o nome do produto" class="box" required>
            <input type="text" name="p_classe" placeholder="Digite a classe desse produto" class="box" required>

            <span>Selecione um ou mais planos</span>
            <select name="p_plano[]" class="box" multiple>
                <?php while ($p_plano = $sql_plan_query->fetch_assoc()) { ?>
                    <option value="<?php echo $p_plano['plano_id']; ?>">
                        <?php echo $p_plano['nome_plano']; ?>
                    </option>
                <?php } ?>
            </select>

            <input type="text" name="p_descricao" placeholder="Digite aqui a descrição do produto" class="box" required>
            <input type="file" name="p_imagem" accept="image/png, image/jpg, image/jpeg" class="box" required>
            <input type="submit" value="Adicionar" name="add_product" class="btn">
        </form>
    </section>



    <main class="display-product-table">
        <table class="table table-dark table-hover">
            <thead>
                <tr>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Plano</th>
                    <th>Classe</th>
                    <th>Descrição</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $select_produto = $conn->query("
            SELECT produtos.*, GROUP_CONCAT(plano.nome_plano SEPARATOR ', ') AS nome_planos
            FROM `produtos`
            JOIN `produto_plano` ON produtos.produto_id = produto_plano.produto_id
            JOIN `plano` ON produto_plano.plano_id = plano.plano_id
            GROUP BY produtos.produto_id
         ");

                if ($select_produto && mysqli_num_rows($select_produto) > 0) {
                    while ($row = mysqli_fetch_assoc($select_produto)) {
                        ?>
                        <tr>
                            <td>
                                <img src="src/imagem/produtos/<?php echo $row['imagem']; ?>" alt="Produto"
                                    style="width: 150px; height: auto; border-radius: 10px;">
                            </td>


                            <td><?php echo $row['nome_produto']; ?></td>
                            <td><?php echo $row['nome_planos']; ?></td> <!-- Exibe todos os planos relacionados -->
                            <td><?php echo $row['classe']; ?></td>
                            <td><?php echo $row['descricao']; ?></td>
                            <td>
                                <a href="estoque.php?delete=<?php echo $row['produto_id']; ?>"
                                    onclick="return confirm('Tem certeza que deseja excluir este produto?');"
                                    class="btn btn-danger">Excluir</a>

                                <a href="estoque.php?edit=<?php echo $row['produto_id']; ?>"
                                    class="btn btn-warning">Atualizar</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='6' class='text-center'>Nenhum produto encontrado.</td></tr>";
                }

                ?>
            </tbody>
        </table>
    </main>



</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5/5+Yt5g5u0/9XNh4O/4+xD/5uX/Y7uZ55a9FpuJ"
    crossorigin="anonymous"></script>
<script src="src/js/estoque.js"></script>

<script> 
  document.addEventListener("DOMContentLoaded", function() {
        const closeButton = document.getElementById("close-edit");
        const editFormContainer = document.querySelector(".edit-form-container");

        closeButton.addEventListener("click", function(event) {
            event.preventDefault(); // Previne o envio do formulário
            editFormContainer.style.display = "none"; // Oculta o formulário
        });
    });
    </script>

</body>

</html>