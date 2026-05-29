<?php
include_once '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $fecha_limite = $_POST['fecha_limite'];

    if (!empty($titulo) && !empty($fecha_limite)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO actividades (titulo, estado, fecha_limite) VALUES (?, 'pendiente', ?)");
            $stmt->execute([$titulo, $fecha_limite]);
            
            // Redireccionar de vuelta a la página desde la que se envió el formulario
            $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../dashboard.php';
            header('Location: ' . $referer);
            exit;
        } catch (Exception $e) {
            echo "Error al crear la actividad: " . $e->getMessage();
        }
    } else {
        echo "Por favor, completa el título y la fecha límite.";
    }
}
?>
