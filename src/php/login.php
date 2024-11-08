<?php
session_start();
print_r($_REQUEST);

if (isset($_POST['submit']) && !empty($_POST['email']) && !empty($_POST['senha'])) {
    // Acessa
    include_once('conexao.php');
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Log da tentativa de login
    $logMessage = "Tentativa de login: Email: $email, Senha: $senha\n";
    file_put_contents('login_attempts.log', $logMessage, FILE_APPEND);

    $sql = "SELECT * FROM usuario WHERE email = '$email' AND senha = '$senha'";
    $result = $conn->query($sql);

    if (mysqli_num_rows($result) < 1) {
        unset($_SESSION['email']);
        unset($_SESSION['senha']);
        
        // Alerta de erro
        echo "<script>
                alert('Email ou senha inválidos.');
                window.location.href = '../../login.html'; // Redireciona após o alerta
              </script>";
        exit();
    } else {
        $_SESSION['email'] = $email;
        $_SESSION['senha'] = $senha;
        
        // Verifica se é admin
        $verifica = "SELECT is_admin FROM usuario WHERE email = '$email' AND senha = '$senha'";
        $test = $conn->query($verifica);

        if ($test) {
            $row = $test->fetch_assoc();
            
            if ($row['is_admin'] == 1) {
                header('Location: ../../dashboard.php'); // Usuário admin
            } else {
                header('Location: ../../perfil.php'); // Usuário comum
            }
        } else {
            // Caso de erro na consulta SQL
            echo "<script>
                    alert('Erro na consulta.');
                    window.location.href = '../../login.html'; // Redireciona após o alerta
                  </script>";
            exit();
        }
    }
} else {
    // Não acessa
    echo "<script>
            alert('Por favor, preencha todos os campos.');
            window.location.href = '../../login.html'; // Redireciona após o alerta
          </script>";
    exit();
}
?>
