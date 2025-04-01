<?php 
session_start();
if (!isset($_SESSION['aluno_id'])) {
    header("Location: login1.php");
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página do Aluno</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <H1> BOLETIM DO ALUNO:   </H1>
</body>
</html>

<?php
include("conexao.php");

$aluno_id = $_SESSION['aluno_id'];

$sql = "SELECT 
    alunos.matricula, 
    usuarios.nome AS aluno, 
    disciplinas.nome AS disciplina, 
    notas.nota, 
    notas.dataL
FROM 
    notas
INNER JOIN alunos ON notas.fk_aluno = alunos.id
INNER JOIN usuarios ON alunos.fk_user = usuarios.id
INNER JOIN disciplinas ON notas.fk_disc = disciplinas.id
WHERE 
    alunos.id = '$aluno_id' " ;

$consulta = mysqli_query($connection, $sql); 

if ($consulta) { 

    if (mysqli_num_rows($consulta) >= 0) {
        
        echo "<table border='1'>";
        echo "<tr>
                <th>Matrícula</th>
                <th>Aluno</th>
                <th>Disciplina</th>
                <th>Nota</th>
                <th>Data de Lançamento</th>
              </tr>";
        
        
        
        while ($row = mysqli_fetch_assoc($consulta)) {
            echo "<tr>";
            echo "<td>" . $row['matricula'] . "</td>";
            echo "<td>" . $row['aluno'] . "</td>";
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

