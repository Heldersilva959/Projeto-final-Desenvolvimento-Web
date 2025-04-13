<?php
include_once("conexao.php");

if(isset($_POST['submit'])) {
    // Coleta dos dados
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $senha = $_POST['senha'];
    $tipo = $_POST['tipo'];
    $data_nascimento = $_POST['data_nascimento'];
    $turma = ($tipo == 'Aluno') ? $_POST['turma'] : null;
    // Validação da data
    $data = DateTime::createFromFormat('d/m/Y', $data_nascimento);
    if (!$data) {
        die("Formato de data inválido. Use DD/MM/AAAA");
    }
    $hoje = new DateTime();
    $idade = $hoje->diff($data)->y;

    // Inserção do usuário
    $sql_users = "INSERT INTO usuarios (nome, idade, email, cpf, senha, tipo) 
                    VALUES ('$nome', '$idade', '$email', '$cpf', '$senha', '$tipo')";
    $result_users = mysqli_query($connection, $sql_users);

    if (!$result_users) {
        die("Erro ao cadastrar o usuário: " . mysqli_error($connection));
    }

    $user_id = mysqli_insert_id($connection);

    // Se for aluno, insere a matrícula
    if ($tipo == 'Aluno') {
        if (empty($matricula)&& $turma == null) {
            die("Matrícula e turma é obrigatória para alunos");
        }
        $matricula = ($tipo == 'Aluno') ? $_POST['matricula'] : null;
        $sql_alunos = "INSERT INTO alunos (matricula, fk_user) 
                      VALUES ('$matricula', $user_id)";
        $result_alunos = mysqli_query($connection, $sql_alunos);

        if (!$result_alunos) {
            die("Erro ao cadastrar aluno: " . mysqli_error($connection));
        }

        $aluno_id = mysqli_insert_id($connection);

        // Vincular disciplinas
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
                             VALUES (0, '2024-08-28', $aluno_id, $prof_id, $disciplina_id)";
               mysqli_query($connection, $sql_notas);
            }
        }

        // Vincular aluno a turma (se necessário)
        $sql_turmas = "SELECT id FROM turmas WHERE id = $turma";
        $result_turmas = mysqli_query($connection, $sql_turmas);
        if ($result_turmas && mysqli_num_rows($result_turmas) > 0) {
            $sql_turma_alunos = "INSERT INTO turma_alunos (fk_aluno, fk_turma) 
                                 VALUES ($aluno_id, $turma)";
            mysqli_query($connection, $sql_turma_alunos);
        }
    }


    echo "Cadastro realizado com sucesso!";
    header("Location: cadastro.php"); // Redireciona para a página inicial
    exit;
    mysqli_close($connection);
    exit;
}
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
        input[type="text"], input[type="email"], input[type="password"], select {
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
        button {
            background-color: dodgerblue;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 4px;
        }
        button:hover {
            background-color: deepskyblue;
        }

    </style>
</head>
<body>
<h1>Cadastrar Novo Usuario</h1>
    <form action="cadastro.php" method="post">
        <label for="nome">Nome:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="email@dominio.com" required>

        <label for="data">Data de Nascimento:</label>
        <input type="text" id="data_nascimento" name="data_nascimento" placeholder="DD/MM/AAAA" required>

        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required>

        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required>

        <label for="tipo">Tipo:</label>
        <select id="tipo" name="tipo" required>
            <option value="">Selecione:</option>
            <option value="Aluno">Aluno</option>
            <option value="Professor">Professor</option>
            <option value="Administrador">Administrador</option>
        </select>

        <div id="para_aluno">
            <label for="sealuno">caso a opção anterior seja 'Aluno' adicione: </label>
        <label for="matricula">Matrícula:</label>
        <input type="text" id="matricula" name="matricula">
        <label for="turma">Turma:</label>
        <select id="turma" name="turma">
            <option value="">Selecione:</option>
            <?php
            // Consulta para obter as turmas
            $sql_turmas = "SELECT id, nome FROM turmas";
            $result_turmas = mysqli_query($connection, $sql_turmas);

            if ($result_turmas && mysqli_num_rows($result_turmas) > 0) {
                while ($row = mysqli_fetch_assoc($result_turmas)) {
                    echo "<option value='" . $row['id'] . "'>" . $row['nome'] . "</option>";
                }
            } else {
                echo "<option value=''>Nenhuma turma encontrada</option>";
            }
            ?>
        </select>
        </div>

        <input type="submit" name="submit" id="submit">
    </form>
    <div style="text-align: center;">
        <button onclick="window.location.href='index.html'">Deslogar</button>
    </div>
</body>
</html>


