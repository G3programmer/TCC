<?php
include ('../index.php');

class ClassEstados extends ClassConect
{

    public function getEstados()
    {
        $estado = $this->conectaDB()->prepare('select * from estados');
        $estado->execute();
        return $fEstados = $estado->fetchAll(\PDO::FETCH_OBJ);
    }
}

if (isset($_POST['submit'])) {
    include_once ('../index.php');


    $nome = $_POST['nome'];
    $dt_nasc = $_POST['dt_nasc'];
    $nome_estado = $_POST['estado']; // Nome do estado
    $nome_cidade = $_POST['cidade']; // Nome da cidade
    $cep = $_POST['cep'];
    $bairro = $_POST['bairro'];
    $rua = $_POST['rua'];
    $num_predial = $_POST['num_predial'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_BCRYPT);



    // Verificar se o CPF já está registrado
    $stmt = $conn->prepare("SELECT id FROM Usuario WHERE cpf = ?");
    $stmt->bind_param("s", $cpf);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "CPF já registrado.";
    } else {
        // Inserir usuário
        $stmt = $conn->prepare("INSERT INTO Usuario (Nome, dt_nasc, cep, bairro, rua, num_predial, Cidades_id, Cidades_Estado_id, cpf, email, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssisisss", $nome, $dt_nasc, $cep, $bairro, $rua, $num_predial, $cidade_id, $estado_id, $cpf, $email, $senha);


        include ('../index.php');

        class ClassEstados extends ClassConect
        {

            public function getEstados()
            {
                $estado = $this->conectaDB()->prepare('select * from estados');
                $estado->execute();
                return $fEstados = $estado->fetchAll(\PDO::FETCH_OBJ);
            }
        }



        if ($stmt->execute()) {
            // Autenticação bem-sucedida
            $user_id = $stmt->insert_id;
            $_SESSION['id'] = $user_id;

            // Redireciona o usuário para a página 'indexLogado.html'
            header("Location: ../../indexLogado.html");
            exit(); // Encerra a execução do script
        } else {
            echo "Erro: " . $stmt->error;
        }
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método de requisição inválido.";
}
?>
<?php
$objEstados = new ClassEstados();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/css/index.css">
    <link rel="stylesheet" href="src/css/fonte.css">
    <link rel="stylesheet" href="src/css/style-cadastro.css">
    <link rel="stylesheet" href="src/css/responsivo-cadastro.css">
    <link href="https://fonts.cdnfonts.com/css/milestone-one" rel="stylesheet">
    <link href="https://fonts.cdnfonts.com/css/codygoon" rel="stylesheet">
    <title>Vanguard | Cadastro</title>
    <link rel="shortcut icon" href="src/imagem/icones/escudo.png" type="image/x-icon">
</head>

<body>
    <header class="cabecalho">
        <a href="index.html"><img class="logo" src="src/imagem/logos/VanguardLogo - titulo.png"
                alt="titulo da Vanguard"></a>
    </header>
    <main class="home">
        <img class="imagem-fundo" src="src/imagem/logos/soldado-cadastro.png" alt="">

        <div class="box">
            <span class="borderLine"></span>
            <form class="formulario" action=" method=" post">
                <h1 class="titulo">Cadastre-se</h1>

                <div class="inputBox">
                    <input type="text" name="nome" id="nome" required="required">
                    <span>Nome</span>
                    <i></i>
                </div>

                <div class="inputBox">
                    <input type="date" name="dt_nasc" id="dt_nasc" required="required">
                    <span>Data de Nascimento</span>
                    <i></i>
                </div>

                <div class="inputBox">
                    <select name="estado" id="estado" required="required">
                        <option value="">Selecione o estado</option>
                        <?php foreach ($objEstados->getEstados() as $estado) { ?>
                            <option value="<?php echo $estado->id; ?>"><?php echo $estado->nome; ?></option>
                        <?php } ?>
                    </select>
                    <br><br>

                    <select name="cidades" id="cidades" disabled="disabled" required="required">
                        <option value="">Selecione a Cidade</option>
                    </select>
                </div>
                <br>

                <div class="inputBox">
                    <input type="text" name="cep" id="cep" required="required">
                    <span>CEP</span>
                    <i></i>
                </div>

                <div class="inputBox">
                    <input type="text" name="bairro" id="bairro" required="required">
                    <span>Bairro</span>
                    <i></i>
                </div>

                <br>

                <div class="inputBox">
                    <input type="text" name="rua" id="rua" required="required">
                    <span>Rua</span>
                    <i></i>
                </div>

                <br>

                <div class="inputBox">
                    <input type="text" name="num_predial" id="num_predial" required="required">
                    <span>Número Predial</span>
                    <i></i>
                </div>

                <br>

                <div class="inputBox">
                    <input type="text" name="cpf" id="cpf" required="required">
                    <span>CPF</span>
                    <i></i>
                </div>

                <br>

                <div class="inputBox">
                    <input type="text" name="email" id="email" required="required">
                    <span>Email</span>
                    <i></i>
                </div>

                <br>

                <div class="inputBox">
                    <input type="password" name="senha" id="senha" required="required">
                    <span>Senha</span>
                    <i></i>
                </div>

                <div class="links">
                    <a href="login.html">Log in</a>
                </div>

                <input type="submit" name="submit" id="submit" value="Cadastrar">
            </form>
        </div>
    </main>
    <footer class="roda-pe">
        <img src="src/imagem/logos/VanguardLogo-Escuro.png" alt="logo da Vanguard" class="logo">
        <h5 class="subtitulo">Nos acompanhe pelas redes sociais</h5>
        <div class="social_media">
            <a href="facebook link" id="facebook" title="Facebook" target="_blank"><img
                    src="src/imagem/icones/Facebook.png" alt="botão do perfil do facebook da Vanguard"></a>
            <a href="" id="instagram" title="Instagram" target="_blank"><img src="src/imagem/icones/instagram.png"
                    alt="botão do perfil do instagram da Vanguard"></a>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="src/js/cadastroEstado.js"></script>
    <script src="src/js/cadastro-imagem.js"></script>
</body>

</html>