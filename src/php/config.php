<?php

$dbHost = 'Localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbName = 'vanguard';

$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

if($conexao -> connect_error)
{
    echo "Erro";
}
else
{
    echo "Conexão efetuada com sucesso";
}

?>