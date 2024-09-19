<?php
session_start();

@include 'src/php/conexao.php';

if(isset($_POST['update_update_btn'])){
   $update_value = $_POST['update_quantity'];
   $update_id = $_POST['update_quantity_id'];
   $update_quantity_query = mysqli_query($conn, "UPDATE `carrinho` SET quantidade = '$update_value' WHERE produto_id = '$update_id'");
   if($update_quantity_query){
      header('location:carrinho.php');
   };
};

if(isset($_GET['remove'])){
   $remove_id = $_GET['remove'];
   mysqli_query($conn, "DELETE FROM `carrinho` WHERE produto_id = '$remove_id'");
   header('location:carrinho.php');
};

if(isset($_GET['delete_all'])){
   mysqli_query($conn, "DELETE FROM `carrinho`");
   header('location:carrinho.php');
}

?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

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
                    <a class="btn-servicos" href="indexLogadoCliente.html">home</a>
                </li>    
            <li>
                    <a class="btn-servicos" href="servicos.html">Serviços</a>
                </li>
                <li>
                    <a href="produtos.php" target="_blank">Produtos</a>
                </li>
                <li>
                    <a href="src/php/logout.php">Logout</a>
                </li>
                <li>
                    <a href="perfil.php">perfil</a>
                </li>
                <li>
                    <a
                        href="mailto:g3hunterbugs@gmail.com?subject=Mensagem para Vanguard de um cliente&body=Preciso de ajuda">Suporte</a>
                </li>
            </ul>
        </nav>
    </header>
 
      <?php

      $select_rows = mysqli_query($conn, "SELECT * FROM `carrinho`") or die('query failed');
      $row_count = mysqli_num_rows($select_rows);

      ?>

      <a href="carrinho.php" class="cart">cart <span><?php echo $row_count; ?></span> </a>

      <div id="menu-btn" class="fas fa-bars"></div>

      </div>

   </header>
<div class="container">

<section class="shopping-cart">

   <h1 class="heading">shopping cart</h1>

   <table>

      <thead>
         <th>image</th>
         <th>name</th>
         <th>price</th>
         <th>quantity</th>
         <th>total price</th>
         <th>action</th>
      </thead>

      <tbody>

         <?php 
         
         $select_cart = mysqli_query($conn, "SELECT * FROM `carrinho`");
         $grand_total = 0;
         if(mysqli_num_rows($select_cart) > 0){
            while($fetch_cart = mysqli_fetch_assoc($select_cart)){
         ?>

         <tr>
            <td><img src="uploaded_img/<?php echo $fetch_cart['imagem']; ?>" height="100" alt=""></td>
            <td><?php echo $fetch_cart['nome_produto']; ?></td>
            <td>$<?php echo number_format($fetch_cart['preco']); ?>/-</td>
            <td>
               <form action="" method="post">
                  <input type="hidden" name="update_update_btn"  value="<?php echo $fetch_cart['carrinho_id']; ?>">
               </form>   
            </td>
            <td>$<?php echo $sub_total = number_format($fetch_cart['preco'] * $fetch_cart['quantidade']); ?>/-</td>
            <td><a href="carrinho.php?remove=<?php echo $fetch_cart['carrinho_id']; ?>" onclick="return confirm('remove item from cart?')" 
            class="delete-btn"> <i class="fas fa-trash"></i> remove</a></td>
         </tr>
         <?php
           $grand_total += $sub_total;  
            };
         };
         ?>
         <tr class="table-bottom">
            <td><a href="produtos.php" class="option-btn" style="margin-top: 0;">continue shopping</a></td>
            <td colspan="3">grand total</td>
            <td>$<?php echo $grand_total; ?>/-</td>
            <td><a href="carrinho.php?delete_all" onclick="return confirm('are you sure you want to delete all?');" class="delete-btn"> <i class="fas fa-trash"></i> delete all </a></td>
         </tr>

      </tbody>

   </table>

   <div class="checkout-btn">
      <a href="confirmarPagamento.php" class="btn <?= ($grand_total > 1)?'':'disabled'; ?>">procced to checkout</a>
   </div>

</section>

</div>
   
<!-- custom js file link  -->
<script src="src/js/estoque.js"></script>

</body>
</html>