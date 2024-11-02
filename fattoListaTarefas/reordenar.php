<?php
include 'conexao.php';

$id = $_GET['id'] ?? null;
$acao = $_GET['acao'] ?? null;

if ($id && ($acao === 'subir' || $acao === 'descer')) {
    // Obter a tarefa atual
    $query = $pdo->prepare("SELECT * FROM Tarefas WHERE id = ?");
    $query->execute([$id]);
    $tarefa = $query->fetch(PDO::FETCH_ASSOC);
    $ordemAtual = $tarefa['ordem'];

    // Identificar a tarefa vizinha para troca de posição
    if ($acao === 'subir') {
        $queryVizinha = $pdo->prepare("SELECT * FROM Tarefas WHERE ordem < ? ORDER BY ordem DESC LIMIT 1");
        $queryVizinha->execute([$ordemAtual]);
    } else {
        $queryVizinha = $pdo->prepare("SELECT * FROM Tarefas WHERE ordem > ? ORDER BY ordem ASC LIMIT 1");
        $queryVizinha->execute([$ordemAtual]);
    }

    $tarefaVizinha = $queryVizinha->fetch(PDO::FETCH_ASSOC);

    // Se houver uma tarefa para trocar posição
    if ($tarefaVizinha) {
        $ordemVizinha = $tarefaVizinha['ordem'];

        // Atualizar a ordem da tarefa atual para um valor temporário
        $pdo->prepare("UPDATE Tarefas SET ordem = ? WHERE id = ?")->execute([0, $id]); // Atribuindo um valor temporário

        // Trocar as ordens das duas tarefas
        $pdo->prepare("UPDATE Tarefas SET ordem = ? WHERE id = ?")->execute([$ordemAtual, $tarefaVizinha['id']]);
        $pdo->prepare("UPDATE Tarefas SET ordem = ? WHERE id = ?")->execute([$ordemVizinha, $id]);
    }

    // Reorganizar as ordens para garantir que sejam únicas
    $queryTarefas = $pdo->query("SELECT * FROM Tarefas ORDER BY ordem");
    $tarefas = $queryTarefas->fetchAll(PDO::FETCH_ASSOC);

    foreach ($tarefas as $index => $tarefa) {
        // Atualiza a ordem para valores únicos
        $novaOrdem = $index + 1; // A ordem começa em 1
        $pdo->prepare("UPDATE Tarefas SET ordem = ? WHERE id = ?")->execute([$novaOrdem, $tarefa['id']]);
    }
}

header("Location: index.php");
exit;
