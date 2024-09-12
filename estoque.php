<?php

@include 'src/php/conexao.php';

if (isset($_POST['add_product'])) {
   $p_nome = $_POST['p_nome'];
   $p_preco = $_POST['p_preco'];
   $p_classe = $_POST['p_classe'];
   $p_imagem = $_FILES['p_imagem']['name']; // Corrigido de 'nome' para 'name'
   $p_imagem_tmp_name = $_FILES['p_imagem']['tmp_name']; // Corrigido de 'tmp_nome' para 'tmp_name'

   $p_imagem_folder = 'src/imagem/produtos/' . $p_imagem;

   $insert_query = mysqli_query($conn, "INSERT INTO `produtos`(nome_produto, preco, classe , imagem) VALUES('$p_nome', '$p_preco','$p_classe', '$p_imagem')") or die('query failed');

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
   $update_p_preco = $_POST['update_p_preco'];
   $update_p_classe = $_POST['update_p_classe'];
   $update_p_imagem = $_FILES['update_p_imagem']['name'];
   $update_p_imagem_tmp_name = $_FILES['update_p_imagem']['tmp_name'];
   $update_p_imagem_folder = 'src/imagem/produtos/' . $update_p_imagem;

   $update_query = mysqli_query($conn, "UPDATE `produtos` SET nome_produto = '$update_p_nome_produto', preco = '$update_p_preco', classe = '$update_p_classe' , imagem = '$update_p_imagem' WHERE produto_id = '$update_p_produto_id'");

   if ($update_query) {
      move_uploaded_file($update_p_imagem_tmp_nome, $update_p_imagem_folder);
      $message[] = 'product updated succesfully';
      header('location:estoque.php');
   } else {
      $message[] = 'product could not be updated';
      header('location:estoque.php');
   }

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title> Vanguard | Controle de estoque </title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

   <link rel="shortcut icon" href="src/imagem/icones/escudo.png" type="image/x-icon">
   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">
   <link href="https://fonts.cdnfonts.com/css/eingrantch-mono" rel="stylesheet"> 
   <link rel="stylesheet" href="src/css/index-estoque.css">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="src/css/style-estoque.css">

</head>

<body>
   <header class="cabecalho">
      <div class="logo">
         <a href="dashboard.html" class="logo"><img src="src/imagem/logos/VanguardLogo - titulo.png"
               alt="Logo da Vanguard" /> </a>
      </div>



      <nav class="menu" id="menu">
         <a href="dashboard.php">Dashboard</a>
         <a href="Usuários.php">Visualizar os usuários</a>
      </nav>

      <?php

      $select_rows = mysqli_query($conn, "SELECT * FROM `carrinho`") or die('query failed');
      $row_count = mysqli_num_rows($select_rows);

      ?>



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
            <input type="text" name="p_nome" placeholder="enter the product name" class="box" required>

            <input type="number" name="p_preco" min="0" placeholder="enter the product price" class="box" required>

            <input type="text" name="p_classe" min="0" placeholder="enter the product price" class="box" required>

            <input type="file" name="p_imagem" accept="image/png, image/jpg, image/jpeg" class="box" required>

            <input type="submit" value="add the product" name="add_product" class="btn">
         </form>

      </section>

      <main class="display-product-table">

         <table class="table table-dark table-hover">

            <thead>
               <th>imagem</th>
               <th>Nome</th>
               <th>preço</th>
               <th>classe</th>
               <th>ação</th>
            </thead>

            <tbody>
               <?php

               $select_produto = mysqli_query($conn, "SELECT * FROM `produtos`");
               if (mysqli_num_rows($select_produto) > 0) {
                  while ($row = mysqli_fetch_assoc($select_produto)) {
                     ?>

                     
                     <tr>
                        <td><img src="src/imagem/produtos/<?php echo $row['imagem']; ?>" height="100" alt=""></td>
                        <td><?php echo $row['nome_produto']; ?></td>
                        <td>$<?php echo $row['preco']; ?>/-</td>
                        <td> <?php echo $row['classe']; ?></td>
                        <td class="option">
                           <a href="estoque.php?delete=<?php echo $row['produto_id']; ?>" class="btn btn-sm btn-danger" id="delete" onclick="return confirm('are your sure you want to delete this?');"> 
                              <i class="fas fa-trash"></i> 
                              delete </a>
                           
                              <a href="estoque.php?edit=<?php echo $row['produto_id']; ?>" class="btn btn-sm btn-primary"> <i
                                 class="fas fa-edit"></i> update </a>
                        </td>
                     </tr>

                     <?php
                  }
                  ;
               } else {
                  echo "<div class='empty'>no product added</div>";
               }
               ;
               ?>
            </tbody>
         </table>

      </main>

      <section class="edit-form-container">

         <?php

         if (isset($_GET['edit'])) {
            $edit_id = $_GET['edit'];
            $edit_query = mysqli_query($conn, "SELECT * FROM `produtos` WHERE produto_id = $edit_id");
            if (mysqli_num_rows($edit_query) > 0) {
               while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
                  ?>

                  <form action="" method="post" enctype="multipart/form-data">
                     <img src="src/imagem/produtos/<?php echo $fetch_edit['imagem']; ?>" height="200" alt="">

                     <input type="hidden" name="update_p_produto_id" value="<?php echo $fetch_edit['produto_id']; ?>">

                     <input type="text" class="box" required name="update_p_nome_produto"
                        value="<?php echo $fetch_edit['nome_produto']; ?>">

                     <input type="number" min="0" class="box" required name="update_p_preco"
                        value="<?php echo $fetch_edit['preco']; ?>">

                     <input type="text" min="0" class="box" required name="update_p_classe"
                        value="<?php echo $fetch_edit['classe']; ?>">

                     <input type="file" class="box" required name="update_p_imagem" accept="image/png, image/jpg, image/jpeg">

                     <input type="submit" value="update the produto" name="update_product" class="btn">

                     <input type="reset" value="cancel" id="close-edit" class="option-btn">
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















   <!-- custom js file link  -->
   <script src="src/js/estoque.js"></script>

</body>

</html>