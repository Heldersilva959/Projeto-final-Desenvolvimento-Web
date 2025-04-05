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
        button {
            background-color: dodgerblue;
            color: white;
            border: none;
            padding: 8px 12px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 5px;
        }
        button:hover {
            background-color: #1e90ff;
        }
    </style>
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
    a.id = '$aluno_id' " ;

$consulta = mysqli_query($connection, $sql); 

if ($consulta) { 

    if (mysqli_num_rows($consulta) >= 0) {
        
        echo "<table border='1'>";
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
<div style="text-align: center;">
        <button onclick="window.location.href='logout.php'">Voltar</button>
    </div>
</body>
</html>


