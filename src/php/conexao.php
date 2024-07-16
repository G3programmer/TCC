<?php

$hostname = "localhost";
$db = "vanguard";
$user = "root";
$pass = "";

$conn = new mysqli('localhost', 'root', '', 'vanguard');

$mysqli = new mysqli($hostname, $user, $pass, $db);
if($mysqli->connect_errno) {
    die("Falha na conexão com o banco de dados");
}