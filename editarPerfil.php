<!--Fazer outro layou nesse -->

<?php
// Inclua a conexão com o banco de dados
include('src/php/conexao.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(!empty($_GET['usuario_id']))
{
    $id = $_GET['usuario_id'];
    $sqlSelect = "SELECT * FROM usuario WHERE usuario_id = $id";
    $result = $conn->query($sqlSelect);
    if($result->num_rows > 0)
    {
        while($user_data = mysqli_fetch_assoc($result))
        {
            $nome = $user_data['nome'];
            $senha = $user_data['senha'];
            $email = $user_data['email'];
            $dt_nasc = $user_data['dt_nasc'];
            $cpf = $user_data['cpf'];
            // Verificação para evitar erro de array indefinido
            $cidade = isset($user_data['cidade_id']) ? $user_data['cidade_id'] : ''; 
            $estado = isset($user_data['estado_id']) ? $user_data['estado_id'] : '';
        }


        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            // Obtenha os detalhes do arquivo
            $fileTmpPath = $_FILES['foto']['tmp_name'];
            $fileNome = $_FILES['foto']['name'];
            $fileSize = $_FILES['foto']['size'];
            $fileType = $_FILES['foto']['type'];
            $foto = addslashes(file_get_contents($fileTmpPath));
        }
 }

}
else {
        header('Location: contas.php');
        exit;
    
    }
// Carrega a lista de estados
$sql_code_states = "SELECT * FROM estado ORDER BY nome_estado ASC";
$sql_query_states = $conn->query($sql_code_states) or die($conn->error);

// Carrega a lista de cidades
$sql_code_cities = "SELECT * FROM cidades ORDER BY nome_cidade ASC";
$sql_query_cities = $conn->query($sql_code_cities) or die($conn->error);
;
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
                <form class="row g-3" action="src/php/saveEdit.php" method="POST" enctype="multipart/form-data">

                                <div class="col-md-6">
                                        <label for="inputEmail4" class="form-label">Nome</label>
                                        <input type="text" class="form-control" id="inputEmail4" name="nome" value=<?php echo $nome;?>>
                                </div>
                                <div class="col-md-6">
                                        <label for="inputPassword4" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="inputPassword4"
                                        name="email"  value=<?php echo $email;?>>
                                </div>
                                <div class="col-3">
                                        <label for="inputAddress" class="form-label">Senha</label>
                                        <input type="text" class="form-control" id="inputAddress"
                                        name="senha"
                                        value=<?php echo $senha;?>>
                                </div>
                                <div class="col-5">
                                        <label for="inputAddress2" class="form-label">CPF</label>
                                        <input type="number" class="form-control" id="inputAddress2" 
                                        name="cpf" value=<?php echo $cpf;?>>
                                </div>

                                <div class="col-6">
                                <select name="estado" id="estado" class="form-select" required>
                                <label for="inputState" class="form-label">State</label>
                                   
                                <option value="">Selecione um estado</option>
                            <?php while ($estado = $sql_query_states->fetch_assoc()) { ?>
                                <option value="<?php echo $estado['estado_id']; ?>">
                                    <?php echo $estado['nome_estado']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                    <div class="col-6">
                                <select name="cidade" id="cidade" class="form-select"   required>
                                <label for="inputState" class="form-label">State</label>
                                <?php while ($cidade = $sql_query_cities->fetch_assoc()) { ?>
                                <option value="<?php echo $cidade['cidade_id']; ?>">
                                    <?php echo $cidade['nome_cidade']; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>

                                        
                          
                                <div class="col-md-5">
                                        <label for="inputZip" class="form-label">Data de Nascimento</label>
                                        <input type="date" class="form-control" id="inputZip" 
                                        name="dt_nasc" value=<?php echo $dt_nasc;?>>
                                </div>

                              <!--  <div class="col-md-5">
                                        <label for="inputZip" class="form-label">foto</label>
                                <input type="file" class="form-control" name="foto" id="foto" required>
                        <span>Foto de perfil</span>
</div> -->

<input type="number" name="usuario_id" value=<?php echo $id;?>>
              
                          <div class="col-12">
                                        <button type="submit" class="btn btn-primary" name="update">Sign in</button>
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