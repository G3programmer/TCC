<?php
$servername = "localhost";
$username = "root";
$passworld = "";
$dbname = "vanguard";


$conn = new mysqli($servername,$username,$passworld,$dbname);
if ($conn -> connect_errno) {
die("Falha na conexão");
}