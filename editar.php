
<?php
session_start();
include("conexao.php");

// Verifica se os dados foram enviados via POST
if (isset($_POST['nota_id']) && isset($_POST['nova_nota'])) {
    $nota_id = $_POST['nota_id'];
    $nova_nota = $_POST['nova_nota'];

    //atualizar a nota
    $sql = "UPDATE notas SET nota = $nova_nota WHERE id = $nota_id";

    // Executar a query 
    if (mysqli_query($connection, $sql)) {
        echo "Nota atualizada com sucesso";
        header("Location: notas.php");
    } else {
        echo "Erro ao atualizar nota: " . mysqli_error($connection);
    }
} 

// Fechar conexão
mysqli_close($connection);
?>