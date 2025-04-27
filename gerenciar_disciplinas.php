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

// Processa atualização de disciplina (AGORA também atualizando descrição e imagem)
if (isset($_POST['editar'])) {
    $disciplina_id = $_POST['disciplina_id'];
    $novo_nome = mysqli_real_escape_string($connection, $_POST['novo_nome']);
    $nova_descricao = mysqli_real_escape_string($connection, $_POST['nova_descricao']);

    $sql_update = "UPDATE disciplinas SET nome = '$novo_nome', descricao = '$nova_descricao'";

    // Se enviou nova imagem
    if (isset($_FILES['nova_imagem']) && $_FILES['nova_imagem']['error'] == 0) {
        $imagem_nome = basename($_FILES['nova_imagem']['name']);
        $imagem_caminho = "img/" . $imagem_nome;
        $imagem_tmp = $_FILES['nova_imagem']['tmp_name'];

        if (move_uploaded_file($imagem_tmp, $imagem_caminho)) {
            $sql_update .= ", imagem = '$imagem_caminho'";
        } else {
            echo "<script>alert('Erro ao fazer upload da nova imagem.');</script>";
        }
    }

    $sql_update .= " WHERE id = $disciplina_id";

    mysqli_query($connection, $sql_update);
    header("Location: gerenciar_disciplinas.php");
    exit;
}

// Processa adição de nova disciplina
if (isset($_POST['adicionar'])) {
    $nome_disciplina = mysqli_real_escape_string($connection, $_POST['nome_disciplina']);
    $descricao = mysqli_real_escape_string($connection, $_POST['descricao']);
    
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == 0) {
        $imagem_nome = basename($_FILES['imagem']['name']);
        $imagem_caminho = "img/" . $imagem_nome;
        $imagem_tmp = $_FILES['imagem']['tmp_name'];

        if (move_uploaded_file($imagem_tmp, $imagem_caminho)) {
            $sql_insert = "INSERT INTO disciplinas (nome, descricao, imagem) VALUES ('$nome_disciplina', '$descricao', '$imagem_caminho')";
            mysqli_query($connection, $sql_insert);
        } else {
            echo "<script>alert('Erro ao fazer upload da imagem.');</script>";
        }
    } else {
        echo "<script>alert('Imagem não enviada ou com erro.');</script>";
    }

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
    <link rel="stylesheet" href="style/gerTurma.css">
</head>
<body>
<div class="container">
    <h1>Gerenciamento de Disciplinas</h1>

    <?php if (mysqli_num_rows($resultado) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Imagem Atual</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($disciplina = mysqli_fetch_assoc($resultado)): ?>
                    <tr>
                        <form method="post" enctype="multipart/form-data" class="inline-form">
                            <td>
                                <input type="hidden" name="disciplina_id" value="<?php echo $disciplina['id']; ?>">
                                <input type="text" name="novo_nome" value="<?php echo htmlspecialchars($disciplina['nome']); ?>">
                            </td>
                            <td>
                                <textarea name="nova_descricao" rows="2" cols="30"><?php echo htmlspecialchars($disciplina['descricao']); ?></textarea>
                            </td>
                            <td>
                                <?php if (!empty($disciplina['imagem'])): ?>
                                    <img src="<?php echo $disciplina['imagem']; ?>" alt="Imagem da disciplina" width="60"><br>
                                <?php else: ?>
                                    Sem imagem
                                <?php endif; ?>
                                <input type="file" name="nova_imagem" accept="image/*">
                            </td>
                            <td class="acoes">
                                <button type="submit" name="editar" class="btn btn-editar">Salvar</button>
                                <br><br>
                                <form method="post" class="inline-form" onsubmit="return confirm('Tem certeza que deseja excluir esta disciplina?');">
                                    <input type="hidden" name="disciplina_id" value="<?php echo $disciplina['id']; ?>">
                                    <button type="submit" name="deletar" class="btn btn-excluir">Excluir</button>
                                </form>
                            </td>
                        </form>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>Nenhuma disciplina cadastrada.</p>
    <?php endif; ?>

    <div class="form-adicionar">
        <h3>Adicionar Nova Disciplina</h3>
        <form method="post" enctype="multipart/form-data">
            <input type="text" name="nome_disciplina" placeholder="Nome da nova disciplina" required><br><br>
            <textarea name="descricao" placeholder="Descrição da disciplina" rows="4" cols="50" required></textarea><br><br>
            <input type="file" name="imagem" accept="image/*" required><br><br>
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
