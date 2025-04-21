<?php
include("conexao.php");

// Verifica conexão com o banco
if ($connection->connect_error) {
    die("<script>
        alert('Erro ao conectar ao banco de dados.');
        window.location.href = 'index.html';
    </script>");
}

// Verifica se o método é POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.html');
    exit;
}

// Captura e valida os dados
$email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
$cpf = filter_input(INPUT_POST, 'cpf', FILTER_SANITIZE_STRING);
$senha1 = $_POST['nova-senha'] ?? '';
$senha2 = $_POST['confirma-senha'] ?? '';


// Validações
$erros = [];

if (!$email) {
    $erros[] = 'E-mail inválido.';
}

if (strlen($cpf) != 11 || !is_numeric($cpf)) {
    $erros[] = 'CPF inválido (deve conter 11 dígitos numéricos).';
}

// Validação da senha
if (empty($senha1)) {
    $erros[] = 'A senha não pode estar vazia.';
} 

if ($senha1 !== $senha2) {
    $erros[] = 'As senhas não coincidem.';
}

// Se houver erros, exibe e volta
if (!empty($erros)) {
    echo "<script>
        alert('".implode("\\n", $erros)."');
        history.back();
    </script>";
    exit;
}

try {
    // Inicia transação para garantir atomicidade
    $connection->begin_transaction();
    
    // Consulta o usuário na tabela usuarios
    $stmt = $connection->prepare("SELECT id FROM usuarios WHERE email = ? AND cpf = ?");
    if (!$stmt) {
        throw new Exception("Erro na preparação da consulta: " . $connection->error);
    }
    
    $stmt->bind_param("ss", $email, $cpf);
    if (!$stmt->execute()) {
        throw new Exception("Erro na execução da consulta: " . $stmt->error);
    }
    
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        throw new Exception('Combinação de e-mail e CPF não encontrada.');
    }
    
    $usuario = $result->fetch_assoc();
    
    // Atualiza a senha na tabela usuarios
    $novaSenhaCriptografada = password_hash($senha1, PASSWORD_BCRYPT);
    $stmt = $connection->prepare("UPDATE usuarios SET senha = ? WHERE email = ? AND cpf = ?");
    if (!$stmt) {
        throw new Exception("Erro na preparação do update: " . $connection->error);
    }
    
    $stmt->bind_param("si", $novaSenhaCriptografada, $usuario['id']);
    if (!$stmt->execute()) {
        throw new Exception("Erro ao atualizar senha: " . $stmt->error);
    }
    
    // Confirma a transação
    $connection->commit();
    
    echo "<script>
        alert('Senha alterada com sucesso!');
        window.location.href = 'index.html';
    </script>";
    
} catch (Exception $e) {
    // Desfaz a transação em caso de erro
    $connection->rollback();
    
    error_log("Erro na redefinição de senha: " . $e->getMessage());
    
    echo "<script>
        alert('".addslashes($e->getMessage())."');
        history.back();
    </script>";
} finally {
    // Fecha as conexões
    if (isset($stmt)) $stmt->close();
    $connection->close();
}
?>