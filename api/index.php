<?php
// api/index.php
header("Content-Type: application/json; charset=utf-8");
header("Access-Control-Allow-Origin: *"); // En producción: restringir al dominio del frontend
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit();
}

require_once __DIR__ . '/modelo.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $item = Modelo::obtener((int)$_GET['id']);
            echo json_encode($item ?: []);
        } else {
            echo json_encode(Modelo::listar());
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if (empty($data['nombre'])) {
            http_response_code(400);
            echo json_encode(['error' => 'nombre requerido']);
            break;
        }
        $id = Modelo::crear($data['nombre'], $data['correo'] ?? '', $data['monto'] ?? 0);
        if ($id) echo json_encode(['msg' => 'creado', 'id' => $id]);
        else { http_response_code(500); echo json_encode(['error'=>'no creado']); }
        break;

    case 'PUT':
        if (!isset($_GET['id'])) { http_response_code(400); echo json_encode(['error'=>'id requerido']); break; }
        $id = (int)$_GET['id'];
        $data = json_decode(file_get_contents('php://input'), true);
        $ok = Modelo::actualizar($id, $data);
        echo json_encode(['ok' => (bool)$ok]);
        break;

    case 'DELETE':
        if (!isset($_GET['id'])) { http_response_code(400); echo json_encode(['error'=>'id requerido']); break; }
        $id = (int)$_GET['id'];
        $ok = Modelo::borrar($id);
        echo json_encode(['ok' => (bool)$ok]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['error'=>'Método no permitido']);
        break;
}
