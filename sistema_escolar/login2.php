<?php 
include("conexao.php");
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['cpf']) &&  !empty($_POST['cpf']) && isset($_POST['senha']) && !empty($_POST['senha'])) {
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];

    // Consultando o banco de dados
    $sql = "SELECT * FROM usuarios WHERE cpf = '$cpf' AND senha = '$senha'";
    $result = mysqli_query($connection, $sql);
    
    if (mysqli_num_rows($result) == 1) { // Returns the number of rows in the result set.
        $user = mysqli_fetch_assoc($result);

        
        if ($user['tipo'] === 'Aluno') {

            $sql_aluno_id = "SELECT id FROM alunos WHERE fk_user = " . $user['id'];
            $result_aluno = mysqli_query($connection, $sql_aluno_id);

            if ($result_aluno && mysqli_num_rows($result_aluno) > 0) {
                $aluno = mysqli_fetch_assoc($result_aluno);

                $_SESSION['aluno_id'] = $aluno['id']; // Guarda ID do aluno na sessão
            header("Location: aluno.php?aluno_id=". $aluno['id']);// envia para pagina do aluno
            }
            else
            echo "Erro ao encontrar o ID do aluno.";
            
            
        } elseif ($user['tipo'] === 'Professor') {
            $_SESSION['prof_id'] = $user['id']; //Guarda ID do professor
            header("Location: professor.php?prof_id=". $user['id']);// envia para pagina do prof

        }
    }
    else{
        header("Location: logout.php"); // Redireciona para a página de logout
        exit();
    }
    }
    else{
        header("Location: logout.php"); // Redireciona para a página de logout
        exit();
    }
}

?>

<html lang="pt-br"><head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de login</title>
    <style>
        body {
            background-image: linear-gradient(45deg, rgb(194, 194, 26), rgb(18, 38, 218));
        }

        .box-shadow {
                -webkit-box-shadow: 0px 10px 20px 0px rgba(50, 50, 50, 0.52);
                -moz-box-shadow:    0px 10px 20px 0px rgba(50, 50, 50, 0.52);
                box-shadow:         0px 10px 20px 0px rgba(50, 50, 50, 0.52)
        }
        a{ color : dodgerblue }

        div{
            background-image: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI1IiBoZWlnaHQ9IjUiPgo8cmVjdCB3aWR0aD0iNSIgaGVpZ2h0PSI1IiBmaWxsPSIjZmZmIj48L3JlY3Q+CjxyZWN0IHdpZHRoPSIxIiBoZWlnaHQ9IjEiIGZpbGw9IiNjY2MiPjwvcmVjdD4KPC9zdmc+");
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%,-50%);
            padding: 80px;
            border-radius: 15px;
            color: #050505;
        }
        input{
            padding: 15px;
            border: none;
            outline: none;
            font-size: 15px;
        }
        button{
            background-color: dodgerblue;
            border: none;
            padding: 15px;
            width: 100%;
            border-radius: 10px;
            color: white;
            font-size: 15px;
            
        }
        button:hover{
            background-color: deepskyblue;
            cursor: pointer;
        }
        h1{
            color: rgb(0, 0, 0);
            font-family: "Helvetica Neue", Helvetica,
        }
    </style>
<style type="text/css" id="operaUserStyle"></style></head>
<body>
    <div class ="panel panel-default box-shadow">   
        <p class="text-center" style="margin-top: 20%;">
            <img src="logo.png" id="logo" class="img-responsive" width="250" style="margin-left: 20px;">
        </p>
        
        <h1>LOGIN TURMA 13</h1>
        <form action="login2.php" method="post">
        <input type="text" name="cpf" placeholder="CPF" required>
        <br><br>
        <a href="index.php">Logar com Email</a>
        <br><br>
        <input type="password" name="senha" placeholder="Senha" required>
        <br><br>
        <button type="submit">Enviar</button>
    </form>
        
    </div>

</body>

</html>