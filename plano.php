<?php
include('src/php/conexao.php');
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
      if (basename($_SERVER['PHP_SELF']) !== 'plano.php') { // Evita redirecionamento em loop
         header('Location: plano.php');
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

// Verifica se uma requisição de exclusão foi feita
if (isset($_GET['delete'])) {
   $delete_id = mysqli_real_escape_string($conn, $_GET['delete']);

   // Verifica se existem produtos associados ao plano usando prepared statement
   $stmt = $conn->prepare("SELECT * FROM produto_plano WHERE plano_id = ?");
   $stmt->bind_param("i", $delete_id);
   $stmt->execute();
   $result = $stmt->get_result();

   if ($result->num_rows > 0) {
      // Grava no log e redireciona com mensagem
      error_log("Tentativa de excluir o plano $delete_id que possui produtos associados.");
      header('Location: plano.php?msg=Não é possível excluir o plano. Existem produtos associados a ele.');
      exit;
   } else {
      // Se não houver produtos associados, pode excluir o plano
      $delete_stmt = $conn->prepare("DELETE FROM plano WHERE plano_id = ?");
      $delete_stmt->bind_param("i", $delete_id);

      if ($delete_stmt->execute()) {
         header('Location: plano.php?msg=Plano excluído com sucesso!');
         exit;
      } else {
         header('Location: plano.php?msg=Erro ao excluir o plano: ' . $conn->error);
         exit;
      }
   }
}



// Verifique se o formulário foi enviado para adicionar um novo plano
if (isset($_POST['submit'])) {
   $nome_plano = $_POST['nome_plano'];
   $preco_plano = $_POST['preco_plano'];
   $tempo = $_POST['tempo'];
   $data_final = date('Y-m-d', strtotime("+$tempo months"));
   $descricao = $_POST['descricao'];

   // Prepare a consulta para inserir
   $resulte = mysqli_query($conn, "INSERT INTO plano (nome_plano, preco_plano, tempo, descricao) 
        VALUES ('$nome_plano', '$preco_plano', '$tempo', '$descricao')");

   if ($resulte) {
      // Redireciona após a inserção
      header('location:plano.php?msg=Plano adicionado com sucesso!');
      exit;
   } else {
      // Mensagem de erro
      header('location:plano.php?msg=Erro ao adicionar o plano: ' . mysqli_error($conn));
      exit;
   }
}

// Verifique se o formulário foi enviado para atualizar um plano
if (isset($_POST['update_plano'])) {
   $update_p_plano_id = $_POST['update_p_plano_id'];
   $update_p_nome_plano = $_POST['update_p_nome_plano'];
   $update_p_preco = $_POST['update_p_preco'];
   $update_p_tempo = $_POST['update_p_tempo'];
   $update_p_descricao = $_POST['update_p_descricao'];

   $update_query = mysqli_query($conn, "UPDATE plano SET nome_plano = '$update_p_nome_plano', preco_plano = '$update_p_preco', tempo = '$update_p_tempo', descricao = '$update_p_descricao' WHERE plano_id = '$update_p_plano_id'");

   if ($update_query) {
      // Redireciona após a atualização
      header('location:plano.php?msg=Plano atualizado com sucesso!');
      exit;
   } else {
      // Mensagem de erro
      header('location:plano.php?msg=Erro ao atualizar o plano: ' . mysqli_error($conn));
      exit;
   }
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Vanguard | Planos</title>
   <!-- Font Awesome CDN link -->
   <link rel="shortcut icon" href="src/imagem/icones/escudo.png" type="image/x-icon">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
   <link href="https://fonts.cdnfonts.com/css/eingrantch-mono" rel="stylesheet">
   <link rel="stylesheet" href="src/css/index-plano.css">
   <link rel="stylesheet" href="src/css/style-plano.css">
</head>

<body>

   <header class="cabecalho">
      <div class="logo">
         <a href="dashboard.php" class="logo"><img src="src/imagem/logos/VanguardLogo - titulo.png"
               alt="Logo da Vanguard" /></a>
      </div>
      <nav id="menu">
         <ul class="menu">
            <li><a class="btn-servicos" href="dashboard.php">Home</a></li>
            <li><a href="contas.php" target="_blank">Lista de Usuários</a></li>
            <li><a href="estoque.php">Lista de Produtos</a></li>
            <li><a href="src/php/logout.php">Logout</a></li>
         </ul>
      </nav>
   </header>

      <?php if (isset($_GET['msg'])): ?>
         <div class="alert alert-warning" style="font-size:20px; color:black;"></div>
         <?php echo htmlspecialchars($_GET['msg']); ?>
      <?php endif; ?>

   <main class="display-product-table">
      <div class="container">
         <section class="home">
            <form method="post" class="add-product-form" enctype="multipart/form-data">
               <h3>Adicionar novo plano</h3>
               <input type="text" name="nome_plano" placeholder="Digite o nome do plano" class="box" required>
               <input type="text" name="preco_plano" min="0" placeholder="Digite o preço do plano" class="box" required>
               <input type="number" name="tempo" placeholder="Duração do plano em meses" class="box" required>
               <span> Se for vitalício, adicione -1</span>
               <input type="text" name="descricao" placeholder="Adicione uma descrição para o plano" class="box"
                  required>
               <input type="submit" value="Adicionar" name="submit" class="btn">
            </form>
         </section>


         <table class="table table-dark table-hover">

            <thead>
               <th>Nome</th>
               <th>Preço</th>
               <th>Tempo (em meses)</th>
               <th>Duração</th>
               <th>Descrição</th>
               <th>Ação</th>
            </thead>
            <tbody>
               <?php
               $select_plano = mysqli_query($conn, "SELECT * FROM plano");
               if (mysqli_num_rows($select_plano) > 0) {
                  while ($row = mysqli_fetch_assoc($select_plano)) {
                     if ($row['tempo'] == -1) {
                        $tempo_restante = "Para Sempre"; // Define o tempo como "Para Sempre"
                        $month = $dia = "N/A"; // Para planos vitalícios, não há mês e dia
                     } else {
                        // Calcular a data final com base no tempo
                        $data_final = date('Y-m-d', strtotime("+{$row['tempo']} months"));
                        $data_atual = new DateTime();
                        $data_final_obj = new DateTime($data_final);

                        // Calcular a diferença
                        $diferenca = $data_atual->diff($data_final_obj);
                        $month = $diferenca->m; // Obtém a diferença em meses
                        $dia = $diferenca->d; // Obtém a diferença em dias
               
                        $tempo_restante = ($data_atual < $data_final_obj) ? "Até {$month} mês(es) e {$dia} dia(s)" : 'Expirado';
                     }
                     ?>
                     <tr>
                        <td><?php echo $row['nome_plano']; ?></td>
                        <td>$<?php echo $row['preco_plano']; ?></td>
                        <td><?php echo $row['tempo'] == -1 ? 'Para Sempre' : $row['tempo']; ?></td>
                        <td><?php echo $tempo_restante; ?></td>
                        <td><?php echo $row['descricao'] ?></td>
                        <td class="option">
                           <a href="plano.php?delete=<?php echo $row['plano_id']; ?>" class="btn btn-sm btn-danger"
                              id="delete" onclick="return confirm('Are you sure you want to delete this?');">
                              <i class="fas fa-trash"></i> Delete
                           </a>
                           <a href="plano.php?edit=<?php echo $row['plano_id']; ?>" class="btn btn-sm btn-primary">
                              <i class="fas fa-edit"></i> Update
                           </a>
                        </td>
                     </tr>
                     <?php
                  }
               } else {
                  echo "<tr><td colspan='5' class='empty'>Nenhum produto adicionado</td></tr>";
               }


               ?>
            </tbody>

         </table>
      </div>


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

                  <!-- Campo para editar o nome do plano -->
                  <span>Nome do plano</span>
                  <input type="text" class="box" required name="update_p_nome_plano"
                     value="<?php echo $fetch_edit['nome_plano']; ?>">

                  <!-- Campo para editar o tempo do plano -->
                  <span>tempo do plano</span>
                  <input type="text" class="box" required name="update_p_tempo" value="<?php echo $fetch_edit['tempo']; ?>">

                  <!-- Campo para editar o preço do plano -->
                  <span>preço do plano</span>
                  <input type="text" class="box" required name="update_p_preco"
                     value="<?php echo $fetch_edit['preco_plano']; ?>">

                  <!-- Campo para editar a descrição do plano -->
                  <span>descrição</span>
                  <input type="text" class="box" required name="update_p_descricao"
                     value="<?php echo $fetch_edit['descricao']; ?>">

                  <!-- Botão de submissão para atualizar o plano -->
                  <input type="submit" value="Atualizar plano" name="update_plano" class="btn">

                  <!-- Botão para cancelar a edição -->
                  <input id="close-edit" type="reset" value="Cancelar" class="option-btn">
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
   </main>

   <footer class="roda-pe">
<img src="src/imagem/logos/VanguardLogo-Escuro.png" alt="logo da Vanguard" class="logo">

<h5 class="subtitulo">
    Nos acompanhe pelas redes sociais
</h5>


<div class="social_media">

    <a href="facebook link" id="facebook" title="Facebook" target="_blank"><img
            src="src/imagem/icones/Facebook.png" alt="botão do perfil do facebook da Vanguard"></a>

    <a href="instagram link" id="instagram" title="Instagram" target="_blank"><img
            src="src/imagem/icones/instagram.png" alt="botão do perfil do instagram da Vanguard"></a>

    <a href="discord" title="discord" id="discord" target="_blank"><img src="src/imagem/icones/discord.png"
            alt="botão do chat do discord da Vanguard "></a>

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

        <a href="produtos.html">
            <h6>
                Nossos produtos
            </h6>
        </a>
        <hr />
        
        <a href="malito:g3hunterbugs@gmail.com?subject=Mensagem para Vanguard de um cliente&body=Preciso de ajuda">
            <h6>
                Suporte
            </h6>
        </a>
    </div>
</div>
<p id="copyright">
    Direitos Autorais Reservados à Vanguard&#8482;
</p>
</footer>
</body>
</html>
<script src="src/js/plano.js"></script>
