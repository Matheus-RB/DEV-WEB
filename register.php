<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nome = trim($_POST['nome']);
  $email = trim($_POST['email']);
  $senha = trim($_POST['senha']);
  $confirmarSenha = trim($_POST['confirmar_senha']);

  $errors = [];

  if (empty($nome)) {
    $errors[] = "O campo Nome é obrigatório.";
  }

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "O campo Email não é válido.";
  }

  if (strlen($senha) < 8) {
    $errors[] = "A senha deve ter pelo menos 8 caracteres.";
  }

  if ($senha !== $confirmarSenha) {
    $errors[] = "As senhas não coincidem.";
  }

  if (empty($errors)) {
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    try {
      $stmt = $conn->prepare("INSERT INTO users (nome, email, senha) VALUES (:nome, :email, :senha)");
      $stmt->bindParam(':nome', $nome);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':senha', $senhaHash);
      $stmt->execute();

      echo "<script type='text/javascript'>alert('Cadastro realizado com sucesso!');</script>";
      header("Location: login.php");
      exit();
    } catch (PDOException $e) {
      echo "<script type='text/javascript'>alert('Erro ao cadastrar: " . $e->getMessage() . "');</script>";
    }
  } else {
    echo "<script type='text/javascript'>";
    echo "alert('" . implode("\\n", $errors) . "');";
    echo "</script>";
  }
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Cadastro</title>
  <link rel="stylesheet" href="styles.css">
</head>

<body>
  <div class="register_container">
    <form method="POST">
      <label>Nome Completo:</label>
      <input type="text" name="nome" required>
      <label>Email:</label>
      <input type="email" name="email" required>
      <div class="senhas">
        <div>
          <label>Senha:</label>
          <input type="password" name="senha" required>
        </div>
        <div>
          <label>Confirmar Senha:</label>
          <input type="password" name="confirmar_senha" required>
        </div>
      </div>
      <button type="submit">Cadastrar</button>
    </form>
  </div>
</body>

</html>