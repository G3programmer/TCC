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
    $delete_query = mysqli_query($conn, "DELETE FROM plano WHERE plano_id = '$delete_id'");

    if ($delete_query) {
        // Redireciona após a exclusão
        header('location:plano.php?msg=Plano excluído com sucesso!');
        exit;
    } else {
        // Mensagem de erro
        header('location:plano.php?msg=Erro ao excluir o plano: ' . mysqli_error($conn));
        exit;
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
    $result = mysqli_query($conn, "INSERT INTO plano (nome_plano, preco_plano, tempo, descricao) 
        VALUES ('$nome_plano', '$preco_plano', '$tempo', '$descricao')");

    if ($result) {
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
               <th>Ação</th>
            </thead>
            <tbody>
               <?php $select_plano = mysqli_query($conn, "SELECT * FROM plano");

              if (mysqli_num_rows($select_plano) > 0) {
                  while ($row = mysqli_fetch_assoc($select_plano)) {
                      if ($row['tempo'] == -1) {
                          $tempo_restante = "Para Sempre"; // Define o tempo como "Para Sempre"
                      } else {
                          if (isset($row['data_final']) && !empty($row['data_final'])) { // Verifica se 'data_final' existe e não está vazio
                              $currentDate = new DateTime(); // Data atual
                              $dataFinal = new DateTime($row['data_final']); // Data final do plano
                              $interval = $currentDate->diff($dataFinal);
                              $tempo_restante = $currentDate < $dataFinal ? $interval->format('%m meses, %d dias') : 'Expirado';
                          } else {
                              $tempo_restante = "Data final não definida"; // Caso 'data_final' esteja indefinida ou nula
                          }
                      }
                      // Código para exibir o plano e o tempo restante
                   
              ?>
                     <tr>
                        <td><?php echo $row['nome_plano']; ?></td>
                        <td>$<?php echo $row['preco_plano']; ?></td>
                        <td><?php echo $row['tempo'] == -1 ? 'Para Sempre' : $row['tempo']; ?> meses</td>
                        <td><?php echo $tempo_restante; ?></td>
                        <td class="option">
                           <a href="plano.php?delete=<?php echo $row['plano_id']; ?>" class="btn btn-sm btn-danger"
                              id="delete" onclick="return confirm('Tem certeza de que deseja excluir isso?');">
                              <i class="fas fa-trash"></i> Excluir
                           </a>
                           <a href="plano.php?edit=<?php echo $row['plano_id']; ?>" class="btn btn-sm btn-primary">
                              <i class="fas fa-edit"></i> Atualizar
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
   </main>

   <footer class="roda-pe">

      <img src="src/imagem/logos/VanguardLogo-Escuro.png" alt="logo da Vanguard" class="logo">



      <h5 class="subtitulo">
         Nos acompanhe pelas redes sociais
      </h5>


      <div class="social_media">

         <a href="facebook link" id="facebook" title="Facebook" target="_blank"><img
               src="src/imagem/icones/Facebook.png" alt="botão do perfil do facebook da Vanguard"></a>

         <a href="https://www.instagram.com/vanguard_security.oficial/" id="instagram" title="Instagram"
            target="_blank"><img src="src/imagem/icones/instagram.png"
               alt="botão do perfil do instagram da Vanguard"></a>

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
   <script src="src/js/script.js"></script>

</body>

</html>