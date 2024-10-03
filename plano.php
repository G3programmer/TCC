<?php
session_start();
// Inclua a conexão com o banco de dados
include_once('src/php/conexao.php');

// Verifique se o formulário foi enviado
if (isset($_POST['submit'])) {
    $nome_plano = $_POST['nome_plano'];
    $plano_preco = $_POST['preco'];
    $tempo = $_POST['tempo'];
    $produto_id = $_POST['produto_id'];
    
        $result = mysqli_query($conn, "INSERT INTO plano (nome_plano, preco_plano, tempo, produto_id /*precisa listar os produtos*/ ) 
            VALUES ('$nome_plano','$plano_preco','$tempo','$produto_id')");

        if ($result) {
            echo "<script>
            alert('Plano adicionado com sucesso!');
            window.location.href = 'contas.php';
          </script>";
            exit;
        } else {
            // Exibe um pop-up de erro
            echo "<script>alert('Erro ao cadastrar: " . mysqli_error($conn) . "');</script>";
        }
    }



// Carrega a lista de estados
$sql_code_produto = "SELECT * FROM produtos ORDER BY nome_produto ASC";
$sql_query_produto = $conn->query($sql_code_produto) or die($conn->error);
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Vanguard | Planos</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="src/css/rename.css">

</head>
<body>

<header class="cabecalho">
      <div class="logo">
         <a href="dashboard.html" class="logo"><img src="src/imagem/logos/VanguardLogo - titulo.png"
               alt="Logo da Vanguard" /> </a>
      </div>
      <nav id="menu">
            <ul class="menu">
            <li>
                    <a class="btn-servicos" href="dashboard.php">Home</a>
                </li>
                <li>
                    <a href="contas.php" target="_blank">Lista de Usuários</a>
                </li>
                <li>
                    <a href="estoque.php">Lista de Produtos</a>
                </li>                
                <li>
                    <a href="src/php/logout.php">Logout</a>
                </li>
            </ul>
        </nav>
    </header>
    <main class="display-product-table">

    <div class="container">

<section class="home">

   <form action="" method="post" class="add-product-form" enctype="multipart/form-data">
      <h3>Adicionar novo produto</h3>
      <input type="text" name="p_nome" placeholder="Digite o nome do plano" class="box" required>

      <input type="text" name="preco" min="0" placeholder="Digite o preço do plano" class="box" required>

      <input type="text" name="tempo" min="0" placeholder="Digite o tempo desse plano" class="box" required>

      <select name="produto_id" id="estado" required class="box">
                            <option value="">Selecione um estado</option>
                            <?php while ($produto_id = $sql_query_produto->fetch_assoc()) { ?>
                                <option value="<?php echo $produto_id['produto_id']; ?>">
                                    <?php echo $produto_id['nome_produto']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
      <input type="submit" value="Adicionar" name="add_product" class="btn">
   </form>
</section>


<table class="table table-dark table-hover">

   <thead>
      <th>Nome</th>
      <th>preço</th>
      <th>tempo</th>
      <th>produto</th>
      <th>ação</th>
   </thead>

   <tbody>
      <?php

      $select_plano = mysqli_query($conn, "SELECT * FROM `plano`");

      if (mysqli_num_rows($select_plano) > 0) {
         while ($row = mysqli_fetch_assoc($select_plano)) {
            ?>

            
            <tr>
               <td><?php echo $row['nome_plano']; ?></td>
               <td>$<?php echo $row['preco']; ?></td>
               <td> <?php echo $row['tempo']; ?></td>
               <td> <?php echo $row['nome_produto']; ?></td> <!--Vai dar erro aqui-->

               <td class="option">
                  <a href="plano.php?delete=<?php echo $row['plano_id']; ?>" class="btn btn-sm btn-danger" id="delete" onclick="return confirm('are your sure you want to delete this?');"> 
                     <i class="fas fa-trash"></i> 
                     delete </a>
                  
                     <a href="plano.php?edit=<?php echo $row['plano_id']; ?>" class="btn btn-sm btn-primary"> <i
                        class="fas fa-edit"></i> update </a>
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

<?php

if (isset($_GET['edit'])) {
   $edit_id = $_GET['edit'];
   $edit_query = mysqli_query($conn, "SELECT * FROM `plano` WHERE plano_id = $edit_id");
   if (mysqli_num_rows($edit_query) > 0) {
      while ($fetch_edit = mysqli_fetch_assoc($edit_query)) {
         ?>

         <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="update_p_plano_id" value="<?php echo $fetch_edit['plano_id']; ?>">

            <input type="text" class="box" required name="update_nome_plano"
               value="<?php echo $fetch_edit['nome_plano']; ?>">

            <input type="text" min="0" class="box" required name="update_preco"
               value="<?php echo $fetch_edit['preco']; ?>">

            <input type="text" min="0" class="box" required name="update_tempo"
               value="<?php echo $fetch_edit['tempo']; ?>">

               <input type="text" min="0" class="box" required name="update_p_nome_produto"
               value="<?php echo $fetch_edit['nome_produto']; ?>"> <!--outro possível erro-->

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