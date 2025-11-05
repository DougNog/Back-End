<?php
// public/index.php - simple router / front controller
echo"";
require_once __DIR__ . '/../src/Controller/BebidaController.php';

$controller = new BebidaController();

// Basic routing via 'action' GET/POST param
$action = $_REQUEST['action'] ?? 'index';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($action === 'create') {
        $controller->create($_POST['nome'], $_POST['categoria'], $_POST['volume'], $_POST['valor'], $_POST['qtde']);
        header('Location: /'); exit;
    } elseif ($action === 'delete') {
        $controller->delete($_POST['nome']);
        header('Location: /'); exit;
    }
}

// Render views
if ($action === 'index') {
    $bebidas = $controller->index();
    include __DIR__ . '/../views/list.php';
} elseif ($action === 'form') {
    include __DIR__ . '/../views/form.php';
} else {
    http_response_code(404);
    echo 'Página não encontrada';
}
