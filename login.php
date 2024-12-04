<?php
session_start();
require 'config.php';

$errorMessage = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = trim($_POST['email']);
  $senha = trim($_POST['senha']);

  if (empty($email) || empty($senha)) {
    $errorMessage = "Por favor, preencha todos os campos!";
  } else {
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
        $errorMessage = "Email ou senha incorretos!";
      }
    } catch (PDOException $e) {
      $errorMessage = "Erro ao processar o login: " . $e->getMessage();
    }
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
  <div class="login_container">
    <form method="POST">
      <?php if (!empty($errorMessage)) : ?>
        <div class="error_message">
          <?php echo htmlspecialchars($errorMessage); ?>
        </div>
      <?php endif; ?>
      <label>Email:</label>
      <input type="email" name="email" required>
      <label>Senha:</label>
      <input type="password" name="senha" required>
      <button type="submit">Entrar</button>
    </form>
  </div>
</body>

</html>