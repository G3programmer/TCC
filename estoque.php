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

if (isset($_POST['add_product'])) {
   $p_nome = $_POST['p_nome'];
   $p_classe = $_POST['p_classe'];
   $p_plano = $_POST['p_plano'];
   $p_descricao = $_POST['p_descricao'];
   $p_imagem = $_FILES['p_imagem']['name']; // Corrigido de 'nome' para 'name'
   $p_imagem_tmp_name = $_FILES['p_imagem']['tmp_name']; // Corrigido de 'tmp_nome' para 'tmp_name'

   $p_imagem_folder = 'src/imagem/produtos/' . $p_imagem;

   $insert_query = mysqli_query($conn, "INSERT INTO `produtos`(nome_produto, classe, plano_id, descricao, imagem) VALUES('$p_nome','$p_classe','$p_plano', '$p_descricao', '$p_imagem')") or die('query failed');


   if ($insert_query) {
      move_uploaded_file($p_imagem_tmp_name, $p_imagem_folder);
      $message[] = 'product add succesfully';
   } else {
      $message[] = 'could not add the product';
   }
}
;

if (isset($_GET['delete'])) {
   $delete_produto_id = $_GET['delete'];
   $delete_query = mysqli_query($conn, "DELETE FROM `produtos` WHERE produto_id = $delete_produto_id ") or die('query failed');
   if ($delete_query) {
      header('location:estoque.php');
      $message[] = 'product has been deleted';
   } else {
      header('location:estoque.php');
      $message[] = 'product could not be deleted';
   }
   ;
}
;

if (isset($_POST['update_product'])) {
   $update_p_produto_id = $_POST['update_p_produto_id'];
   $update_p_nome_produto = $_POST['update_p_nome_produto'];
   $update_p_classe = $_POST['update_p_classe'];
   $update_p_plano = $_POST['update_p_plano'];
   $update_p_descricao = $_POST['update_p_descricao'];
   $update_p_imagem = $_FILES['update_p_imagem']['name'];
   $update_p_imagem_tmp_name = $_FILES['update_p_imagem']['tmp_name'];
   $update_p_imagem_folder = 'src/imagem/produtos/' . $update_p_imagem;

   $update_query = mysqli_query($conn, "UPDATE `produtos` SET nome_produto = '$update_p_nome_produto', classe = '$update_p_classe',plano_id = '$update_p_plano' , descricao = '$update_p_descricao', imagem = '$update_p_imagem' WHERE produto_id = '$update_p_produto_id'");

   if ($update_query) {
      move_uploaded_file($update_p_imagem_tmp_nome, $update_p_imagem_folder);
      $message[] = 'product updated succesfully';
      header('location:estoque.php');
   } else {
      $message[] = 'product could not be updated';
      header('location:estoque.php');
   }

}

$sql_plan_code = "SELECT * FROM plano ORDER BY nome_plano ASC";
$sql_plan_query = $conn->query($sql_plan_code) or die($conn->error);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title> Vanguard | Controle de estoque </title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

   <link rel="shortcut icon" href="src/imagem/icones/escudo.png" type="image/x-icon">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">
   <link href="https://fonts.cdnfonts.com/css/eingrantch-mono" rel="stylesheet">
   <link rel="stylesheet" href="src/css/index-estoque.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="src/css/style-estoque.css">

</head>

<header class="cabecalho">
   <div class="logo">
      <a href="dashboard.html" class="logo"><img src="src/imagem/logos/VanguardLogo - titulo.png"
            alt="Logo da Vanguard" /> </a>
   </div>

   <nav class="menu" id="menu">
      <a href="dashboard.php">Home</a>
      <a href="contas.php">Visualizar os usuários</a>
      <a href="plano.php">Visualizar os Planos</a>
      <a href="src/php/logout.php">Logout</a>
   </nav>




   <div id="menu-btn" class="fas fa-bars"></div>

   </div>

</header>

<?php

if (isset($message)) {
   foreach ($message as $message) {
      echo '<div class="message"><span>' . $message . '</span> <i class="fas fa-times" onclick="this.parentElement.style.display = `none`;"></i> </div>';
   }
   ;
}
;

?>

