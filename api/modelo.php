<?php
// api/modelo.php
require_once __DIR__ . '/db.php';

class Modelo {
    // LISTAR
    static public function listar() {
        global $conexion;
        $sql = "SELECT * FROM donaciones ORDER BY id DESC";
        $stmt = $conexion->query($sql);
        return $stmt->fetchAll();
    }

    // CREAR (usa AUTO_INCREMENT en BD: si tu tabla ya tiene AUTO_INCREMENT no debes asignar id manualmente)
    static public function crear($nombre, $correo, $monto) {
        global $conexion;
        $sql = "INSERT INTO donaciones (nombre, correo, monto) VALUES (:nombre, :correo, :monto)";
        $stmt = $conexion->prepare($sql);
        $ok = $stmt->execute([
            ':nombre' => $nombre,
            ':correo' => $correo,
            ':monto' => $monto
        ]);
        return $ok ? $conexion->lastInsertId() : false;
    }

    // ACTUALIZAR
    static public function actualizar($id, $data) {
        global $conexion;
        $fields = [];
        $params = [];
        if (isset($data['nombre'])) { $fields[] = "nombre = :nombre"; $params[':nombre'] = $data['nombre']; }
        if (isset($data['correo'])) { $fields[] = "correo = :correo"; $params[':correo'] = $data['correo']; }
        if (isset($data['monto'])) { $fields[] = "monto = :monto"; $params[':monto'] = $data['monto']; }
        if (empty($fields)) return false;
        $params[':id'] = $id;
        $sql = "UPDATE donaciones SET " . implode(',', $fields) . " WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        return $stmt->execute($params);
    }

    // BORRAR
    static public function borrar($id) {
        global $conexion;
        $sql = "DELETE FROM donaciones WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }

    // OBTENER UNO
    static public function obtener($id) {
        global $conexion;
        $sql = "SELECT * FROM donaciones WHERE id = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
}
