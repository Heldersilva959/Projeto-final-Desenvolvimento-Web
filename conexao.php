<?php
$hostname = "localhost";
$bancodedados = "sistema_esc";
$usuario = "root";
$senha = "";

// conectando:

$connection = mysqli_connect($hostname, $usuario, $senha, $bancodedados);
if (!$connection) { //condição de falha
    die("Falha na conexão: " . mysqli_connect_errno() . " - " . mysqli_connect_error()); // mostrando cod do erro e erro
}


