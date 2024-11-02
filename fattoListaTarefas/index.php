<?php
include 'conexao.php';

// Obter todas as tarefas ordenadas pelo campo "ordem"
$query = $pdo->query("SELECT * FROM Tarefas ORDER BY ordem");
$tarefas = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Lista de Tarefas</title>
    <style>
        .tarefa-alta { background-color: yellow; }
    </style>
</head>
<body>

<h2>Lista de Tarefas</h2>

<table border="1">
    <tr>
        <th>Identificador</th>
        <th>Nome da Tarefa</th>
        <th>Custo (R$)</th>
        <th>Data Limite</th>
        <th>Ações</th>
    </tr>

    <?php foreach ($tarefas as $tarefa): ?>
        <tr class="<?= $tarefa['custo'] >= 1000 ? 'tarefa-alta' : '' ?>">
            <td><?= $tarefa['id'] ?></td>
            <td><?= htmlspecialchars($tarefa['nome']) ?></td>
            <td><?= number_format($tarefa['custo'], 2, ',', '.') ?></td>
            <td><?= date('d/m/Y', strtotime($tarefa['data_limite'])) ?></td>
            <td>
                <!-- Ações de edição e exclusão -->
                <a href="editar.php?id=<?= $tarefa['id'] ?>">✏️</a>
                <a href="excluir.php?id=<?= $tarefa['id'] ?>" onclick="return confirm('Confirma exclusão?')">❌</a>

                <!-- Botões de reordenamento -->
                <?php if ($tarefa !== reset($tarefas)): ?>
                    <a href="reordenar.php?id=<?= $tarefa['id'] ?>&acao=subir">⬆️</a>
                <?php endif; ?>
                <?php if ($tarefa !== end($tarefas)): ?>
                    <a href="reordenar.php?id=<?= $tarefa['id'] ?>&acao=descer">⬇️</a>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<br>
<a href="incluir.php">Incluir Nova Tarefa</a>

</body>
</html>
