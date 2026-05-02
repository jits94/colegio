<?php
include '../../contenido/sesion.php';
include '../../clases/registro.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <?php include_once "../../contenido/extensiones.php"; ?>
  <link href="../../assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include_once "../../contenido/encabezado.php"; ?>
<?php include_once "../../contenido/menu.php"; ?>
  <main id="main" class="main">
    <div class="pagetitle">
      <div class="row">
        <div class="col-md-6" style="text-align:left;">
          <h1>Conceptos de Egresos</h1>
        </div>
        <div class="col-md-6" style="text-align:right;">
          <button class="btn btn-primary" type="button" onclick="abrirModalConcepto()">Nuevo Concepto</button>
        </div>
      </div>
    </div>

    <section class="section">
      <div class="row mt-3">
        <div class="col-lg-12">
          <div class="card shadow-lg" style="border-top:solid 3px #0d6efd;">
            <div class="card-body">
              <div class="pt-3">
                <p class="text-muted mb-3">Administra los conceptos que luego aparecer&aacute;n en el registro de egresos.</p>
                <div id="divConceptosResultado">Cargando...</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>

  <?php include_once "../../contenido/piePagina.php"; ?>
  <?php include_once "../../contenido/extensionesFooter.php"; ?>

  <script>
    $(document).ready(function() {
      listarConceptos();
    });

    function abrirModalConcepto() {
      $("#txtConceptoId").val('');
      $("#txtConceptoNuevo").val('');
      $("#tituloModalConcepto").text('Nuevo Concepto de Egreso');
      $("#modalConcepto").modal('show');
      setTimeout(function() {
        $("#txtConceptoNuevo").focus();
      }, 250);
    }

    function editarConcepto(id, concepto) {
      $("#txtConceptoId").val(id);
      $("#txtConceptoNuevo").val(concepto);
      $("#tituloModalConcepto").text('Editar Concepto de Egreso');
      $("#modalConcepto").modal('show');
      setTimeout(function() {
        $("#txtConceptoNuevo").focus();
      }, 250);
    }

    function guardarConcepto() {
      var id = $("#txtConceptoId").val();
      var concepto = $("#txtConceptoNuevo").val().trim();
      var operacion = id === '' ? 'crearConceptoEgreso' : 'editarConceptoEgreso';

      if (concepto === '') {
        Swal.fire('Campos requeridos', 'Debe ingresar el nombre del concepto.', 'warning');
        return;
      }

      $.post("../../respuestaParcial.php?operacion=" + operacion, {
        id: id,
        concepto: concepto
      }, function(data) {
        if (data.request === 'ok') {
          $("#modalConcepto").modal('hide');
          Swal.fire('\u00c9xito', 'Concepto guardado correctamente.', 'success');
          listarConceptos();
        } else {
          Swal.fire('Error', data.mensaje, 'error');
        }
      }, "json");
    }

    function listarConceptos() {
      $.post("../../respuestaParcial.php?operacion=traerConceptosEgreso", {
        soloActivos: 0
      }, function(data) {
        if (data.request !== 'ok') {
          $("#divConceptosResultado").html('<div class="alert alert-danger">No se pudieron cargar los conceptos.</div>');
          return;
        }

        var html = '<table class="table table-bordered table-striped" id="tablaConceptos">';
        html += '<thead><tr><th>ID</th><th>Concepto</th><th>Estado</th><th>Acci&oacute;n</th></tr></thead><tbody>';

        if (data.datos.length === 0) {
          html += '<tr><td colspan="4" class="text-center">No hay conceptos registrados.</td></tr>';
        } else {
          data.datos.forEach(function(item) {
            var activo = parseInt(item.baja, 10) === 0;
            var conceptoJs = escaparJs(item.concepto);
            var badge = activo
              ? '<span class="badge bg-success">Activo</span>'
              : '<span class="badge bg-secondary">Inactivo</span>';

            html += '<tr>';
            html += '<td>' + item.id + '</td>';
            html += '<td>' + escaparHtml(item.concepto) + '</td>';
            html += '<td>' + badge + '</td>';
            html += '<td>';
            html += '<button class="btn btn-warning btn-sm me-1" onclick="editarConcepto(' + item.id + ', \'' + conceptoJs + '\')"><i class="bi bi-pencil"></i></button>';

            if (activo) {
              html += '<button class="btn btn-danger btn-sm" onclick="cambiarEstadoConcepto(' + item.id + ', false)"><i class="bi bi-trash"></i></button>';
            } else {
              html += '<button class="btn btn-success btn-sm" onclick="cambiarEstadoConcepto(' + item.id + ', true)"><i class="bi bi-check-circle"></i></button>';
            }

            html += '</td>';
            html += '</tr>';
          });
        }

        html += '</tbody></table>';
        $("#divConceptosResultado").html(html);
        $('#tablaConceptos').DataTable({
          "scrollY": "450px",
          "scrollX": true
        });
      }, "json");
    }

    function cambiarEstadoConcepto(id, activar) {
      var operacion = activar ? 'activarConceptoEgreso' : 'desactivarConceptoEgreso';
      var titulo = activar ? '\u00bfActivar concepto?' : '\u00bfDar de baja el concepto?';
      var texto = activar
        ? 'El concepto volver\u00e1 a estar disponible al registrar egresos.'
        : 'El concepto ya no aparecer\u00e1 para nuevos egresos, pero no afectar\u00e1 registros anteriores.';
      var confirmacion = activar ? 'S\u00ed, activar' : 'S\u00ed, dar de baja';

      Swal.fire({
        title: titulo,
        text: texto,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: confirmacion,
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          $.post("../../respuestaParcial.php?operacion=" + operacion, { id: id }, function(data) {
            if (data.request === 'ok') {
              Swal.fire('\u00c9xito', data.mensaje, 'success');
              listarConceptos();
            } else {
              Swal.fire('Error', data.mensaje, 'error');
            }
          }, "json");
        }
      });
    }

    function escaparHtml(texto) {
      return $('<div>').text(texto).html();
    }

    function escaparJs(texto) {
      return String(texto).replace(/\\/g, '\\\\').replace(/'/g, "\\'");
    }
  </script>

  <div class="modal fade" id="modalConcepto">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="tituloModalConcepto">Nuevo Concepto de Egreso</h4>
        </div>
        <div class="modal-body">
          <input type="hidden" id="txtConceptoId">
          <label>Concepto</label>
          <input type="text" id="txtConceptoNuevo" class="form-control" placeholder="Ej: Pago de Luz">
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary rounded-pill" onclick="guardarConcepto()">Guardar</button>
          <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
