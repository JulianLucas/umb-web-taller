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
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return [
                "error" => "Error al listar: " . $e->getMessage()
            ];
        }
    }

    // ================================
    // 🟩 CREAR DONACIÓN (sin AUTO_INCREMENT)
    // ================================
    public static function crear($nombre, $correo, $monto) {

        if (empty($nombre) || empty($correo) || empty($monto)) {
            return ["error" => "Todos los campos son obligatorios"];
        }

        try {
            $db = self::getConexion();

            // 1️⃣ Obtener el próximo ID
            $stmt = $db->query("SELECT IFNULL(MAX(id), 0) + 1 AS next_id FROM donaciones");
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $id = $row["next_id"];

            // 2️⃣ Insertar manualmente el ID
            $stmt = $db->prepare("
                INSERT INTO donaciones (id, nombre, correo, monto, fecha)
                VALUES (:id, :nombre, :correo, :monto, CURRENT_DATE())
            ");

            $stmt->execute([
                ":id"     => $id,
                ":nombre" => $nombre,
                ":correo" => $correo,
                ":monto"  => $monto
            ]);

            return [
                "msg" => "creado",
                "id"  => $id
            ];

        } catch (PDOException $e) {
            return [
                "error" => "Error al crear donación: " . $e->getMessage()
            ];
        }
    }

}
