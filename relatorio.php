<?php
session_start();
include("conexao.php");

if (!isset($_SESSION['admin_id'])) {
    header("Location: index.html");
    exit();
}

$adminId = $_SESSION['admin_id'];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório - Admin</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; }
        h1 { text-align: center; }
        .form-container { max-width: 800px; margin: 0 auto; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        select, input[type="submit"] { padding: 8px; margin-top: 10px; }
    </style>
</head>
<body>
    <h1>Relatório Geral dos Alunos</h1>
    <div class="form-container">
        <form method="GET">
            <label for="turma">Filtrar por Turma:</label><br>
            <select name="turma" id="turma">
                <option value="">Todas as Turmas</option>
                <?php
                $turmas = mysqli_query($connection, "SELECT id, nome FROM turmas");
                while ($t = mysqli_fetch_assoc($turmas)) {
                    $selected = isset($_GET['turma']) && $_GET['turma'] == $t['id'] ? "selected" : "";
                    echo "<option value='" . $t['id'] . "' $selected>" . $t['nome'] . "</option>";
                }
                ?>
            </select><br>
            <input type="submit" value="Filtrar">
        </form>

        <?php
        $where = "";
        if (!empty($_GET['turma'])) {
            $turma_id = intval($_GET['turma']);
            $where = "WHERE turmas.id = $turma_id";
        }

        $sql = "SELECT 
                    alunos.matricula,
                    usuarios.nome AS aluno,
                    disciplinas.nome AS disciplina,
                    turmas.nome AS turma,
                    notas.nota,
                    notas.dataL
                FROM notas
                INNER JOIN alunos ON notas.fk_aluno = alunos.id
                INNER JOIN usuarios ON alunos.fk_user = usuarios.id
                INNER JOIN disciplinas ON notas.fk_disc = disciplinas.id
                INNER JOIN turma_alunos ON turma_alunos.fk_aluno = alunos.id
                INNER JOIN turmas ON turma_alunos.fk_turma = turmas.id
                $where
                ORDER BY turma, aluno, disciplina";

        $resultado = mysqli_query($connection, $sql);

        if ($resultado && mysqli_num_rows($resultado) > 0) {
            echo "<table>";
            echo "<tr>
                    <th>Matrícula</th>
                    <th>Aluno</th>
                    <th>Disciplina</th>
                    <th>Turma</th>
                    <th>Nota</th>
                    <th>Data</th>
                  </tr>";
            while ($row = mysqli_fetch_assoc($resultado)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row['matricula']) . "</td>
                        <td>" . htmlspecialchars($row['aluno']) . "</td>
                        <td>" . htmlspecialchars($row['disciplina']) . "</td>
                        <td>" . htmlspecialchars($row['turma']) . "</td>
                        <td>" . htmlspecialchars($row['nota']) . "</td>
                        <td>" . htmlspecialchars($row['dataL']) . "</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            echo "<p>Nenhum resultado encontrado.</p>";
        }

        mysqli_close($connection);
        ?>
    </div>
</body>
</html>
