<?php

    if(!empty($_GET['usuario_id']))
    {
        include_once('conexao.php');

        $id = $_GET['usuario_id'];

        $sqlSelect = "SELECT * FROM usuario WHERE usuario_id= $id";

        $result = $conn->query($sqlSelect);

        if($result->num_rows > 0)
        {
            $sqlDelete = "DELETE FROM usuario WHERE usuario_id= $id";
            $resultDelete = $conn->query($sqlDelete);
        }
    }
    header('Location: ../../contas.php');
   
?>