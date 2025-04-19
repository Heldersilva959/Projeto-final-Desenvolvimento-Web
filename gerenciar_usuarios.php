<?php
include("conexao.php");
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.html");
    exit;
}
else {
    $admin_id = $_SESSION['admin_id'];
}

// Verifica se o usuário é um administrador
// Processa a exclusão de usuário se houver requisição
if (isset($_POST['deletar'])) {
    $usuario_id = $_POST['usuario_id'];
    
    // Primeiro verifica se não está tentando se auto-deletar
    if ($usuario_id != $admin_id) {
        // Exclui o usuário
        $sql_delete = "DELETE FROM usuarios WHERE id = $usuario_id";
        mysqli_query($connection, $sql_delete);
        
        // Redireciona para a mesma página para atualizar a lista
        header("Location: gerenciar_usuarios.php");
    }
}


// Consulta todos os usuários exceto o administrador logado
$sql = "SELECT id, nome, email, idade, cpf, tipo FROM usuarios WHERE id != $admin_id ORDER BY nome";
$resultado = mysqli_query($connection, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerenciar Usuários</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 80%;
            margin: 20px auto;
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .acoes {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
        .btn-editar {
            background-color: #4CAF50;
            color: white;
        }
        .btn-editar:hover {
            background-color: #45a049;
        }
        .btn-excluir {
            background-color: #f44336;
            color: white;
        }
        .btn-excluir:hover {
            background-color: #d32f2f;
        }
        .btn-voltar {
            background-color: #2196F3;
            color: white;
            padding: 10px 15px;
            display: inline-block;
            margin-top: 20px;
        }
        .btn-voltar:hover {
            background-color: #0b7dda;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gerenciamento de Usuários</h1>
        
        <?php if (mysqli_num_rows($resultado) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Idade</th>
                        <th>CPF</th>
                        <th>Tipo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($usuario = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($usuario['nome']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['idade']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['cpf']); ?></td>
                            <td><?php echo htmlspecialchars($usuario['tipo']); ?></td>
                            <td class="acoes">
                                <a href="editar_usuario.php?id=<?php echo $usuario['id']; ?>" class="btn btn-editar">Editar</a>
                                <form method="post" style="display: inline;">
                                    <input type="hidden" name="usuario_id" value="<?php echo $usuario['id']; ?>">
                                    <button type="submit" name="deletar" class="btn btn-excluir" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Nenhum usuário cadastrado.</p>
        <?php endif; ?>
        
        <div style="text-align: center;">
            <a href="administrador.php" class="btn btn-voltar">Voltar</a>
        </div>
    </div>
</body>
</html>

<?php mysqli_close($connection); ?>