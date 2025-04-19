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
    <link rel="stylesheet" href="Style/cad.css">
</head>
<body>
<h1>Cadastrar Novo Aluno</h1>
    <form action="cadastro.php" method="post">
        <label for="nome">Nome:</label>
        <input placeholder="Ex: João" class="inputCad" type="text" id="nome" name="nome" required>
        <label for="email">Email:</label>
        <input placeholder="Ex: aluno@Gmail.com" class="inputCad" type="email" id="email" name="email" required>
        <label for="idade">Idade:</label>
        <input placeholder="Ex: 20" class="inputCad" type="number" id="idade" name="idade" required>

        <label for="cpf">CPF:</label>
        <input  placeholder="Ex: 000.000.000-00" class="inputCad" type="text" id="cpf" name="cpf" required>

        <label for="senha">Senha:</label>
        <input placeholder="Ex: Senha123" class="inputCad" type="password" id="senha" name="senha" required>

        <label for="matricula">Matrícula:</label>
        <input placeholder="Ex: 123456" class="inputCad" type="text" id="matricula" name="matricula" required>

        <input class="inputCad" type="submit" name="submit" id="submit">
    </form>
    <div style="text-align: center;">
        <button onclick="window.location.href='professor.php'">Voltar</button>
    </div>
</body>
</html>


