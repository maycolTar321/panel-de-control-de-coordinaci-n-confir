// IMPORTANTE: Reemplaza esta URL con la que te dé Google Apps Script al final
const API_URL = "https://script.google.com/macros/s/AKfycbxMb_dFcWAISko8jZ_Rx_tWCPGQ5aOSTo4X-qPNKuNNlCTgWsrJO_a0xdIoEbEfVe2G/exec";

async function fetchActividades() {
    try {
        const response = await fetch(`${API_URL}?action=get_actividades`);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Error cargando actividades:", error);
        return [];
    }
}

async function fetchDetalles(id) {
    try {
        const response = await fetch(`${API_URL}?action=get_detalles&id=${id}`);
        const data = await response.json();
        return data;
    } catch (error) {
        console.error("Error cargando detalles:", error);
        return [];
    }
}

async function crearActividad(titulo, fechaLimite) {
    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            body: JSON.stringify({
                action: 'crear_actividad',
                titulo: titulo,
                fecha_limite: fechaLimite
            })
        });
        return await response.json();
    } catch (error) {
        console.error("Error creando actividad:", error);
        return {error: error.message};
    }
}

async function reportarAvance(actividadId, usuario, nuevoEstado, detalle) {
    try {
        const response = await fetch(API_URL, {
            method: 'POST',
            body: JSON.stringify({
                action: 'reportar_avance',
                actividad_id: actividadId,
                usuario: usuario,
                nuevo_estado: nuevoEstado,
                detalle_estado: detalle
            })
        });
        return await response.json();
    } catch (error) {
        console.error("Error reportando avance:", error);
        return {error: error.message};
    }
}
