<?php

    $dbHost = 'localhost';
    $dbUsername = 'root';
    $dbPassword = '';
    $dbName = 'vanguard';
    
    $conn = new mysqli($dbHost,$dbUsername,$dbPassword,$dbName);

 
    /* if($conn->connect_errno)
     {
         echo "Erro";
     }
     else
     {
         echo "Conexão efetuada com sucesso";
     }
*/
?>