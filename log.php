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
      if (basename($_SERVER['PHP_SELF']) !== 'log.php') { // Evita redirecionamento em loop
         header('Location: log.php');
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

// Consulta para buscar os checkouts
$sql_checkout = "
    SELECT u.usuario_id, u.nome AS usuario_nome, p.nome_plano AS plano, c.data_inicio, c.metodo AS metodo, u.senha 
    FROM checkout c 
    JOIN usuario u ON c.usuario_id = u.usuario_id 
    JOIN plano p ON c.plano_id = p.plano_id";
$result_checkout = $conn->query($sql_checkout);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="src/css/index-contas.css">
   <link rel="stylesheet" href="src/css/style-contas.css">
   <link rel="stylesheet" href="src/css/responsivo-contas.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
      crossorigin="anonymous">
   <title>Vanguard | Lista de usuários</title>
   <link rel="shortcut icon" href="src/imagem/icones/escudo.png" type="image/x-icon">
</head>

<body>
   <header class="cabecalho">
         <a class="logo" href="dashboard.php">
         <img src="src/imagem/logos/VanguardLogo - titulo.png" alt="Logo da Vanguard"/>
         </a>

      <button id="OpenMenu">&#9776;</button>

      <nav id="menu">
         <button id="CloseMenu">X</button>
         <ul class="menu">
            <li><a href="dashboard.php">Home</a></li>
            <li><a href="estoque.php">Visualizar os produtos</a></li>
            <li><a href="plano.php">Visualizar os Planos</a></li>
            <li><a href="src/php/logout.php">Logout</a></li>
         </ul>
      </nav>
   </header>

   <main class="home display-product-table">
      <div class="container">
         <div class="area">
                <table class="table table-dark table-hover">
                    <h4 class="titulo">Checkouts</h4>
         <thead>
            <tr>
               <th scope="col">ID do Usuário</th>
               <th scope="col">Nome</th>
               <th scope="col">Plano</th>
               <th scope="col">Data de Início</th>
               <th scope="col">Método de Pagamento</th>
               <th scope="col">Senha</th>
            </tr>
         </thead>
         <tbody>
            <?php
            if ($result_checkout->num_rows > 0) {
               while ($row = $result_checkout->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . htmlspecialchars($row['usuario_id']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['usuario_nome']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['plano']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['data_inicio']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['metodo']) . "</td>";
                  echo "<td>" . htmlspecialchars($row['senha']) . "</td>";
                  echo "</tr>";
               }
            } else {
               echo "<tr><td colspan='6'>Nenhum checkout encontrado.</td></tr>";
            }
            ?>
         </tbody>

      </table>
      </div>
   </main>
</body>

</html>