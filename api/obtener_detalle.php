<?php
include_once '../config/conexion.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    $stmt = $pdo->prepare("
        SELECT aa.detalle_estado, aa.fecha_registro, u.nombre, u.rol 
        FROM actualizaciones_actividad aa
        JOIN usuarios u ON aa.usuario_id = u.id
        WHERE aa.actividad_id = ?
        ORDER BY aa.fecha_registro DESC
    ");
    $stmt->execute([$id]);
    $detalles = $stmt->fetchAll();

    if ($detalles) {
        foreach ($detalles as $row) {
            echo "<div style='background: rgba(255,255,255,0.02); padding: 15px; border-radius: 8px; margin-bottom: 15px; border-left: 4px solid #0d6efd;'>";
            echo "<small style='color: #a8b2d1;'>" . $row['fecha_registro'] . " - <strong>" . htmlspecialchars($row['nombre']) . " (" . ucfirst($row['rol']) . ")</strong></small>";
            echo "<p style='margin-top: 8px; color: #fff; margin-bottom: 0;'>" . nl2br(htmlspecialchars($row['detalle_estado'])) . "</p>";
            echo "</div>";
        }
    } else {
        echo "<p style='color:#a8b2d1;'>No hay reportes detallados registrados para esta actividad todavía.</p>";
    }
}
?>
