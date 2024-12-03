<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nome = trim($_POST['nome']);
  $email = trim($_POST['email']);
  $senha = trim($_POST['senha']);
  $confirmarSenha = trim($_POST['confirmar_senha']);

  if (filter_var($email, FILTER_VALIDATE_EMAIL) && strlen($senha) >= 8 && $senha === $confirmarSenha) {
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    try {
      $stmt = $conn->prepare("INSERT INTO users (nome, email, senha) VALUES (:nome, :email, :senha)");
      $stmt->bindParam(':nome', $nome);
      $stmt->bindParam(':email', $email);
      $stmt->bindParam(':senha', $senhaHash);
      $stmt->execute();
      echo "Cadastro realizado com sucesso!";
      header("Location: login.php");
    } catch (PDOException $e) {
      echo "Erro ao cadastrar: " . $e->getMessage();
    }
  } else {
    echo "Por favor, preencha todos os campos corretamente!";
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
  <form method="POST">
    <label>Nome Completo:</label>
    <input type="text" name="nome" required>
    <label>Email:</label>
    <input type="email" name="email" required>
    <label>Senha:</label>
    <input type="password" name="senha" required>
    <label>Confirmar Senha:</label>
    <input type="password" name="confirmar_senha" required>
    <button type="submit">Cadastrar</button>
  </form>
</body>

</html>