<?php
$host = 'diegoserver4444.mysql.database.azure.com';
$dbname = 'estagio';
$user = 'diego';
$password = 'Teste#123';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
