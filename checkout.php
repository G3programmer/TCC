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

// Buscar o nome do usuário no banco de dados
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

// Obter o ID do plano (via GET ou POST)
if (isset($_GET['plano_id'])) {
    $planoId = $_GET['plano_id'];
} elseif (isset($_POST['plano_id'])) {
    $planoId = $_POST['plano_id'];
} else {
    echo "ID do plano não definido.";
    exit;
}

// Se o ID do plano estiver definido, busca os detalhes do plano
$planoSelecionado = null;
if (isset($planoId)) {
    // Consulta para buscar os detalhes do plano
    $query = "SELECT * FROM plano WHERE plano_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $planoId);
        $stmt->execute();
        $resulto = $stmt->get_result();

        if ($resulto->num_rows > 0) {
            $planoSelecionado = $resulto->fetch_assoc(); // Armazena o plano selecionado
        } else {
            echo 'Plano não encontrado.';
        }

        $stmt->close(); // Fecha a declaração
    } else {
        echo 'Erro na preparação da consulta.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $metodo = $_POST['metodo'];
    $senha = $_POST['senha']; // Troca de "pin" para "senha"
    $cpf = $_POST['cpf']; // Atualizando para pegar o CPF

    // Valida CPF
    if (empty($cpf)) {
        echo "CPF inválido.";
        exit;
    }

    // Busca o usuário pelo CPF
    $sql_user = "SELECT usuario_id FROM usuario WHERE cpf = ? LIMIT 1";
    $stmt_user = $conn->prepare($sql_user);
    $stmt_user->bind_param("s", $cpf);
    $stmt_user->execute();
    $result_user = $stmt_user->get_result();

    if ($result_user->num_rows > 0) {
        $usuario = $result_user->fetch_assoc();
        $usuarioId = $usuario['usuario_id'];

        

        // Insere o checkout na tabela checkout
        $sqlInsertCheckout = "INSERT INTO checkout (usuario_id, plano_id, metodo, senha, data_inicio) VALUES (?, ?, ?, ?, CURDATE())";
$stmtInsert = $conn->prepare($sqlInsertCheckout);
$stmtInsert->bind_param("iiss", $usuarioId, $planoId, $metodo, $senha);


        if ($stmtInsert->execute()) {
            // Atualiza o plano_id na tabela usuário
            $sqlUpdatePlano = "UPDATE usuario SET plano_id = ? WHERE usuario_id = ?";
            $stmtUpdatePlano = $conn->prepare($sqlUpdatePlano);
            $stmtUpdatePlano->bind_param("ii", $planoId, $usuarioId);

            if ($stmtUpdatePlano->execute()) {
                // Redireciona para o perfil após atualizar o plano
                header("Location: perfil.php");
                exit;
            } else {
                echo "Erro ao atualizar o plano do usuário.";
            }

            $stmtUpdatePlano->close(); // Fecha a declaração de atualização
        } else {
            echo "Erro ao inserir dados de checkout: " . $stmtInsert->error;
        }

        $stmtInsert->close(); // Fecha a declaração do insert
    } else {
        echo "Usuário não encontrado com o CPF informado.";
    }

    $stmt_user->close(); // Fecha a declaração de busca do usuário
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
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
               <a href="indexLogadoCliente.html">Home</a>
            </li>
            <li>
               <a class="btn-avaliar" href="formulario.php" target="_blank">Avaliar</a>
            </li>
            <li>
               <a class="btn-servicos" href="equipe.html" target="_blank">Serviços</a>
            </li>
            <li>
               <a href="produtos.php" target="_blank">Produtos</a>
            </li>
            <li>
               <a href="perfil.php">Perfil</a>
            </li>
            <li>
               <a class="btn-login" href="src/php/logout.php">Logout</a>
            </li>
         </ul>
      </nav>
   </header>

   <main class="home">
      <div class="containermeu">
         <section class="checkout-form">
            <h1 class="heading">Confirmação de pagamento</h1>
            <form action="" method="post">
               <div class="display-order">
                  <br>
                  <?php
                  if ($planoSelecionado) {
                     echo ' <div class="container text-center">';
                     echo '<div class="row">';
                     echo '<div class="info">';
                     echo '<p class="col-2"> Nome do Plano: <br>' . $planoSelecionado['nome_plano'] . '</p><br>';
                     echo '<p class="col-2"> Preço: <br> R$ ' . number_format($planoSelecionado['preco_plano'], 2, ',', '.') . '</p> <br>';

                     echo '<p class="col-2"> tempo de duração em mês: <br>  ' . number_format($planoSelecionado['tempo']) . '</p> <br>';

                     echo '<p class="col-5"> Descrição: <br>' . $planoSelecionado['descricao'] . '</p>';
                     echo '</div>';
                     echo '</div>';
                     echo '</div>';
                  } else {
                     echo "Por favor, selecione um plano.";
                  }
                  ?>
                  <hr>
                  <h3>Insira os dados do pagamento</h3>
                  <div class="container">
                     <form action="" method="POST">
                        <div class="row">
                           <input type="hidden" name="plano_id"
                              value="<?php echo isset($planoSelecionado) ? $planoSelecionado['plano_id'] : ''; ?>">

                           <!-- Primeira coluna -->
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="nome">Nome</label>
                                 <input type="text" class="form-control" placeholder="Digite o seu nome" name="nome"
                                    required>
                              </div>
                           </div>

                           <!-- Segunda coluna -->
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="metodo">Método de pagamento</label>
                                 <select name="metodo" class="form-control">
                                    <option value="PayPal">PayPal</option>
                                    <option value="PIX">PIX</option>
                                    <option value="Cartão de Crédito">Cartão de Crédito</option>
                                 </select>
                              </div>
                           </div>
                        </div>

                        <div class="row">
                           <!-- Primeira coluna -->
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="cpf">CPF</label>
                                 <input class="form-control" type="text" name="cpf" required
                                    placeholder="Insira seu CPF">
                              </div>
                           </div>

                           <!-- Segunda coluna -->
                           <div class="col-md-6">
                              <div class="form-group">
                                 <label for="senha">Senha</label>
                                 <input class="form-control" type="password" name="senha" required
                                    placeholder="Insira sua senha">
                              </div>
                           </div>
                        </div>

                        <br>
                        <button type="submit" class="btn btn-primary">Finalizar checkout</button>
                     </form>
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

            <a href="avaliar.html">
               <h6>Avaliar</h6>
            </a>
            <hr />
            <a href="serviços.html">
               <h6>Nossos serviços</h6>
            </a>
            <hr />
            <a href="cronograma.html">

               <h6>
                  Nosso cronograma
               </h6>
            </a>
         </div>
      </div>
      </div>
      <p id="copyright">
         Direitos Autorais Reservados à Vanguard&#8482;
      </p>
   </footer>
</body>

</html>