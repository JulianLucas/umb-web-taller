<?php
require_once __DIR__ . '/db.php';

// Revisar si la tabla ya tiene AUTO_INCREMENT
$sql = "
    SELECT EXTRA 
    FROM INFORMATION_SCHEMA.COLUMNS 
    WHERE TABLE_SCHEMA = DATABASE()
    AND TABLE_NAME = 'donaciones'
    AND COLUMN_NAME = 'id'
";

$extra = $conexion->query($sql)->fetchColumn();

if ($extra !== 'auto_increment') {
    echo "⚠️ El campo id NO tiene AUTO_INCREMENT. Reparando...\n";

    // Reparar la tabla
    $alter = "
        ALTER TABLE donaciones 
        CHANGE id id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY
    ";

    $conexion->exec($alter);

    echo "✅ Tabla reparada: id ahora es AUTO_INCREMENT\n";
} else {
    echo "✔️ El campo id ya es AUTO_INCREMENT";
}
