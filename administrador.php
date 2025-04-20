<?php 
include_once("conexao.php");
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.html");
}
else {
    $adminId = $_SESSION['admin_id'];
}
// Verifica se o usuário é um administrador

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Professor</title>
    <link rel="stylesheet" href="Style/admin.css">
</head>
<body>
    <h1>Página do Administrador</h1>
    <p>Bem-vindo à página do administrador! Aqui você pode gerenciar suas atividades.</p>

    <form action="notas_adm.php" method="post">
        <button type="submit">Gerenciar Notas dos Alunos</button>
    </form>
    <form action="cadastro.php" method="post">
        <button type="submit">Cadastrar Novos Usuários</button> 
    </form>
    <form action="gerenciar_usuarios.php" method="post">
        <button type="submit">Gerenciar alunos e parceiros</button>
    </form>

    <form action="gerenciar_turma.php" method="post">
        <button type="submit">gerenciar turmas</button>
    </form>

    <form action="relatorio.php" method="post"> 
        <button type="submit">Gerar Relatório</button>
    </form>

    <form action="index.html" method="post">
        <button type="submit">Deslogar</button> 
    </form>
   
</body>
</html>

