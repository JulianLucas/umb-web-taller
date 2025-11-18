<?php

$host = "switchback.proxy.rlwy.net";
$port = 11327;
$dbname = "railway";
$user = "postgres";
$pass = "";

$dsn = "pgsql:host=$host;port=$port;dbname=$dbname";

try {
    $conexion = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // 👇 DESACTIVAR SSL (requerido por Railway)
        PDO::PGSQL_ATTR_DISABLE_PREPARED_STATEMENT => true
    ]);
} catch (PDOException $e) {
    echo json_encode([
        "error" => "Error de conexión: " . $e->getMessage()
    ]);
    exit;
}
