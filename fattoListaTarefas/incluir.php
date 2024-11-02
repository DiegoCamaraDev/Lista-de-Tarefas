<?php
include 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $custo = $_POST['custo'];
    $data_limite = $_POST['data_limite'];

    // Validação de nome único
    $query = $pdo->prepare("SELECT COUNT(*) FROM Tarefas WHERE nome = ?");
    $query->execute([$nome]);
    if ($query->fetchColumn() > 0) {
        echo "Erro: já existe uma tarefa com este nome.";
        exit;
    }

    // Definir a nova ordem
    $ordem_query = $pdo->query("SELECT MAX(ordem) + 1 FROM Tarefas");
    $ordem = $ordem_query->fetchColumn() ?: 1;

    $query = $pdo->prepare("INSERT INTO Tarefas (nome, custo, data_limite, ordem) VALUES (?, ?, ?, ?)");
    $query->execute([$nome, $custo, $data_limite, $ordem]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Incluir Tarefa</title>
</head>
<body>
<h2>Incluir Tarefa</h2>
<form method="POST">
    <label>Nome da Tarefa: <input type="text" name="nome" required></label><br>
    <label>Custo (R$): <input type="number" step="0.01" name="custo" required></label><br>
    <label>Data Limite: <input type="date" name="data_limite" required></label><br>
    <button type="submit">Incluir</button>
</form>
</body>
</html>
