<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'jm_productos');

try {
    $pdo = new PDO(
        "mysql:host=" . DB_HOST . ";port=3306;dbname=" . DB_NAME . ";charset=utf8mb4",
        DB_USER,
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
    );

    // Arreglar stock negativo
    $query = "UPDATE stock_sede_presentacion SET cantidad_stock_presentacion_sede = 0 WHERE cantidad_stock_presentacion_sede < 0";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $affected = $stmt->rowCount();

    // Verificar cuántos fueron actualizados
    $query_check = "SELECT COUNT(*) as negativos FROM stock_sede_presentacion WHERE cantidad_stock_presentacion_sede < 0";
    $stmt_check = $pdo->prepare($query_check);
    $stmt_check->execute();
    $check = $stmt_check->fetch(PDO::FETCH_ASSOC);

    echo "✓ Stock negativo corregido exitosamente.\n";
    echo "Stocks corregidos: " . $affected . "\n";
    echo "Stocks negativos restantes: " . $check['negativos'] . "\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
