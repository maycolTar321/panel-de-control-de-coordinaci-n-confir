<?php
include_once 'config/conexion.php';
$stmt = $pdo->query("SELECT * FROM actividades ORDER BY fecha_limite ASC");
$actividades = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Coordinación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: linear-gradient(135deg, #0f2027, #203a43, #2c5364); min-height: 100vh; font-family: system-ui, sans-serif; }
        .glass-card { background: rgba(255, 255, 255, 0.05); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-radius: 24px; border: 1px solid rgba(255, 255, 255, 0.1); box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.3); }
        .glass-item { background: rgba(255, 255, 255, 0.03) !important; border: 1px solid rgba(255, 255, 255, 0.05) !important; border-radius: 14px !important; transition: all 0.25s ease; }
        .glass-item:hover { background: rgba(255, 255, 255, 0.08) !important; transform: translateY(-2px); }
        .glass-modal { background: rgba(15, 32, 39, 0.9); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.15); border-radius: 20px; }
    </style>
</head>
<body>
<div class="container mt-5">
    <div class="glass-card p-4 p-md-5">
        <h1 class="mb-4 text-white">Estado del Proyecto <span class="badge bg-primary fs-6">Coordinador</span></h1>
        <p class="text-white-50">Escribe las nuevas actividades para el equipo. Aparecerán aquí abajo como un checklist.</p>
        
        <!-- Formulario para agregar actividades -->
        <form action="api/crear_actividad.php" method="POST" class="mb-4">
            <div class="input-group">
                <input type="text" name="titulo" class="form-control bg-dark text-white border-secondary" placeholder="Escribe una nueva actividad..." required>
                <input type="date" name="fecha_limite" class="form-control bg-dark text-white border-secondary" required style="max-width: 150px;">
                <button class="btn btn-success fw-bold" type="submit">Añadir Tarea</button>
            </div>
        </form>

        <div class="list-group mt-4">
            <?php foreach ($actividades as $act): ?>
                <div class="list-group-item list-group-item-action glass-item d-flex justify-content-between align-items-center text-white mb-2" style="cursor:pointer;" onclick="verDetalle(<?php echo $act['id']; ?>, '<?php echo htmlspecialchars($act['titulo']); ?>')">
                    <div class="d-flex align-items-center">
                        <input class="form-check-input me-3" type="checkbox" <?php echo $act['estado'] == 'completado' ? 'checked' : ''; ?> disabled>
                        <span class="<?php echo $act['estado'] == 'completado' ? 'text-decoration-line-through text-white-50' : 'fw-bold'; ?>">
                            <?php echo htmlspecialchars($act['titulo']); ?>
                        </span>
                    </div>
                    <span class="badge rounded-pill bg-<?php echo $act['estado'] == 'pendiente' ? 'danger' : ($act['estado'] == 'en_proceso' ? 'warning' : 'success'); ?>">
                        <?php echo ucfirst($act['estado']); ?>
                    </span>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="modal fade" id="detalleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content glass-modal text-white">
      <div class="modal-header" style="border-bottom: 1px solid rgba(255,255,255,0.1);">
        <h5 class="modal-title" id="modalTitulo">Detalle de la Actividad</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modalCuerpo">
        <div class="text-center"><div class="spinner-border text-light" role="status"></div></div>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function verDetalle(id, titulo) {
    document.getElementById('modalTitulo').innerText = titulo;
    document.getElementById('modalCuerpo').innerHTML = '<div class="text-center"><div class="spinner-border text-light" role="status"></div></div>';
    var myModal = new bootstrap.Modal(document.getElementById('detalleModal'));
    myModal.show();

    fetch('api/obtener_detalle.php?id=' + id)
        .then(response => response.text())
        .then(data => { document.getElementById('modalCuerpo').innerHTML = data; })
        .catch(error => { document.getElementById('modalCuerpo').innerHTML = '<p class="text-danger">Error al cargar los detalles.</p>'; });
}
</script>
</body>
</html>
