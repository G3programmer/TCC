<?php

    if(!empty($_GET['id']))
    {
        include_once('conexao.php');

        $id = $_GET['id'];

        $sqlSelect = "SELECT * FROM usuario WHERE id=$id";

        $result = $conn->query($sqlSelect);

        if($result->num_rows > 0)
        {
            $sqlDelete = "DELETE FROM usuario WHERE id=$id";
            $resultDelete = $conn->query($sqlDelete);
        }
    }
    header('Location: ../../contas.php');
   
?>