<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Methods: *");

require_once 'modelo.php';

$metodo = $_SERVER['REQUEST_METHOD'];

switch ($metodo) {

    case 'GET':
        echo json_encode(Modelo::listar());
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(Modelo::crear(
            $data["nombre"],
            $data["correo"],
            $data["monto"]
        ));
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(Modelo::actualizar(
            $data["id"],
            $data["nombre"],
            $data["correo"],
            $data["monto"]
        ));
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"), true);
        echo json_encode(Modelo::eliminar($data["id"]));
        break;

    default:
        echo json_encode(["error" => "Método no permitido"]);
        break;
}
