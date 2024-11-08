<?php
session_start();
include_once('src/php/conexao.php');

// Verifica se o usuário está logado, caso contrário redireciona para o login
if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: login.html');
    exit;
}

$email = $_SESSION['email'];
$senha = $_SESSION['senha'];

$stmt = $conn->prepare("SELECT is_admin FROM usuario WHERE email = ? AND senha = ?");
$stmt->bind_param("ss", $email, $senha);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Verifica se o usuário é administrador
    if ($row['is_admin'] == 1) {
        if (basename($_SERVER['PHP_SELF']) !== 'guia.php') {
            header('Location: guia.php');
            exit;
        }
    } else {
        if (basename($_SERVER['PHP_SELF']) !== 'perfil.php') {
            header('Location: perfil.php');
            exit;
        }
    }
} else {
    header('Location: login.html');
    exit;
}

$logado = $_SESSION['email'];

// Busca todos os produtos
$sql_produtos = "SELECT * FROM produtos ORDER BY produto_id ASC";
$resulte_produtos = $conn->query($sql_produtos);

// Verifica se a consulta para produtos foi bem-sucedida
if (!$resulte_produtos) {
    die("Erro ao executar consulta: " . $conn->error);
}

// Processa o formulário de adicionar guia
if (isset($_POST['add_guia'])) {
    $produto_id = $_POST['produto_id'];
    $links = $_POST['links'];
    if (!empty($produto_id) && !empty($links)) {
        $stmt = $conn->prepare("INSERT INTO guias_instalacao (produto_id, conteudo) VALUES (?, ?)");
        $stmt->bind_param("is", $produto_id, $links);
        $stmt->execute();
        header("Location: guia.php");
        exit;
    } else {
        echo "Por favor, preencha todos os campos.";
    }
}

// Processa a atualização de um guia
// Processa a atualização de um guia
if (isset($_POST['update_guia'])) {
    $guia_id = $_POST['guia_id'];
    $produto_id = $_POST['produto_id']; // Certifique-se de que o nome do campo é igual ao que está no formulário
    $conteudo = $_POST['conteudo'];

    $stmt = $conn->prepare("UPDATE guias_instalacao SET produto_id = ?, conteudo = ? WHERE guia_id = ?");
    $stmt->bind_param("isi", $produto_id, $conteudo, $guia_id);
    if ($stmt->execute()) {
        header("Location: guia.php");
        exit;
    } else {
        echo "Erro ao atualizar guia: " . $stmt->error; // Adicionando mensagem de erro para debugging
    }
}

// Processa a exclusão de um guia
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $stmt = $conn->prepare("DELETE FROM guias_instalacao WHERE guia_id = ?");
    $stmt->bind_param("i", $delete_id);
    $stmt->execute();
    header("Location: guia.php");
    exit;
}

// Consulta para obter guias cadastrados
$sql_guias = "SELECT g.guia_id, g.produto_id, g.conteudo, p.nome_produto 
              FROM guias_instalacao g
              JOIN produtos p ON g.produto_id = p.produto_id 
              ORDER BY g.produto_id ASC";
$result_guias = $conn->query($sql_guias);
?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vanguard | Cadastrar Guias</title>
    <link rel="icon" href="src/imagem/icones/escudo.png" type="image/png">

    <link rel="stylesheet" href="src/css/index-estoque.css">
    <link rel="stylesheet" href="src/css/style-contas.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">
</head>
<body>
<header class="cabecalho" style="font-size:4px; margin:3px; padding:3px;">
    <div class="logo">
        <a href="dashboard.html" class="logo"><img src="src/imagem/logos/VanguardLogo - titulo.png" alt="Logo da Vanguard" /></a>
    </div>
    <nav class="menu" id="menu">
    <li><a href="dashboard.php">Home</a></li>
      <li><a href="estoque.php">Visualizar produtos</a></li>
      <li><a href="contas.php">Visualizar usuários</a></li>
      <li><a href="plano.php">Visualizar Planos</a></li>
      <li><a href="log.php">Visualizar Checkouts</a> </li>
      <li><a href="src/php/logout.php">Logout</a></li>
    </nav>
    <div id="menu-btn" class="fas fa-bars"></div>
