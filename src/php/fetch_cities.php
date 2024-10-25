<?php
include_once('conexao.php');

if (isset($_POST['estado_id'])) {
    $estado_id = mysqli_real_escape_string($conn, $_POST['estado_id']);
    $sql_code_cities = "SELECT * FROM cidades WHERE estado_id = $estado_id ORDER BY nome_cidade ASC";
    $sql_query_cities = $conn->query($sql_code_cities);

    while ($cidade = $sql_query_cities->fetch_assoc()) {
        echo '<option value="'.$cidade['cidade_id'].'">'.$cidade['nome_cidade'].'</option>';
    }
}
?>