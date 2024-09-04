<!--Fazer outro layou nesse -->

<?php
// Inclua a conexão com o banco de dados
include_once('src/php/conexao.php');


if (!empty($_GET['id'])) {

        $id = $_GET['id'];
        $sqlSelect = "SELECT * FROM usuario WHERE id = $id";
        $result = $conn->query($sqlSelect);
        if ($result->num_rows > 0) {
                while ($user_data = mysqli_fetch_assoc($result)) {
                        $nome = $user_data['nome'];
                        $dt_nasc = $user_data['dt_nasc'];
                        $email = $user_data['email'];
                        $senha = $user_data['senha'];
                        $cpf = $user_data['cpf'];
                        $estado = $user_data['estado'];
                        $cidade = $user_data['cidade'];
                        $foto = $user_data['foto'];

                        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
                                // Obtenha os detalhes do arquivo
                                $fileTmpPath = $_FILES['foto']['tmp_name'];
                                $fileNome = $_FILES['foto']['name'];
                                $fileSize = $_FILES['foto']['size'];
                                $fileType = $_FILES['foto']['type'];
                                $foto = addslashes(file_get_contents($fileTmpPath));
                        }
                }
        } else {
                header('Location: contas.php');
        }
} else {
        header('Location: contas.php');
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
        <link rel="stylesheet" href="src/css/style-editPerfil.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
                crossorigin="anonymous">

        <link rel="stylesheet" href="src/css/responsivo-cadastro.css">
        <link href="https://fonts.cdnfonts.com/css/eingrantch-mono" rel="stylesheet">
        <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">
        <link href="https://fonts.cdnfonts.com/css/milestone-one" rel="stylesheet">
        <title>Vanguard | Editar perfil</title>
        <link rel="shortcut icon" href="src/imagem/icones/escudo.png" type="image/x-icon">
</head>

<body>
        <header class="cabecalho">
                <a href="index.html"><img class="logo" src="src/imagem/logos/VanguardLogo - titulo.png"
                                alt="titulo da Vanguard"></a>
        </header>

        <main class="home">
                <div class="area">
                        <form class="row g-3">
                                <div class="col-md-6">
                                        <label for="inputEmail4" class="form-label">Nome</label>
                                        <input type="email" class="form-control" id="inputEmail4" value=<?php echo $nome;?>>
                                </div>
                                <div class="col-md-6">
                                        <label for="inputPassword4" class="form-label">Email</label>
                                        <input type="text" class="form-control" id="inputPassword4"  value=<?php echo $email;?>>
                                </div>
                                <div class="col-3">
                                        <label for="inputAddress" class="form-label">Senha</label>
                                        <input type="text" class="form-control" id="inputAddress"
                                        value=<?php echo $senha;?>>
                                </div>
                                <div class="col-3">
                                        <label for="inputAddress2" class="form-label">CPF</label>
                                        <input type="text" class="form-control" id="inputAddress2"  value=<?php echo $cpf;?>>
                                </div>
                                <div class="col-md-6">
                                        <label for="inputCity" class="form-label">Cidade</label>
                                        <input type="text" class="form-control" id="inputCity">
                                </div>
                                <div class="col-md-4">
                                        <label for="inputState" class="form-label">State</label>
                                        <select id="inputState" class="form-select">
                                                <option selected>Choose...</option>
                                                <option>...</option>
                                        </select>
                                </div>
                                <div class="col-md-3">
                                        <label for="inputZip" class="form-label">Data de Nascimento</label>
                                        <input type="date" class="form-control" id="inputZip">
                                </div>
                                <div class="col-12">
                                        <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="gridCheck">
                                                <label class="form-check-label" for="gridCheck">
                                                        Check me out
                                                </label>
                                        </div>
                                </div>
                                <div class="col-12">
                                        <button type="submit" class="btn btn-primary">Sign in</button>
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
                                <img src="src/imagem/icones/instagram.png"
                                        alt="botão do perfil do instagram da Vanguard">
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