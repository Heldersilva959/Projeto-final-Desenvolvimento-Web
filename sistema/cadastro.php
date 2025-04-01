<?php
include_once("conexao.php");

if(isset($_POST['submit']))
{
@$nome = $_POST['nome'];
@$idade = $_POST['idade'];
@$email = $_POST['email'];
@$cpf = $_POST['cpf'];
@$senha = $_POST['senha'];
@$matricula = $_POST['matricula'];

// Insere o aluno na tabela usuarios
$sql_usuarios = "INSERT INTO usuarios (nome, idade, email, cpf, senha, tipo) 
                 VALUES ('$nome', '$idade', '$email', '$cpf', '$senha', 'Aluno')";
$result_users = mysqli_query($connection, $sql_usuarios);

// Seleciona o ID desse novo usuario
$sql_user_id = "SELECT id FROM usuarios WHERE cpf = '$cpf'";
$result = mysqli_query($connection, $sql_user_id);

if ($result && mysqli_num_rows($result) > 0) {
    $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
    $user_id = $rows[0]['id'];

    // Insere o aluno na tabela alunos usando o ID do usuario
    $sql_alunos = "INSERT INTO alunos (matricula, fk_user) 
                   VALUES ('$matricula', $user_id)";
    mysqli_query($connection, $sql_alunos);

    // Seleciona o ID do aluno
    $sql_aluno_id = "SELECT id FROM alunos WHERE fk_user = '$user_id'";
    $result_alun = mysqli_query($connection, $sql_aluno_id);

    if ($result_alun && mysqli_num_rows($result_alun) > 0) {
        $rows_alun = mysqli_fetch_all($result_alun, MYSQLI_ASSOC);
        $aluno_id = $rows_alun[0]['id'];

        // Seleciona as disciplinas para vincular ao aluno
        $sql_disciplinas = "SELECT id, fk_prof FROM disciplinas";
        $result_disciplinas = mysqli_query($connection, $sql_disciplinas);

        if ($result_disciplinas && mysqli_num_rows($result_disciplinas) > 0) {
            $disciplinas = mysqli_fetch_all($result_disciplinas, MYSQLI_ASSOC);

            // Insere o aluno em todas as disciplinas com nota inicial 0
            foreach ($disciplinas as $disciplina) {
                $disciplina_id = $disciplina['id'];
                $prof_id = $disciplina['fk_prof'];

                $sql_notas = "INSERT INTO notas (nota, dataL, fk_aluno, fk_prof, fk_disc) 
                              VALUES (0, '2024-08-27', $aluno_id, $prof_id, $disciplina_id)";
                mysqli_query($connection, $sql_notas);
            }
        }
    }

    echo "Aluno cadastrado com sucesso!";
} else {
    echo "Erro ao cadastrar o aluno.";
}
}
mysqli_close($connection);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Aluno</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1 {
            background-color: rgb(0, 0, 0);
            color: white;
            padding: 10px;
            text-align: center;
            margin: 0;
        }
        form {
            max-width: 600px;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
        }
        input[type="text"], input[type="email"], input[type="number"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border-radius: 4px;
            border: 1px solid #ccc;
        }
        #submit {
            width: 100%;
            padding: 10px;
            background-color: dodgerblue;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        #submit:hover {
            background-color: deepskyblue;
        }
    </style>
</head>
<body>
<h1>Cadastrar Novo Aluno</h1>
    <form action="cadastro.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="idade">Idade:</label>
        <input type="number" id="idade" name="idade" required>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <label for="matricula">Matrícula:</label>
        <input type="text" id="matricula" name="matricula" required>

        <input type="submit" name="submit" id="submit">
    </form>
</body>
</html>


