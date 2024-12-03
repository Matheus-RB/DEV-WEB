<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Bem-vindo</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <h1>Bem-vindo, <?php echo htmlspecialchars($_SESSION['user_nome']); ?>!</h1>
  <a href="logout.php">Sair</a>
</body>

</html>