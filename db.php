<?php
// api/db.php

// Toma valores desde variables de entorno de Render
$DB_HOST = getenv('DB_HOST') ?: 'switchback.proxy.rlwy.net';
$DB_PORT = getenv('DB_PORT') ?: '11327';
$DB_NAME = getenv('DB_NAME') ?: 'railway';
$DB_USER = getenv('DB_USER') ?: 'postgres';
$DB_PASS = getenv('DB_PASS') ?: ''; // NO poner contraseña aquí

try {
    // PostgreSQL sin SSL (importante)
    $dsn = "pgsql:host={$DB_HOST};port={$DB_PORT};dbname={$DB_NAME}";

    $conexion = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'error' => 'Error de conexión: ' . $e->getMessage()
    ]);
    exit();
}