<div class="container">

   <section class="home">

      <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
         <h3>Adicionar novo produto</h3>
         <input type="text" name="p_nome" placeholder="Digite o nome do produto" class="box" required>

         <input type="text" name="p_classe" min="0" placeholder="Digite a classe desse produto" class="box" required>

         <select name="p_plano" class="box" min="0" required>
            <option value="">Selecione um plano</option>
            <?php while ($p_plano = $sql_plan_query->fetch_assoc()) { ?>
               <option value="<?php echo $p_plano['plano_id']; ?>">
                  <?php echo $p_plano['nome_plano']; ?>
               </option>
            <?php } ?>
         </select>

         <input type="text" name="p_descricao" min="0" placeholder="Digite aqui a descrição do produto" class="box"
            required>

         <input type="file" name="p_imagem" accept="image/png, image/jpg, image/jpeg" class="box" required>

         <input type="submit" value="Adicionar" name="add_product" class="btn">
      </form>

   </section>

   <main class="display-product-table">

      <table class="table table-dark table-hover">

         <thead>
            <th>imagem</th>
            <th>Nome</th>
            <th>plano</th>
            <th>classe</th>
            <th>descricao</th>
            <th>ação</th>
         </thead>

         <tbody>
            <?php

            $select_produto = mysqli_query($conn, "
SELECT produtos.*, plano.nome_plano 
FROM `produtos` 
JOIN `plano` ON produtos.plano_id = plano.plano_id
");

            if (mysqli_num_rows($select_produto) > 0) {
               while ($row = mysqli_fetch_assoc($select_produto)) {
                  ?>
                  <tr>
                     <td><img src="src/imagem/produtos/<?php echo $row['imagem']; ?>" height="100" alt=""></td>
                     <td><?php echo $row['nome_produto']; ?></td>
                     <td><?php echo $row['nome_plano']; ?></td>
                     <td><?php echo $row['classe']; ?></td>
                     <td><?php echo $row['descricao']; ?></td>
                     <td class="option">
                        <a href="estoque.php?delete=<?php echo $row['produto_id']; ?>" class="btn btn-sm btn-danger"
                           id="delete" onclick="return confirm('are your sure you want to delete this?');">
                           <i class="fas fa-trash"></i> delete
                        </a>
                        <a href="estoque.php?edit=<?php echo $row['produto_id']; ?>" class="btn btn-sm btn-primary">
                           <i class="fas fa-edit"></i> update
                        </a>
                     </td>
                  </tr>
                  <?php
               }
            } else {
               echo "<div class='empty'>no product added</div>";
            }

            ?>
         </tbody>
      </table>

   </main>

   <section class="edit-form-container">
  
<?php if (isset($_GET['edit'])) { 
   $sql_plan_query_edit = $conn->query($sql_plan_code) or die($conn->error);

  $edit_id = $_GET['edit'];
   $edit_query = mysqli_query($conn, "SELECT * FROM `produtos` WHERE produto_id = $edit_id");
   if (mysqli_num_rows($edit_query) > 0) {
      while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
?>
   <form action="" method="post" enctype="multipart/form-data">
      <img src="src/imagem/produtos/<?php echo $fetch_edit['imagem']; ?>" height="200" alt="">

      <input type="hidden" name="update_p_produto_id" value="<?php echo $fetch_edit['produto_id']; ?>">

      <input type="text" class="box" required name="update_p_nome_produto" value="<?php echo $fetch_edit['nome_produto']; ?>">

      <select name="update_p_plano" class="box" min="0" required>
         <option value="">Selecione um plano</option>
         <?php 
         // Preenche o select com os planos e marca o plano atual como selecionado
         while ($update_p_plano = $sql_plan_query_edit->fetch_assoc()) { 
            $selected = ($update_p_plano['plano_id'] == $fetch_edit['plano_id']) ? 'selected' : ''; 
         ?>
            <option value="<?php echo $update_p_plano['plano_id']; ?>" <?php echo $selected; ?>>
               <?php echo $update_p_plano['nome_plano']; ?>
            </option>
         <?php } ?>
      </select>

      <input type="text" min="0" class="box" required name="update_p_classe" value="<?php echo $fetch_edit['classe']; ?>">

      <input type="text" min="0" class="box" required name="update_p_descricao" value="<?php echo $fetch_edit['descricao']; ?>">

      <input type="file" class="box" required name="update_p_imagem" accept="image/png, image/jpg, image/jpeg">

      <input type="submit" value="Atualizar produto" name="update_product" class="btn">

      <input type="reset" value="Cancelar" id="close-edit" class="option-btn">
   </form>

               <?php
            }
            ;
         }
         ;
         echo "<script>document.querySelector('.edit-form-container').style.display = 'flex';</script>";
      }
      ;
      ?>

   </section>

</div>


<footer class="roda-pe">

   <img src="src/imagem/logos/VanguardLogo-Escuro.png" alt="logo da Vanguard" class="logo">



   <h5 class="subtitulo">
      Nos acompanhe pelas redes sociais
   </h5>


   <div class="social_media">

      <a href="facebook link" id="facebook" title="Facebook" target="_blank"><img src="src/imagem/icones/Facebook.png"
            alt="botão do perfil do facebook da Vanguard"></a>

      <a href="https://www.instagram.com/vanguard_security.oficial/" id="instagram" title="Instagram"
         target="_blank"><img src="src/imagem/icones/instagram.png" alt="botão do perfil do instagram da Vanguard"></a>

      <a href="https://discord.gg/BpMEzwTf" title="discord" id="discord" target="_blank"><img
            src="src/imagem/icones/discord.png" alt="botão do chat do discord da Vanguard "></a>

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
         <a href="produtos.php">
            <h6>
               Nossos produtos
            </h6>
         </a>
         <hr />
         <a href="serviços.html">
            <h6>Nossos serviços</h6>
         </a>

         <hr />
         <a href="mailto:vanguard.seguranca.oficial@gmail.com">
            <h6>Suporte</h6>
         </a>
      </div>
   </div>
   </div>
   <p id="copyright">
      Direitos Autorais Reservados à Vanguard&#8482;
   </p>
</footer>
<!-- custom js file link  -->
<script src="src/js/estoque.js"></script>

</body>

</html>