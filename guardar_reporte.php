<?php
include_once 'config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $actividad_id = intval($_POST['actividad_id']);
    $usuario_id = intval($_POST['usuario_id']);
    $nuevo_estado = $_POST['nuevo_estado'];
    $detalle_estado = trim($_POST['detalle_estado']);

    if (!empty($actividad_id) && !empty($detalle_estado)) {
        try {
            // 1. Insertar el detalle explicativo en la bitácora
            $stmt1 = $pdo->prepare("INSERT INTO actualizaciones_actividad (actividad_id, usuario_id, detalle_estado) VALUES (?, ?, ?)");
            $stmt1->execute([$actividad_id, $usuario_id, $detalle_estado]);

            // 2. Actualizar el estado general de la actividad en el checklist
            $stmt2 = $pdo->prepare("UPDATE actividades SET estado = ? WHERE id = ?");
            $stmt2->execute([$nuevo_estado, $actividad_id]);

            // Redireccionar de vuelta con éxito
            echo "<script>alert('Reporte guardado con éxito'); window.location.href='formulario.php';</script>";
        } catch (Exception $e) {
            echo "Error al guardar el reporte: " . $e->getMessage();
        }
    } else {
        echo "Por favor rellena todos los campos.";
    }
}
?>
