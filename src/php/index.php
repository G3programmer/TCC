<?php
$servername = "localhost";
$username = "root";
$passworld = "";
$dbname = "vanguard";

$conn = new mysqli($servername,$username,$passworld,$dbname);

if ($conn -> connect_error) {
    die("Connection failed: " .$conn->connect_error);
}

?>