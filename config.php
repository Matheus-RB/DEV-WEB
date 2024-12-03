<?php
$servername = "localhost";
$username = "root"; // Alterar conforme necessário
$password = ""; // Alterar conforme necessário
$dbname = "login_system";

try {
  $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
  die("Erro na conexão: " . $e->getMessage());
}
