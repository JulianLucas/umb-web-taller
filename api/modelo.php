<?php 
require_once __DIR__ . '/db.php';

class Modelo {

    private static $db;

    // Obtener conexión sin usar "global"
    private static function getConexion() {
        if (!self::$db) {
            global $conexion; 
            self::$db = $conexion;
        }
        return self::$db;
    }

    // ================================
    // 🟦 LISTAR DONACIONES
    // ================================
    public static function listar() {
        try {
            $db = self::getConexion();
            $sql = "SELECT * FROM donaciones ORDER BY id DESC";
            $stmt = $db->query($sql);
            return $stmt->fetchAll();

        } catch (PDOException $e) {
            return [
                "error" => "Error al listar: " . $e->getMessage()
            ];
        }
    }

    // ================================
    // 🟩 CREAR DONACIÓN
    // ================================
    public static function crear($nombre, $correo, $monto) {

        // Validaciones simples
        if (empty($nombre) || empty($correo) || empty($monto)) {
            return ["error" => "Todos los campos son obligatorios"];
        }

        try {
            $db = self::getConexion();

            $stmt = $db->prepare("
                INSERT INTO donaciones (nombre, correo, monto, fecha)
                VALUES (:nombre, :correo, :monto, CURRENT_DATE())
            ");

            $stmt->execute([
                ":nombre" => $nombre,
                ":correo" => $correo,
                ":monto"  => $monto
            ]);

            return [
                "msg" => "creado",
                "id"  => $db->lastInsertId()
            ];

        } catch (PDOException $e) {
            return [
                "error" => "Error al crear donación: " . $e->getMessage()
            ];
        }
    }

}
