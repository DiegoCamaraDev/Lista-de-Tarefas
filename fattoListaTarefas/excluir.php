<?php
include 'conexao.php';

$id = $_GET['id'] ?? null;

if ($id) {
    // Confirmação de exclusão
    if (isset($_POST['confirmar']) && $_POST['confirmar'] === 'Sim') {
        $query = $pdo->prepare("DELETE FROM Tarefas WHERE id = ?");
        $query->execute([$id]);
        header("Location: index.php");
        exit;
    }
    // Cancelar exclusão
    if (isset($_POST['confirmar']) && $_POST['confirmar'] === 'Não') {
        header("Location: index.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Excluir Tarefa</title>
</head>
<body>

<h2>Confirmação de Exclusão</h2>
<p>Você realmente deseja excluir esta tarefa?</p>

<form method="POST">
    <button type="submit" name="confirmar" value="Sim">Sim</button>
    <button type="submit" name="confirmar" value="Não">Não</button>
</form>

</body>
</html>
