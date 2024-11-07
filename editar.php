<?php
include 'conexao.php';

$id = $_GET['id'];
$query = $pdo->prepare("SELECT * FROM Tarefas WHERE id = ?");
$query->execute([$id]);
$tarefa = $query->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $custo = $_POST['custo'];
    $data_limite = $_POST['data_limite'];

    // Verificar se o novo nome já existe
    $query = $pdo->prepare("SELECT COUNT(*) FROM Tarefas WHERE nome = ? AND id <> ?");
    $query->execute([$nome, $id]);
    if ($query->fetchColumn() > 0) {
        echo "Erro: já existe uma tarefa com este nome.";
        exit;
    }

    $query = $pdo->prepare("UPDATE Tarefas SET nome = ?, custo = ?, data_limite = ? WHERE id = ?");
    $query->execute([$nome, $custo, $data_limite, $id]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Tarefa</title>
</head>
<body>
<h2>Editar Tarefa</h2>
<form method="POST">
    <label>Nome da Tarefa: <input type="text" name="nome" value="<?= htmlspecialchars($tarefa['nome']) ?>" required></label><br>
    <label>Custo (R$): <input type="number" step="0.01" name="custo" value="<?= $tarefa['custo'] ?>" required></label><br>
    <label>Data Limite: <input type="date" name="data_limite" value="<?= $tarefa['data_limite'] ?>" required></label><br>
    <button type="submit">Salvar Alterações</button>
</form>
</body>
</html>
