<?php
include("conexao.php");
session_start();

// Verifica se o administrador está logado
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.html");
    exit;
}

// verifica se o ID do usuário a ser editado foi passado na URL
if (isset($_GET['id'])) {
    $usuario_id = $_GET['id'];

    // Consulta os dados do usuário
    $sql = "SELECT u.id, u.nome, u.email, u.senha, u.idade, u.cpf, u.tipo, a.matricula, p.id AS prof_id, ad.id AS admin_id 
            FROM usuarios u
            LEFT JOIN alunos a ON u.id = a.fk_user
            LEFT JOIN professores p ON u.id = p.fk_user
            LEFT JOIN administradores ad ON u.id = ad.fk_user
            WHERE u.id = $usuario_id";
    $resultado = mysqli_query($connection, $sql);
    $usuario = mysqli_fetch_assoc($resultado);

    if (!$usuario) {
        // Se o usuário não for encontrado
        echo "Usuário não encontrado!";
        exit;
    }
}

// Atualizar os dados do usuário
if (isset($_POST['atualizar'])) {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $idade = $_POST['idade'];
    $cpf = $_POST['cpf'];
    $tipo = $_POST['tipo'];

    // Se a senha foi alterada, criptografe-a
    if (!empty($senha)) {
        $senha = $senha;  // Criptografa a senha
    } else {
        // Se não foi alterada, mantém a senha antiga
        $senha = $usuario['senha'];
    }

    // Atualiza os dados na tabela de usuarios
    $sql_update = "UPDATE usuarios SET nome = '$nome', email = '$email', senha = '$senha', idade = '$idade', cpf = '$cpf', tipo = '$tipo' WHERE id = $usuario_id";
    mysqli_query($connection, $sql_update);

    // Verifica se o usuário é aluno e atualiza a matrícula
    if ($tipo == 'Aluno') {
        $matricula = $_POST['matricula'];
        // Atualiza a tabela de alunos
        if (isset($usuario['matricula'])) {
            $sql_matricula = "UPDATE alunos SET matricula = '$matricula' WHERE fk_user = $usuario_id";
            mysqli_query($connection, $sql_matricula);
        } else {
            // Se o usuário ainda não é aluno, insere a matrícula
            $sql_matricula = "INSERT INTO alunos (fk_user, matricula) VALUES ($usuario_id, '$matricula')";
            mysqli_query($connection, $sql_matricula);
        }
    }

    // Redireciona após a atualização
    header("Location: gerenciar_usuarios.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <style>
        /* Adicione o estilo para o formulário aqui, caso queira personalizar */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 60%;
            margin: 50px auto;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-top: 10px;
            font-weight: bold;
        }
        input, select {
            padding: 10px;
            margin-top: 5px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        button {
            background-color: #2196F3;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 20px;
        }
        button:hover {
            background-color: #0b7dda;
        }
        .btn-voltar {
            background-color: #f44336;
            color: white;
            padding: 10px 15px;
            margin-top: 10px;
            text-align: center;
            display: inline-block;
            width: 100%;
        }
        .btn-voltar:hover {
            background-color: #e53935;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Editar Usuário</h1>

        <form method="POST">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($usuario['nome']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" placeholder="Digite a nova senha (ou deixe em branco para manter a atual)">

            <label for="idade">Idade:</label>
            <input type="number" id="idade" name="idade" value="<?php echo htmlspecialchars($usuario['idade']); ?>" required>

            <label for="cpf">CPF:</label>
            <input type="text" id="cpf" name="cpf" value="<?php echo htmlspecialchars($usuario['cpf']); ?>" required>

            <label for="tipo">Tipo:</label>
            <select id="tipo" name="tipo" required>
                <option value="Administrador" <?php echo $usuario['tipo'] == 'Administrador' ? 'selected' : ''; ?>>Administrador</option>
                <option value="Professor" <?php echo $usuario['tipo'] == 'Professor' ? 'selected' : ''; ?>>Professor</option>
                <option value="Aluno" <?php echo $usuario['tipo'] == 'Aluno' ? 'selected' : ''; ?>>Aluno</option>
            </select>

            <!-- Se for aluno, mostrar o campo para matrícula -->
            <?php if ($usuario['tipo'] == 'Aluno'): ?>
                <label for="matricula">Matrícula:</label>
                <input type="text" id="matricula" name="matricula" value="<?php echo htmlspecialchars($usuario['matricula']); ?>" required>
            <?php endif; ?>

            <button type="submit" name="atualizar">Atualizar</button>
        </form>

        <a href="gerenciar_usuarios.php" class="btn-voltar">Voltar para Gerenciamento de Usuários</a>
    </div>
</body>
</html>

<?php mysqli_close($connection); ?>
