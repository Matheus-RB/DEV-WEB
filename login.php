<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = trim($_POST['email']);
  $senha = trim($_POST['senha']);

  try {
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senha'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_nome'] = $user['nome'];
      header("Location: dashboard.php");
      exit();
    } else {
      echo "Email ou senha incorretos!";
    }
  } catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Login</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <form method="POST">
    <label>Email:</label>
    <input type="email" name="email" required>
    <label>Senha:</label>
    <input type="password" name="senha" required>
    <button type="submit">Entrar</button>
  </form>
</body>

</html>