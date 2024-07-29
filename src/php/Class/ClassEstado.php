<?php 
if(isset($_POST['submit'])) 
    {
        
        include_once('conexao.php');
    $nome = $_POST['nome'];
    $dt_nasc = $_POST['dt_nasc'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $cpf = $_POST['cpf'];

    $result = mysqli_query($conn, "INSERT INTO usuario(nome,dt_nasc,email,senha,cpf) VALUES($nome, $dt_nasc, $email, $senha, $cpf)");
    }

    //pegue o vídeo do formulário para completar

?>

<?php
include('Class/ClassEstado.php');
$objEstados = new ClassEstado();
?>

<?php
include('ClassConect.php');

class ClassEstado extends ClassConect
{

    public function getEstados()
    {
        include('../conexao.php');
   
        $query = "SELECT estado_id, nome_estado FROM estado";
        $result = $conn->query($query);
        $estado = [];
        while ($row = $result->fetch_assoc()) {
            $estado[] = $row;
        }
        $conn->close();
        return $estado; }

}
?>



<?php foreach ($objEstados->getEstados() as $estado) { ?>
            <option value="<?php echo $estado->estado_id;  ?>"><?php echo $estado->nome_estado; ?></option>
      <?php } ?>