<?php
include('conexao.php');
include('cadastro.php');

$sql_code_states = "SELECT * FROM estado ORDER BY nome_estado ASC";
$sql_query_states = $conn->query($sql_code_states) or die($conn->error);

?>
        <?php while($estado = $sql_query_states->fetch_assoc()) { ?> 
<?php if(isset($_POST['estado']) && $_POST['estado'] == $estado['estado_id']) echo "selected"; ?> value="<?php echo $estado['estado_id']; ?>"><?php echo $estado['nome_estado']; ?></option>
        <?php } ?>
     <?php if(isset($_POST['estado'])) { ?>
        <?php 
        $selected_state = $conn->real_escape_string($_POST['estado']);
        $sql_code_cities = "SELECT * FROM cidades WHERE estado_id = '$selected_state' ORDER BY nome_cidade";
        $sql_query_cities = $conn->query($sql_code_cities) or die($conn->error);
        while($cidade = $sql_query_cities->fetch_assoc()) { ?>
        <?php echo $cidade['cidade_id']; ?>"><?php echo $cidade['nome_cidade']; ?></option>
        <?php } ?>
        <?php } ?>
   