function doGet(e) {
  var action = e.parameter.action;
  if (action == 'get_actividades') {
    return ContentService.createTextOutput(JSON.stringify(getActividades())).setMimeType(ContentService.MimeType.JSON);
  } else if (action == 'get_detalles') {
    var id = e.parameter.id;
    return ContentService.createTextOutput(JSON.stringify(getDetalles(id))).setMimeType(ContentService.MimeType.JSON);
  }
  return ContentService.createTextOutput(JSON.stringify({error: 'Invalid action'})).setMimeType(ContentService.MimeType.JSON);
}

function doPost(e) {
  var data = JSON.parse(e.postData.contents);
  var action = data.action;
  
  if (action == 'crear_actividad') {
    var sheet = SpreadsheetApp.getActiveSpreadsheet().getSheetByName("Actividades");
    var lastRow = sheet.getLastRow();
    var newId = lastRow == 1 ? 1 : Number(sheet.getRange(lastRow, 1).getValue()) + 1;
    sheet.appendRow([newId, data.titulo, 'pendiente', data.fecha_limite]);
    return ContentService.createTextOutput(JSON.stringify({success: true})).setMimeType(ContentService.MimeType.JSON);
  } 
  else if (action == 'reportar_avance') {
    // 1. Insert update
    var sheetUpdates = SpreadsheetApp.getActiveSpreadsheet().getSheetByName("Actualizaciones");
    var lastRowUpd = sheetUpdates.getLastRow();
    var newUpdId = lastRowUpd == 1 ? 1 : Number(sheetUpdates.getRange(lastRowUpd, 1).getValue()) + 1;
    var fecha = new Date().toLocaleString("es-ES");
    sheetUpdates.appendRow([newUpdId, data.actividad_id, data.usuario, data.detalle_estado, fecha]);
    
    // 2. Update status in Actividades
    var sheetAct = SpreadsheetApp.getActiveSpreadsheet().getSheetByName("Actividades");
    var dataAct = sheetAct.getDataRange().getValues();
    for (var i = 1; i < dataAct.length; i++) {
      if (dataAct[i][0] == data.actividad_id) {
        sheetAct.getRange(i + 1, 3).setValue(data.nuevo_estado);
        break;
      }
    }
    return ContentService.createTextOutput(JSON.stringify({success: true})).setMimeType(ContentService.MimeType.JSON);
  }
  
  return ContentService.createTextOutput(JSON.stringify({error: 'Invalid action'})).setMimeType(ContentService.MimeType.JSON);
}

function getActividades() {
  var sheet = SpreadsheetApp.getActiveSpreadsheet().getSheetByName("Actividades");
  var data = sheet.getDataRange().getValues();
  var result = [];
  for (var i = 1; i < data.length; i++) {
    result.push({
      id: data[i][0],
      titulo: data[i][1],
      estado: data[i][2],
      fecha_limite: data[i][3]
    });
  }
  return result;
}

function getDetalles(actividad_id) {
  var sheet = SpreadsheetApp.getActiveSpreadsheet().getSheetByName("Actualizaciones");
  var data = sheet.getDataRange().getValues();
  var result = [];
  for (var i = 1; i < data.length; i++) {
    if (data[i][1] == actividad_id) {
      result.push({
        id: data[i][0],
        usuario: data[i][2],
        detalle: data[i][3],
        fecha: data[i][4]
      });
    }
  }
  return result.reverse(); // Newest first
}
