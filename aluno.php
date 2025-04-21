<?php 
session_start();
if (!isset($_SESSION['aluno_id'])) {
    header("Location: index.html");
    exit;
}
else{
$alunoId = ($_SESSION['aluno_id']); // segurança contra SQL injection
$sql = "SELECT tipo FROM usuarios WHERE id = $alunoId";
$consulta = mysqli_query($connection, $sql);
if ($consulta) {
    $row = mysqli_fetch_assoc($consulta);
    $tipo = $row['tipo'];
    if ($tipo != 'Aluno') {
        header("Location: index.html");
        exit;
    }
} else {
    die("Erro ao verificar tipo de usuário: " . mysqli_error($connection));
}
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Aluno</title>
    <link rel="stylesheet" href="Style/aluno.css">
</head>
<body>
    <h1>BOLETIM DO ALUNO:</h1>
    <div>
        <?php
        include("conexao.php");

        $sql = "SELECT 
                    a.matricula, 
                    u.nome AS aluno, 
                    t.nome AS turma,
                    d.nome AS disciplina, 
                    n.nota, 
                    DATE_FORMAT(n.dataL, '%d/%m/%Y') AS data_formatada
                FROM 
                    notas n
                INNER JOIN alunos a ON n.fk_aluno = a.id
                INNER JOIN usuarios u ON a.fk_user = u.id
                INNER JOIN disciplinas d ON n.fk_disc = d.id
                LEFT JOIN turma_alunos ta ON a.id = ta.fk_aluno
                LEFT JOIN turmas t ON ta.fk_turma = t.id
                WHERE 
                    u.id = $alunoId"; 

        $consulta = mysqli_query($connection, $sql); 

        if ($consulta && mysqli_num_rows($consulta) > 0) {
            echo "<table class='tabela-boletim' border='1'>";
            echo "<tr>
                    <th>Matrícula</th>
                    <th>Aluno</th>
                    <th>Turma</th>
                    <th>Disciplina</th>
                    <th>Nota</th>
                    <th>Data de Lançamento</th>
                  </tr>";

            while ($row = mysqli_fetch_assoc($consulta)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['matricula']) . "</td>";
                echo "<td>" . htmlspecialchars($row['aluno']) . "</td>";
                echo "<td>" . htmlspecialchars($row['turma']) . "</td>";
                echo "<td>" . htmlspecialchars($row['disciplina']) . "</td>";
                echo "<td>" . htmlspecialchars($row['nota']) . "</td>";
                echo "<td>" . htmlspecialchars($row['data_formatada']) . "</td>";
                echo "</tr>";
            }

            echo "</table>"; 
        } else {
            echo "<p>Nenhuma nota encontrada para este aluno.</p>";
        }

        mysqli_close($connection);
        ?>
    </div>

    <br><br>
    <form class="deslogar" action="index.html" method="post">
        <button class="botao" type="submit">Deslogar</button> 
    </form>
</body>
</html>
