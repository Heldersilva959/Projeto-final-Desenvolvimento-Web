<?php 
session_start();
if (!isset($_SESSION['prof_id'])) {
    
    header("Location: login1.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Professor</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }
        h1 {
            background-color: rgb(0 0 0);
            color: white;
            padding: 10px;
            text-align: center;
            margin: 0;
        }
        p {
            text-align: center;
            font-size: 16px;
            margin: 20px 0;
        }
        form {
            display: flex;
            justify-content: center;
            margin: 10px;
        }
        button {
            background-color: dodgerblue;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px 2px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: deepskyblue;
        }
    </style>
</head>
<body>
    <h1>Página do Professor</h1>
    <p>Bem-vindo à página do professor! Aqui você pode gerenciar suas atividades.</p>

    <form action="notas.php" method="post">
        <button type="submit">Ver Notas dos Alunos</button>
    </form>
    <form action="cadastro.php" method="post">
        <button type="submit">Cadastrar Novos Alunos</button> 
    </form>
</body>
</html>

