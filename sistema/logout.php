<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="style.css">
   <title>Logout</title>
</head>
<body>
   <div>
      <h1>Erro</h1>
      <p>Dados incorretos. Tente novamente.</p>
      <a href="index.php">Voltar para a página de login</a>
<?php
session_start();
session_destroy();
exit();
?>
</div>
</body>
</html>