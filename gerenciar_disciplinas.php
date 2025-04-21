<?php
include("conexao.php");
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.html");
    exit;
}

// Processa a exclusão de disciplina
if (isset($_POST['deletar'])) {
    $disciplina_id = $_POST['disciplina_id'];
    $sql_delete = "DELETE FROM disciplinas WHERE id = $disciplina_id";
    mysqli_query($connection, $sql_delete);
    header("Location: gerenciar_disciplinas.php");
    exit;
}

// Processa atualização de disciplina
if (isset($_POST['editar'])) {
    $disciplina_id = $_POST['disciplina_id'];
    $novo_nome = $_POST['novo_nome'];
    $sql_update = "UPDATE disciplinas SET nome = '$novo_nome' WHERE id = $disciplina_id";
    mysqli_query($connection, $sql_update);
    header("Location: gerenciar_disciplinas.php");
    exit;
}

// Processa adição de nova disciplina
if (isset($_POST['adicionar'])) {
    $nome_disciplina = $_POST['nome_disciplina'];
    $sql_insert = "INSERT INTO disciplinas (nome) VALUES ('$nome_disciplina')";
    mysqli_query($connection, $sql_insert);
    header("Location: gerenciar_disciplinas.php");
    exit;
}

// Consulta todas as disciplinas
$sql = "SELECT * FROM disciplinas ORDER BY nome";
$resultado = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Disciplinas</title>
    <link rel="stylesheet" href="style/gerTurma.css"> <!-- Você pode usar o mesmo CSS -->
</head>
<body>
<div class="container">
    <h1>Gerenciamento de Disciplinas</h1>

    <?php if (mysqli_num_rows($resultado) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Nome da Disciplina</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($disciplina = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <td>
                            <form method="post" class="inline-form">
                                <input type="hidden" name="disciplina_id" value="<?php echo $disciplina['id']; ?>">
                                <input type="text" name="novo_nome" value="<?php echo htmlspecialchars($disciplina['nome']); ?>">
                                <button type="submit" name="editar" class="btn btn-editar">Salvar</button>
                            </form>
                        </td>
                        <td class="acoes">
                            <form method="post" class="inline-form" onsubmit="return confirm('Tem certeza que deseja excluir esta disciplina?');">
                                <input type="hidden" name="disciplina_id" value="<?php echo $disciplina['id']; ?>">
                                <button type="submit" name="deletar" class="btn btn-excluir">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhuma disciplina cadastrada.</p>
    <?php endif; ?>

    <div class="form-adicionar">
        <h3>Adicionar Nova Disciplina</h3>
        <form method="post">
            <input type="text" name="nome_disciplina" placeholder="Nome da nova disciplina" required>
            <button type="submit" name="adicionar" class="btn btn-editar">Adicionar</button>
        </form>
    </div>

    <div style="text-align: center;">
        <a href="administrador.php" class="btn btn-voltar">Voltar</a>
    </div>
</div>
</body>
</html>

<?php mysqli_close($connection); ?>
