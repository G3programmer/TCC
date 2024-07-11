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

class ClassConect
{
    public function conectaDB()
    {
        try{
            return $con=new \PDO("mysql:servername=localhost;dbname=vanguard","root","");
        }catch (\PDOException $erro){
            return $erro->getMessage();
        }
    }
}
?>