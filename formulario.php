<?php
// Inclua a conexão com o banco de dados
include_once('src/php/conexao.php');

// Verifique se o formulário foi enviado
if (isset($_POST['submit'])) {
    $nome = $_POST['nome'];
    $dt_nasc = $_POST['dt_nasc'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];
    $estado = $_POST['estado'];
    $cidade = $_POST['cidade'];

    // Verifique se um arquivo foi enviado
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        // Obtenha os detalhes do arquivo
        $fileTmpPath = $_FILES['foto']['tmp_name'];
        $fileNome = $_FILES['foto']['name'];
        $foto_folder = 'src/imagem/pessoas/' . $fileNome; // Caminho da pasta onde a foto será salva

        // Tente mover o arquivo para a pasta correta
        if (move_uploaded_file($fileTmpPath, $foto_folder)) {
            // Insira os dados no banco de dados
            $result = mysqli_query($conn, "INSERT INTO usuario (nome, dt_nasc, email, senha, cpf, estado_id, cidade_id, foto) 
                VALUES ('$nome', '$dt_nasc', '$email', '$senha', '$cpf', '$estado', '$cidade', '$fileNome')");

            if ($result) {
                echo "<script>
                alert('Cadastro realizado com sucesso!');
                window.location.href = 'contas.php';
                </script>";
                exit;
            } else {
                echo "<script>alert('Erro ao cadastrar: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Erro ao mover a imagem para a pasta.');</script>";
        }
    } else {
        echo "<script>alert('Erro ao carregar a imagem.');</script>";
    }
}

// Carrega a lista de estados
$sql_code_states = "SELECT * FROM estado ORDER BY nome_estado ASC";
$sql_query_states = $conn->query($sql_code_states) or die($conn->error);

// Carrega a lista de cidades
$sql_code_cities = "SELECT * FROM cidades ORDER BY nome_cidade ASC";
$sql_query_cities = $conn->query($sql_code_cities) or die($conn->error);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/index.css">
    <link rel="stylesheet" href="src/css/style-cadastro.css">
    <link rel="stylesheet" href="src/css/responsivo-cadastro.css">
    <link href="https://fonts.cdnfonts.com/css/eingrantch-mono" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/milestone-one" rel="stylesheet">
    <title>Vanguard | Cadastro</title>
    <link rel="shortcut icon" href="src/imagem/icones/escudo.png" type="image/x-icon">
</head>

<body>
    <header class="cabecalho">
        <a href="index.html"><img class="logo" src="src/imagem/logos/VanguardLogo - titulo.png"
                alt="titulo da Vanguard"></a>

        <nav id="menu">
            <button id="CloseMenu">X</button>
            <ul class="menu">
                <li>
                    <a class="btn-quem-somos" href="index.html">Home</a>

                </li>
            </ul>
        </nav>
    </header>

    <main class="home">
        <img class="imagem-fundo" src="src/imagem/Fundo/soldado-cadastro.png" alt="">

        <div class="box">
            <span class="borderLine"></span>

            <form class="formulario" method="post" enctype="multipart/form-data">
                <h1 class="titulo">Cadastre-se</h1>

                <div class="form-step form-step-active">
                    <div class="inputBox">
                        <input type="text" name="nome" id="nome" required="required">
                        <span>Nome</span>
                        <i></i>
                    </div>

                    <div class="inputBoxData">
                        <input type="date" name="dt_nasc" id="dt_nasc" required="required">
                        <span>Data de Nascimento</span>
                        <i></i>
                    </div>

                    <div class="inputBox">
                        <input type="text" name="email" id="email" required="required">
                        <span>Email</span>
                        <i></i>
                    </div>
                    <br>
                    <div class="inputBox">
                        <input type="text" name="senha" id="senha" required="required">
                        <span>Senha</span>
                        <i></i>
                    </div>

                    <div class="btns">
                        <button class="login-btn">
                            <a href="login.html">Login</a>
                        </button>
                        
                        <button type="button" class="next-btn">
                            Próximo
                        </button>
                      
                    </div>
                </div>

                <div class="form-step">
                    <div class="inputBox">
                        <input type="number" name="cpf" id="cpf" required="required">
                        <span>CPF</span>
                        <i></i>
                    </div>

                    
                    <div class="inputBox">
                        <select name="estado" class="estado" id="estado" required>
                            <option value="">Selecione um estado</option>
                            <?php while ($estado = $sql_query_states->fetch_assoc()) { ?>
                                <option value="<?php echo $estado['estado_id']; ?>">
                                    <?php echo $estado['nome_estado']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="inputBox">
                        <select name="cidade" class="cidade" id="cidade" required>
                            <option value="">Selecione uma Cidade</option>
                            <?php while ($cidade = $sql_query_cities->fetch_assoc()) { ?>
                                <option value="<?php echo $cidade['cidade_id']; ?>">
                                    <?php echo $cidade['nome_cidade']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="inputBoxFile">
                        <input type="file" name="foto" required>
                        <span>Foto de perfil</span>
                        <i></i>
                    </div>

                    <input class="cadastrar" type="submit" name="submit" id="submit" value="Cadastrar">

                    <div class="btns">
                    <button class="login-btn">
                            <a href="login.html">Login</a>
                        </button>    
                    <button type="button" class="prev-btn">Anterior</button>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <footer class="roda-pe">
        <img src="src/imagem/logos/VanguardLogo-Escuro.png" alt="logo da Vanguard" class="logo">
        <h5 class="subtitulo">Nos acompanhe pelas redes sociais</h5>
        <div class="social_media">
            <a href="facebook link" id="facebook" title="Facebook" target="_blank">
                <img src="src/imagem/icones/Facebook.png" alt="botão do perfil do facebook da Vanguard">
            </a>
            <a href="" id="instagram" title="Instagram" target="_blank">
                <img src="src/imagem/icones/instagram.png" alt="botão do perfil do instagram da Vanguard">
            </a>
            <a href="discord" title="discord" id="discord" target="_blank">
                <img src="src/imagem/icones/discord.png" alt="botão do chat do discord da Vanguard">
            </a>
            <a href="linkedin" title="linkedin" id="linkedin" target="_blank">
                <img src="src/imagem/icones/linkedin.png" alt="botão do perfil do linkedin da Vanguard">
            </a>
            <a href="telegram" title="telegram" id="telegram" target="_blank">
                <img src="src/imagem/icones/telegram.png" alt="botão do chat do telegram da Vanguard">
            </a>
        </div>
        <div class="opcoes">
            <div class="lista">
                <a href="equipe.html">
                    <h6>A equipe</h6>
                </a>
                <hr />
                <a href="produtos.html">
                    <h6>Nossos produtos</h6>
                </a>
                <hr />
                <a href="serviços.html">
                    <h6>Nossos serviços</h6>
                </a>
                <hr />
                <a href="cronograma.html">
                    <h6>Nosso cronograma</h6>
                </a>
            </div>
        </div>
        <p id="copyright">Direitos Autorais Reservados à Vanguard&#8482;</p>
    </footer>

    <script src="src/js/selectFormulario.js"></script>
    <script src="src/js/formulario.js"></script>
    <script src="src/js/cadastro-imagem.js"></script>
</body>

</html>