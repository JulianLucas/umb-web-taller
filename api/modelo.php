<?php 
require_once __DIR__ . '/db.php';

class Modelo {

    private static $db;

    private static function getConexion() {
        if (!self::$db) {
            global $conexion;
            self::$db = $conexion;
        }
        return self::$db;
    }

    // ================================
    // 📘 READ: Listar todas las donaciones
    // ================================
    public static function listar() {
        try {
            $db = self::getConexion();
            $sql = "SELECT * FROM donaciones ORDER BY id DESC";
            $stmt = $db->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);

        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // ================================
    // 📗 CREATE: Crear donación
    // ================================
    public static function crear($nombre, $correo, $monto) {

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
            return ["error" => $e->getMessage()];
        }
    }

    // ================================
    // 📙 UPDATE: Actualizar donación
    // ================================
    public static function actualizar($id, $nombre, $correo, $monto) {

        try {
            $db = self::getConexion();

            $stmt = $db->prepare("
                UPDATE donaciones 
                SET nombre = :nombre, correo = :correo, monto = :monto
                WHERE id = :id
            ");

            $stmt->execute([
                ":id"     => $id,
                ":nombre" => $nombre,
                ":correo" => $correo,
                ":monto"  => $monto
            ]);

            return ["msg" => "actualizado"];

        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }

    // ================================
    // 📕 DELETE: Eliminar donación
    // ================================
    public static function eliminar($id) {
        try {
            $db = self::getConexion();

            $stmt = $db->prepare("DELETE FROM donaciones WHERE id = :id");

            $stmt->execute([":id" => $id]);

            return ["msg" => "eliminado"];

        } catch (PDOException $e) {
            return ["error" => $e->getMessage()];
        }
    }
}
