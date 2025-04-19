<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagina do professor</title>
    <link rel="stylesheet" href="Style/notas.css">
    <style>
        
    </style>
</head>
<body>
    <h1>BOLETIM GERAL DOS ALUNOS</h1>
    <br> <br> 
    <div class="containerTable">
    <?php
include("conexao.php");
session_start();
$sql = "SELECT alunos.matricula, 
    usuarios.nome AS aluno, 
    disciplinas.nome AS disciplina, 
    notas.nota, 
    notas.dataL,
    notas.id AS nota_id
FROM 
    notas
INNER JOIN alunos ON notas.fk_aluno = alunos.id
INNER JOIN usuarios ON alunos.fk_user = usuarios.id
INNER JOIN disciplinas ON notas.fk_disc = disciplinas.id
ORDER BY 
    alunos.matricula DESC,
    disciplinas.nome;
    ";

// Executando a consulta
$consulta = mysqli_query($connection, $sql); 

if ($consulta) {    
    // Verificando se há resultados
    if (mysqli_num_rows($consulta) > 0) {
        // Iniciando a tabela HTML
        echo "<table border='1'>";
        echo "<tr>
                <th>Matrícula</th>
                <th>Aluno</th>
                <th>Disciplina</th>
                <th>Nota</th>
                <th>Data</th>
                <th>Alterar Nota</th>
              </tr>";
        
        // Iterando sobre os resultados e preenchendo a tabela
        while ($row = mysqli_fetch_assoc($consulta)) {
         
            echo "<tr>";
            echo "<td>" . $row['matricula'] . "</td>";
            echo "<td>" . $row['aluno'] . "</td>";
            echo "<td>" . $row['disciplina'] . "</td>";
            echo "<td>" . $row['nota'] . "</td>";
            echo "<td>" . $row['dataL'] . "</td>";
            echo "<td>
                            <form action='editar.php' method='post'>
                                <input type='hidden' name='nota_id' value='" . $row['nota_id'] . "'> 
                                <input type='text' name='nova_nota' value='" . $row['nota'] . "'>
                                <button type='submit'>Atualizar</button>
                            </form>
                </td>";
            echo "</tr>";
        }
        
        echo "</table>"; // Fechando a tabela
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
    <br> <br>
    <div style="text-align: center;">
        <button onclick="window.location.href='professor.php'">Voltar</button>
    </div>
</body>

</html>

