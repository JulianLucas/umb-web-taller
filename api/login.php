<?php
// api/login.php
session_start();
header("Content-Type: application/json; charset=utf-8");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $_SESSION['usuario'] = $data['usuario'] ?? 'invitado';
    echo json_encode(['usuario' => $_SESSION['usuario']]);
    exit();
}
echo json_encode(['usuario' => $_SESSION['usuario'] ?? null]);
