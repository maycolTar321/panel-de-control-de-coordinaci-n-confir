<?php
$host = "localhost";
$user = "root";
$pass = "";

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = file_get_contents('database.sql');
    $pdo->exec($sql);
    
    echo "<h1>¡Instalación completada exitosamente!</h1>";
    echo "<p>La base de datos <b>sistema_coordinacion</b> y las tablas han sido creadas.</p>";
    echo "<a href='index.php'>Ir al inicio del sistema</a>";
} catch (PDOException $e) {
    echo "<h1>Error en la instalación</h1>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>
