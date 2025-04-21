<?php 
include_once("conexao.php");

if (isset($_POST['submit'])) {
    // Coleta e tratamento dos dados do formulário
    $nome = htmlspecialchars($_POST['nome'], ENT_QUOTES, 'UTF-8');
    $email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
    $cpf = htmlspecialchars($_POST['cpf'], ENT_QUOTES, 'UTF-8');
    $senha = htmlspecialchars($_POST['senha'], ENT_QUOTES, 'UTF-8');
    $tipo = htmlspecialchars($_POST['tipo'], ENT_QUOTES, 'UTF-8');
    $data_nascimento = htmlspecialchars($_POST['data_nascimento'], ENT_QUOTES, 'UTF-8');
    $turma = ($tipo == 'Aluno') ? htmlspecialchars($_POST['turma'], ENT_QUOTES, 'UTF-8') : null;
    $matricula = ($tipo == 'Aluno') ? htmlspecialchars($_POST['matricula'], ENT_QUOTES, 'UTF-8') : null;

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
        if (empty($matricula) || empty($turma)) {
            die("Matrícula e turma são obrigatórias para alunos");
        }

        $sql_alunos = "INSERT INTO alunos (matricula, fk_user) 
                       VALUES ('$matricula', $user_id)";
        $result_alunos = mysqli_query($connection, $sql_alunos);

        if (!$result_alunos) {
            die("Erro ao cadastrar aluno: " . mysqli_error($connection));
        }

        $aluno_id = mysqli_insert_id($connection);

        // Vincular disciplinas
        $sql_disciplinas = "SELECT id, fk_prof FROM disciplinas";
        $result_disciplinas = mysqli_query($connection, $sql_disciplinas);

        if ($result_disciplinas && mysqli_num_rows($result_disciplinas) > 0) {
            $disciplinas = mysqli_fetch_all($result_disciplinas, MYSQLI_ASSOC);

            foreach ($disciplinas as $disciplina) {
                $disciplina_id = $disciplina['id'];
                $prof_id = $disciplina['fk_prof'];

                $sql_notas = "INSERT INTO notas (nota, dataL, fk_aluno, fk_prof, fk_disc) 
                              VALUES (0, '2024-08-28', $aluno_id, $prof_id, $disciplina_id)";
                mysqli_query($connection, $sql_notas);
            }
        }

        // Vincular aluno à turma
        $sql_turmas = "SELECT id FROM turmas WHERE id = $turma";
        $result_turmas = mysqli_query($connection, $sql_turmas);
        if ($result_turmas && mysqli_num_rows($result_turmas) > 0) {
            $sql_turma_alunos = "INSERT INTO turma_alunos (fk_aluno, fk_turma) 
                                 VALUES ($aluno_id, $turma)";
            mysqli_query($connection, $sql_turma_alunos);
        }
    }
    else if ($tipo == 'Professor') {
        // Se for professor, insere na tabela de professores
        $sql_professores = "INSERT INTO professores (fk_user) 
                            VALUES ($user_id)";
        $result_professores = mysqli_query($connection, $sql_professores);

        if (!$result_professores) {
            die("Erro ao cadastrar professor: " . mysqli_error($connection));
        }
    }
    else if ($tipo == 'Administrador') {
        // Se for administrador, insere na tabela de administradores
        $sql_administradores = "INSERT INTO administradores (fk_user) 
                                VALUES ($user_id)";
        $result_administradores = mysqli_query($connection, $sql_administradores);

        if (!$result_administradores) {
            die("Erro ao cadastrar administrador: " . mysqli_error($connection));
        }
    }

    // Redirecionamento com sucesso
    header("Location: cadastro.php?success=1");
    exit;
}
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
<?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
    <script>alert('Cadastro realizado com sucesso!');</script>
<?php endif; ?>

<h1>Cadastrar Novo Usuario</h1>
    <form action="cadastro.php" method="post">
        <label for="nome">Nome:</label>
        <input placeholder="Ex: João" class="inputCad" type="text" id="nome" name="nome" required>

        <label for="email">Email:</label>
        <input placeholder="Ex: aluno@Gmail.com" class="inputCad" type="text" id="email" name="email" required>

        <label for="data">Data de Nascimento:</label>
        <input type="text" id="data_nascimento" class="inputCad" name="data_nascimento" placeholder="DD/MM/AAAA" pattern="\d{2}\/\d{2}\/\d{4}" required>

        <label for="cpf">CPF:</label> 
        <input  placeholder="Ex: 000.000.000-00" class="inputCad" type="text" id="cpf" name="cpf" pattern="\d{3}\.\d{3}\.\d{3}-\d{2}" required>

        <label for="senha">Senha:</label>
        <input placeholder="Ex: Senha123" class="inputCad" type="password" id="senha" name="senha" required>

        <label for="tipo">Tipo:</label>
        <div class="select-container">
            <select style=" margin-left: 2em; margin-bottom: 1em; border-radius: 5px; border: 1px solid #ccc;" id="tipo" name="tipo" required>
                <option value="">Selecione:</option>
                <option value="Aluno">Aluno</option>
                <option value="Professor">Professor</option>
                <option value="Administrador">Administrador</option>
            </select>
        </div>

        <div id="para_aluno">
            <label for="sealuno">caso a opção anterior seja 'Aluno' adicione: </label>
            <label for="matricula">Matrícula:</label>
            <input placeholder="Ex: 123456" class="inputCad" type="text" id="matricula" name="matricula" pattern="\d{6}">

            <label for="turma">Turma:</label>
            <div>
                <select style=" margin-left: 2em; margin-bottom: 1em; border-radius: 5px; border: 1px solid #ccc;" id="turma" name="turma">
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
        </div>

        <input class="inputCad" type="submit" name="submit" id="submit">
    </form>
    <div style="text-align: center;">
        <button class="button-cadastro" onclick="window.location.href='administrador.php'">Voltar</button>
    </div>
</body>
</html>
