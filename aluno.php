<?php 
session_start();
if (!isset($_SESSION['aluno_id'])) {
    header("Location: index.html");
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
    <H1> BOLETIM DO ALUNO:   </H1>
    <div>
    <?php
include("conexao.php");

$aluno_id = $_SESSION['aluno_id'];

$sql = "SELECT 
    a.matricula, 
    u.nome AS aluno, 
    t.nome AS turma,
    d.nome AS disciplina, 
    n.nota, 
    n.dataL
FROM 
    notas n
INNER JOIN alunos a ON n.fk_aluno = a.id
INNER JOIN usuarios u ON a.fk_user = u.id
INNER JOIN disciplinas d ON n.fk_disc = d.id
LEFT JOIN turma_alunos ta ON a.id = ta.fk_aluno
LEFT JOIN turmas t ON ta.fk_turma = t.id
WHERE 
    a.id =  $aluno_id"; 

$consulta = mysqli_query($connection, $sql); 

if ($consulta) { 

    if (mysqli_num_rows($consulta) >= 0) {
        
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
            echo "<td>" . $row['matricula'] . "</td>";
            echo "<td>" . $row['aluno'] . "</td>";
            echo "<td>" . $row['turma'] . "</td>";
            echo "<td>" . $row['disciplina'] . "</td>";
            echo "<td>" . $row['nota'] . "</td>";
            echo "<td>" . $row['dataL'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>"; 
    } else {
        echo "Nenhum resultado encontrado.";
    }
} else {
    echo "Erro na consulta: " . mysqli_errno($connection) . " - " . mysqli_error($connection);
}

// Fechando a conexão
mysqli_close($connection);
?>

    </div>
<br><br>
<form class="deslogar" action="index.html" method="post">
        <button class="botao" type="submit">Deslogar</button> 
    </form>
</body>
</html>


