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

$logado = $_SESSION['email'];

// Buscar o nome do usuário do banco de dados
$sql = "SELECT * FROM usuario WHERE email = '$logado' LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
   $row = $result->fetch_assoc();
   $user_Id = $row['usuario_id']; // ID do usuário
   $nomeUsuario = $row['nome'];
   $fotoUsuario = $row['foto']; // Caminho ou nome da imagem
} else {
   $nomeUsuario = 'Usuário';
   $fotoUsuario = 'default.png'; // Imagem padrão se a foto não for encontrada
}

$sql_code_plan = "SELECT * FROM plano ORDER BY nome_plano ASC";
$sql_plan_query = $conn->query($sql_code_plan) or die($conn->error);

$planoSelecionado = null; // Variável para armazenar o plano selecionado
if (isset($_POST['p_plano'])) {
   $planoId = $_POST['p_plano'];

   // Consulta para buscar os detalhes do plano
   $query = "SELECT plano_id, nome_plano, preco_plano, descricao FROM plano WHERE plano_id = ?";
   $stmt = $conn->prepare($query);

   if ($stmt) {
      $stmt->bind_param("i", $planoId);
      $stmt->execute();
      $result = $stmt->get_result();

      if ($result->num_rows > 0) {
         $planoSelecionado = $result->fetch_assoc(); // Armazena o plano selecionado
      } else {
         echo 'Plano não encontrado.';
      }

      $stmt->close(); // Fecha a declaração
   } else {
      echo 'Erro na preparação da consulta.';
   }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Vanguard | Segurança eletrônica e testes de segurança</title>
   <link rel="shortcut icon" href="src/imagem/icones/escudo.png" type="image/x-icon">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="src/css/index.css">
   <link rel="stylesheet" href="src/css/style-checkout.css">
   <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">
</head>

<body>

   <header class="cabecalho">
      <div class="logo">
         <img src="src/imagem/logos/VanguardLogo - titulo.png" alt="Logo da Vanguard" />
      </div>

      <button id="OpenMenu">&#9776;</button>

      <nav id="menu">
         <button id="CloseMenu">X</button>
         <ul class="menu">
            <li>
               <a class="btn-quem-somos" href="#quem-somos" onclick="scrollToSection('quem-somos')">Quem somos</a>

            </li>
            <li>
               <a class="btn-parcerias" href="#parcerias">Parcerias</a>
            </li>
            <li>
               <a class="btn-avaliar" href="formulario.php" target="_blank">Avaliar</a>
            </li>
            <li>
               <a class="btn-servicos" href="formulario.php" target="_blank">Serviços</a>
            </li>
            <li>
               <a href="formulario.php" target="_blank">Produtos</a>
            </li>
            <li>
               <a href="formulario.php"> Cadastrar</a>
            </li>
            <li>
               <a class="btn-login" href="login.html">Login</a>
            </li>
         </ul>
      </nav>
   </header>
   <main class="home">
      <div class="container">
         <section class="checkout-form">
            <h1 class="heading">Complete Your Order</h1>

            <form action="" method="post">
               <div class="display-order">
                  <select name="p_plano" class="box" required>
                     <option value="">Selecione um plano</option>
                     <?php while ($p_plano = $sql_plan_query->fetch_assoc()) { ?>
                        <option value="<?php echo $p_plano['plano_id']; ?>">
                           <?php echo $p_plano['nome_plano']; ?>
                        </option>
                     <?php } ?>
                  </select>

                  <input type="submit" value="Buscar pelo plano" class="btn"> <!-- Botão para buscar informações -->
                  <?php
                  if ($planoSelecionado) {
                     echo 'Nome do Plano: ' . $planoSelecionado['nome_plano'] . '<br>';
                     echo 'Preço: R$ ' . number_format($planoSelecionado['preco_plano'], 2, ',', '.') . '<br>';
                     echo 'Descrição: ' . $planoSelecionado['descricao'] . '<br>';
                  } else {
                     echo 'Nenhum plano selecionado.';
                  }
                  ?>
               </div>
            </form>
         </section>
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
</body>
<script src="src/js/checkout.js"></script>

</html>