</header>
<main class="home-guia display-product-table">
    <div class="container">
        <h2>Cadastrar Guias</h2>

<!-- Formulário para cadastrar guia -->
<form method="POST">
    <label for="produto">Selecionar Produto:</label>
    <select name="produto_id" id="produto" required>
        <option value="">Selecione um produto</option>
        <?php while ($produto = $resulte_produtos->fetch_assoc()): ?>
            <option value="<?= $produto['produto_id'] ?>"><?= htmlspecialchars($produto['nome_produto']) ?></option>
        <?php endwhile; ?>
    </select>
    <label for="links">Conteúdo (links):</label>
    <textarea name="links" id="links" required></textarea>
    <button type="submit" name="add_guia">Cadastrar Guia</button>
</form>

<!-- Tabela de guias com botões de Editar e Excluir -->
<table class="table table-dark table-hover">
    <thead>
        <tr>
            <th>ID do Produto</th>
            <th>Nome do Produto</th>
            <th>Links</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($guia = $result_guias->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($guia['produto_id']) ?></td>
                <td><?= htmlspecialchars($guia['nome_produto']) ?></td>
                <td><?= htmlspecialchars($guia['conteudo']) ?></td>
                <td>
                    <a href="?edit_id=<?= $guia['guia_id'] ?>" class="btn btn-warning">Editar</a>
                    <a href="?delete_id=<?= $guia['guia_id'] ?>" class="btn btn-danger" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<?php
        if (isset($_GET['edit_id'])) {
            $edit_id = $_GET['edit_id'];
            $sql_edit = $conn->prepare("SELECT * FROM guias_instalacao WHERE guia_id = ?");
            $sql_edit->bind_param("i", $edit_id);
            $sql_edit->execute();
            $guia_edit = $sql_edit->get_result()->fetch_assoc();
        }
        ?>

<?php if (isset($guia_edit)): ?>
    <div class="form-overlay active" id="editOverlay"> <!-- Adicione a classe active aqui -->
        <div class="form-content">
            <h3>Editar Guia</h3>
            <form action="guia.php" method="POST">
                <input type="hidden" name="guia_id" value="<?= htmlspecialchars($guia_edit['guia_id']) ?>">

                <label for="produto">Selecionar Produto:</label>
                <select name="produto_id" id="produto" required>
                    <option value="">Selecione um produto</option>
                    <?php
                    // Rewind the produtos result set to show products again for the edit form
                    $resulte_produtos->data_seek(0); // Reset the result set
                    while ($produto = $resulte_produtos->fetch_assoc()): ?>
                        <option value="<?= $produto['produto_id'] ?>" <?= ($guia_edit['produto_id'] == $produto['produto_id']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($produto['nome_produto']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                
                <label for="conteudo">Conteúdo:</label>
                <textarea name="conteudo" id="conteudo" required><?= htmlspecialchars($guia_edit['conteudo']) ?></textarea>

                <br> <button type="submit" name="update_guia">Atualizar Guia</button>
                <br> <a href="guia.php" class="btn btn-secondary" style="background: rgb(136, 3, 3);">Cancelar</a>
            </form>
        </div>
    </div>
<?php endif; ?>

    </div>
</main>
</body>
<script>
// Função para fechar o formulário de edição
function closeEditForm() {
    const editForm = document.getElementById('editOverlay');
    editForm.classList.remove('active'); // Remove a classe que exibe a sobreposição
}

// Quando a página carrega, verifique se um ID de edição está presente
window.onload = function() {
    const editId = new URLSearchParams(window.location.search).get('edit_id');
    const editForm = document.getElementById('editOverlay');

    if (editId) {
        editForm.classList.add('active'); // Mostra a sobreposição
    }
}

</script>

</html>

<?php $conn->close(); ?>