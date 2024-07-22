<?php
include('Class/ClassEstado.php');
$objEstados = new ClassEstados();
?>
        <option value="">Selecione o Estado</option>
      <?php foreach ($objEstados->getEstados() as $estado) { ?>
            <option value="<?php echo $estado->estado_id;  ?>"><?php echo $estado->nome_estado; ?></option>
      <?php } 
      ?>
    </select>

    <br><br>

    <select name="cidades" id="cidades" disabled="disabled">
        <option value="">Selecione a Cidade</option>
    </select>


    <script src="../js/cadastroEstado.js"></script>

</body>
</html>












<?php
include('conexao.php');
// Initialize database connection

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['submit'])) {
    $nome = $_POST['nome'];
    $dt_nasc = $_POST['dt_nasc'];
    $cep = $_POST['cep'];
    $bairro = $_POST['bairro'];
    $rua = $_POST['rua'];
    $num_predial = $_POST['num_predial'];
    $cpf = $_POST['cpf'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepare and execute INSERT query
    $stmt = $conn->prepare("INSERT INTO Usuario (nome, dt_nasc, cep, bairro, rua, num_predial, cpf, email, senha) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssssss", $nome, $dt_nasc, $cep, $bairro, $rua, $num_predial, $cpf, $email, $senha);
    $stmt->execute();


    // Redireciona o usuário para a página 'indexLogado.html'
    header("Location: ../../indexLogado.html");
    exit;
}
?>
<!--Para a parte do estado-->
