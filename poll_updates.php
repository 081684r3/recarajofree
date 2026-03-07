<?php
header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');

// Archivo para almacenar acciones pendientes
$actionsFile = __DIR__ . '/pending_actions.json';

function getNextAction()
{
    global $actionsFile;
    if (!file_exists($actionsFile)) return null;

    $actions = json_decode(file_get_contents($actionsFile), true);
    if (empty($actions)) return null;

    $action = array_shift($actions);
    file_put_contents($actionsFile, json_encode($actions));
    return $action;
}

function clearActions()
{
    global $actionsFile;
    file_put_contents($actionsFile, json_encode([]));
}

// Limpiar acciones si se solicita
if (isset($_GET['clear'])) {
    clearActions();
    echo json_encode(['status' => 'cleared']);
    exit;
}

// Verificar si hay acciones pendientes
$nextAction = getNextAction();
if ($nextAction) {
    echo json_encode([
        'status' => 'ok',
        'offset' => 0, // Dummy offset since we're not using getUpdates
        'data' => $nextAction
    ]);
} else {
    echo json_encode(['status' => 'ok', 'offset' => 0]);
}
?>
