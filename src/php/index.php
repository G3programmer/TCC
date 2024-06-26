<?php
$servername = "localhost";
$username = "root";
$passworld = "";
$dbname = "vanguard";

$conn = new mysqli($servername,$username,$passworld,$dbname);

if ($conn -> connect_errno) {
    echo "ERRO";
}
else{

    echo"Conexão efetuada com sucesso"; 
}

try {
    $pdo = new PDO('mysql:host=' . $servername . ';dbname=' . $dbname, $username, $passworld);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}   catch (PDOException $err) {
    echo "Houve um erro no banco de dados" . $err->getMessage();
    exit;
}

?>