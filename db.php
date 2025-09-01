<?php
$host = "localhost";
$user = "cruduser";
$pass = "senha123";
$db   = "crud_php";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
