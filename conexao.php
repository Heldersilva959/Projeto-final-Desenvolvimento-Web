<?php
$hostname = $_ENV['DB_HOST'];;
$bancodedados = $_ENV['DB_NAME'];;
$usuario = "DB_USER";
$senha = "DB_PASS";

// conectando:

$connection = mysqli_connect($hostname, $usuario, $senha, $bancodedados);
if (!$connection) { //condição de falha
    die("Falha na conexão: " . mysqli_connect_errno() . " - " . mysqli_connect_error()); // mostrando cod do erro e erro
}

$valor = $_ENV['DB_HOST'];