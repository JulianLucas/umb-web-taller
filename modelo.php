<?php
require_once __DIR__ . '/db.php';

class Modelo {

    static public function listar() {
        global $conexion;
        $sql = "SELECT * FROM donaciones ORDER BY id DESC";
        $stmt = $conexion->query($sql);
        return $stmt->fetchAll();
    }

    public static function crear($nombre, $correo, $monto) {
    global $conexion;

    $stmt = $conexion->prepare("
        INSERT INTO donaciones (nombre, correo, monto, fecha)
        VALUES (:nombre, :correo, :monto, CURRENT_DATE())
    ");

    $stmt->execute([
        ":nombre" => $nombre,
        ":correo" => $correo,
        ":monto" => $monto
    ]);

    return [
        "msg" => "creado",
        "id" => $conexion->lastInsertId()
    ];
}


    // Las otras funciones NO se tocan

}
