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
   $p_planos = $_POST['p_plano']; // Array de planos selecionados
   $p_descricao = $_POST['p_descricao'];
   $p_imagem = $_FILES['p_imagem']['name'];
   $p_imagem_tmp_name = $_FILES['p_imagem']['tmp_name'];

   $p_imagem_folder = 'src/imagem/produtos/' . $p_imagem;

   // Inserir o produto na tabela de produtos
   $insert_produto = $conn->prepare("INSERT INTO `produtos` (nome_produto, classe, descricao, imagem) VALUES (?, ?, ?, ?)");
   $insert_produto->bind_param("ssss", $p_nome, $p_classe, $p_descricao, $p_imagem);

   if ($insert_produto->execute()) {
      // Obter o último ID do produto inserido
      $produto_id = $conn->insert_id;

      // Inserir os planos associados
      // Inserir os planos associados
      foreach ($p_planos as $p_plano) {
         $insert_query = $conn->prepare("INSERT INTO `produto_plano` (plano_id, produto_id) VALUES (?, ?)");
         $insert_query->bind_param("ii", $p_plano, $produto_id);
         $insert_query->execute();
      }


      if (move_uploaded_file($p_imagem_tmp_name, $p_imagem_folder)) {
         $message[] = 'Produto adicionado com sucesso';
      } else {
         $message[] = 'Falha ao mover a imagem do produto';
      }
   }
}


// Processa a atualização de um produto
if (isset($_POST['update_product'])) {
   $update_p_produto_id = $_POST['update_p_produto_id'];
   $update_p_nome_produto = $_POST['update_p_nome_produto'];
   $update_p_classe = $_POST['update_p_classe'];
   $update_p_plano = $_POST['update_p_plano'];
   $update_p_descricao = $_POST['update_p_descricao'];
   $update_p_imagem = $_FILES['update_p_imagem']['name'];
   $update_p_imagem_tmp_name = $_FILES['update_p_imagem']['tmp_name'];
   $update_p_imagem_folder = 'src/imagem/produtos/' . $update_p_imagem;

   // Usa prepared statement para prevenir SQL Injection na atualização
   $update_query = $conn->prepare("UPDATE `produtos` SET nome_produto = ?, classe = ?, plano_id = ?, descricao = ?, imagem = ? WHERE produto_id = ?");
   $update_query->bind_param("ssissi", $update_p_nome_produto, $update_p_classe, $update_p_plano, $update_p_descricao, $update_p_imagem, $update_p_produto_id);

   if ($update_query->execute()) {
      move_uploaded_file($update_p_imagem_tmp_name, $update_p_imagem_folder);
      $message[] = 'Produto atualizado com sucesso';
      header('location:estoque.php');
      exit;
   } else {
      $message[] = 'Não foi possível atualizar o produto';
   }
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
   <link rel="shortcut icon" href="src/imagem/icones/escudo.png" type="image/x-icon">
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
      <a href="dashboard.php">Home</a>
      <a href="contas.php">Visualizar os usuários</a>
      <a href="plano.php">Visualizar os Planos</a>
      <a href="src/php/logout.php">Logout</a>
   </nav>

   <div id="menu-btn" class="fas fa-bars"></div>
</header>

<?php
if (isset($message)) {
   foreach ($message as $msg) {
      echo '<div class="message"><span>' . $msg . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i></div>';
   }
}
?>

<div class="container">
   <section class="home">
      <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
         <h3>Adicionar novo produto</h3>
         <input type="text" name="p_nome" placeholder="Digite o nome do produto" class="box" required>
         <input type="text" name="p_classe" placeholder="Digite a classe desse produto" class="box" required>
         <span>Selecione um ou mais planos</span>
         <select name="p_plano[]" class="box" multiple required>
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
                        <a href="atualizar_produto.php?update=<?php echo $row['produto_id']; ?>"
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
   integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5/5+Yt5g5u0/9XNh4O/4+xD/5uX/Y7uZ55a9FpuJ" crossorigin="anonymous"></script>
<script src="src/js/script.js"></script>

</body>

</html>