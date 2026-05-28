<?php
include_once 'config/conexion.php';
// Simulamos el inicio de sesión del equipo por ahora
// En producción, aquí verificarías si es 'secretaria' o 'subcoordinadora'
$stmt = $pdo->query("SELECT id, titulo FROM actividades WHERE estado != 'completado'");
$actividades = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportar Actividad - Equipo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #1f4068, #162447, #1a1a2e); min-height: 100vh; font-family: system-ui, sans-serif; }
        .glass-card { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-radius: 24px; border: 1px solid rgba(255, 255, 255, 0.1); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3); }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="glass-card p-4 text-white">
                <h2 class="mb-4">Reportar Avance / Retraso</h2>
                <p class="text-white-50">Selecciona la actividad y detalla exactamente qué falta o qué sucedió.</p>

                <form action="guardar_reporte.php" method="POST">
                    <input type="hidden" name="usuario_id" value="2">

                    <div class="mb-3">
                        <label class="form-label">Selecciona la Actividad</label>
                        <select name="actividad_id" class="form-select bg-dark text-white border-secondary" required>
                            <option value="">-- Seleccionar tarea pendiente --</option>
                            <?php foreach ($actividades as $act): ?>
                                <option value="<?php echo $act['id']; ?>"><?php echo htmlspecialchars($act['titulo']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Estado de la Actividad</label>
                        <select name="nuevo_estado" class="form-select bg-dark text-white border-secondary" required>
                            <option value="pendiente">Sigue Pendiente</option>
                            <option value="en_proceso">En Proceso / Trabajando en ello</option>
                            <option value="completado">¡Listo /completado!</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Detalle Crucial (¿Por qué se detuvo o qué falta?)</label>
                        <textarea name="detalle_estado" class="form-control bg-dark text-white border-secondary" rows="5" placeholder="Escribe aquí toda la bitácora detallada..." required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary w-100 py-2 fw-bold">Enviar Reporte al Coordinador</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
