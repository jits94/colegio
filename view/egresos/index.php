<?php
include '../../contenido/sesion.php';
include '../../clases/registro.php';
$vieneDeBalance = isset($_GET['origen']) && $_GET['origen'] === 'balance';
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
             <h1>Control de Egresos</h1>
         </div>
         <div class="col-md-6" style="text-align:right;">
              <?php if($vieneDeBalance){ ?>
              <a class="btn btn-secondary me-2" href="../balance/">Volver al Balance</a>
              <?php } ?>
              <button class="btn btn-danger" type="button" onclick="agregar()">Registrar Egreso</button>
         </div>
     </div>
    </div>
    <section class="section">
      <div class="row mt-3">
        <div class="col-lg-12">
          <div class="card shadow-lg" style="border-top:solid 3px red;">
            <div class="card-body">
              <div class="row pt-3">
                  <div class="col-md-3">
                      <label>Gesti&oacute;n</label>
                      <input type="number" id="txtGestionFiltro" class="form-control" value="<?php echo date('Y'); ?>">
                  </div>
                  <div class="col-md-3">
                      <label>Mes</label>
                      <select id="txtMesFiltro" class="form-select">
                          <option value="0">Todos los Meses</option>
                          <option value="1">Enero</option>
                          <option value="2">Febrero</option>
                          <option value="3">Marzo</option>
                          <option value="4">Abril</option>
                          <option value="5">Mayo</option>
                          <option value="6">Junio</option>
                          <option value="7">Julio</option>
                          <option value="8">Agosto</option>
                          <option value="9">Septiembre</option>
                          <option value="10">Octubre</option>
                          <option value="11">Noviembre</option>
                          <option value="12">Diciembre</option>
                      </select>
                  </div>
                  <div class="col-md-3">
                      <label>Concepto</label>
                      <select id="txtConceptoFiltro" class="form-select">
                          <option value="">Todos los conceptos</option>
                      </select>
                  </div>
                  <div class="col-md-2 mt-4">
                      <button class="btn btn-dark w-100" onclick="filtrar()">Aplicar Filtro</button>
                  </div>
              </div>
              <br>
              <div id="divResultado"></div>
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
        aplicarFiltrosDesdeUrl();
        cargarConceptosEgreso();
        cargarConceptosFiltro();
      });

      function aplicarFiltrosDesdeUrl() {
          var params = new URLSearchParams(window.location.search);
          var gestion = params.get('gestion');
          var mes = params.get('mes');
          var concepto = params.get('concepto');

          if (gestion) {
              $("#txtGestionFiltro").val(gestion);
          }

          if (mes) {
              $("#txtMesFiltro").val(mes);
              $("#txtMes").val(mes);
          }

          if (concepto) {
              $("#txtConceptoFiltro").attr('data-selected', concepto);
          }
      }

      function agregar(){
        $("#modalCrear").modal('show');
        ocultarNuevoConcepto();
        cargarConceptosEgreso();
      }

      function cargarConceptosEgreso(conceptoSeleccionado = ''){
          $.post("../../respuestaParcial.php?operacion=traerConceptosEgreso", function(data){
              if(data.request !== 'ok') {
                  Swal.fire('Error', data.mensaje || 'No se pudieron cargar los conceptos.', 'error');
                  return;
              }

              var opciones = '<option value="">Seleccione un concepto</option>';
              data.datos.forEach(function(item){
                  var seleccionado = conceptoSeleccionado === item.concepto ? 'selected' : '';
                  opciones += '<option value="' + escaparHtml(item.concepto) + '" ' + seleccionado + '>' + escaparHtml(item.concepto) + '</option>';
              });

              $("#txtConcepto").html(opciones);
          }, "json");
      }

      function cargarConceptosFiltro(conceptoSeleccionado = ''){
          $.post("../../respuestaParcial.php?operacion=traerConceptosEgreso", function(data){
              if(data.request !== 'ok') {
                  return;
              }

              var conceptoUrl = $("#txtConceptoFiltro").attr('data-selected') || '';
              var conceptoFinal = conceptoSeleccionado || conceptoUrl;

              var opciones = '<option value="">Todos los conceptos</option>';
              data.datos.forEach(function(item){
                  var seleccionado = conceptoFinal === item.concepto ? 'selected' : '';
                  opciones += '<option value="' + escaparHtml(item.concepto) + '" ' + seleccionado + '>' + escaparHtml(item.concepto) + '</option>';
              });

              $("#txtConceptoFiltro").html(opciones);
              $("#txtConceptoFiltro").removeAttr('data-selected');
              filtrar();
          }, "json");
      }

      function mostrarNuevoConcepto(){
          $("#panelNuevoConcepto").show();
          $("#txtNuevoConcepto").focus();
      }

      function ocultarNuevoConcepto(){
          $("#panelNuevoConcepto").hide();
          $("#txtNuevoConcepto").val('');
      }

      function guardarNuevoConcepto(){
          var concepto = $("#txtNuevoConcepto").val().trim();
          if(concepto === ''){
              Swal.fire('Campos requeridos', 'Debe escribir el nuevo concepto.', 'warning');
              return;
          }

          $.post("../../respuestaParcial.php?operacion=crearConceptoEgreso", {
              concepto: concepto
          }, function(data){
              if(data.request === 'ok') {
                  cargarConceptosEgreso(data.concepto);
                  ocultarNuevoConcepto();
                  Swal.fire('\u00c9xito', 'Concepto guardado correctamente.', 'success');
              } else {
                  Swal.fire('Error', data.mensaje, 'error');
              }
          }, "json");
      }

      function ConfirmarRegistrar(){
          var monto = $("#txtMonto").val();
          var fechaEgreso = $("#txtFecha").val();
          var gestion = $("#txtGestion").val();
          var mes = $("#txtMes").val();
          var concepto = $("#txtConcepto").val();

          if(monto === "" || concepto === ""){
              Swal.fire('Campos requeridos', 'Seleccione el concepto y registre el monto.', 'warning');
              return;
          }

          $.post("../../respuestaParcial.php?operacion=crearEgreso", {
              monto: monto, fechaEgreso: fechaEgreso, gestion: gestion, mes: mes, concepto: concepto
          }, function(data){
              if(data.request == 'ok') {
                  Swal.fire('\u00c9xito','Egreso guardado', 'success');
                  $("#txtConcepto").val('');
                  $("#txtMonto").val('');
                  $("#modalCrear").modal('hide');
                  ocultarNuevoConcepto();
                  filtrar();
              } else {
                  Swal.fire('Error', data.mensaje, 'error');
              }
          }, "json");
      }

      function eliminarEgreso(id){
          Swal.fire({
              title: '\u00bfEliminar registro?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonText: 'S\u00ed, eliminar',
              cancelButtonText: 'Cancelar'
          }).then((result) => {
              if (result.isConfirmed) {
                  $.post("../../respuestaParcial.php?operacion=eliminarEgreso", {id: id}, function(data){
                      if(data.request=='ok'){
                          Swal.fire('Eliminado','', 'success');
                          filtrar();
                      }
                  }, "json");
              }
          });
      }

      function filtrar(){
          var gestion = $("#txtGestionFiltro").val();
          var mes = $("#txtMesFiltro").val();
          var concepto = $("#txtConceptoFiltro").val();
          $("#divResultado").html('Cargando...');
          $.post("../../respuestaParcial.php?operacion=traerEgresos", {
              gestion: gestion, mes: mes, concepto: concepto
          }, function(data){
              $("#divResultado").html(data);
              $('#tablaHistorico').DataTable({"scrollY": "450px", "scrollX": true});
          });
      }

      function escaparHtml(texto) {
          return $('<div>').text(texto).html();
      }
  </script>
  <div class="modal fade" id="modalCrear">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"><h4 class="modal-title">Registrar Egreso</h4></div>
        <div class="modal-body row">
            <div class="col-md-12 mt-2">
                <label>Concepto del Gasto</label>
                <div class="input-group">
                    <select id="txtConcepto" class="form-select shadow-lg"></select>
                    <button class="btn btn-outline-primary" type="button" onclick="mostrarNuevoConcepto()">Nuevo concepto</button>
                </div>
                <small class="text-muted">Si no existe en la lista, puedes crearlo aqu&iacute; mismo.</small>
            </div>
            <div class="col-md-12 mt-3" id="panelNuevoConcepto" style="display:none;">
                <label>Nuevo concepto</label>
                <div class="input-group">
                    <input type="text" id="txtNuevoConcepto" class="form-control shadow-lg" placeholder="Ej: Pago de Luz">
                    <button class="btn btn-success" type="button" onclick="guardarNuevoConcepto()">Guardar concepto</button>
                    <button class="btn btn-secondary" type="button" onclick="ocultarNuevoConcepto()">Cancelar</button>
                </div>
            </div>
            <div class="col-md-6 mt-2"><label>Monto (Bs.)</label><input type="number" id="txtMonto" class="form-control shadow-lg" step="0.01"></div>
            <div class="col-md-6 mt-2" style="display:none;"><label>Fecha</label><input type="date" id="txtFecha" class="form-control shadow-lg" value="<?php echo date('Y-m-d');?>"></div>
            <div class="col-md-6 mt-2"><label>Gesti&oacute;n</label><input type="number" id="txtGestion" class="form-control shadow-lg" value="<?php echo date('Y');?>"></div>
            <div class="col-md-6 mt-2"><label>Mes Correspondiente</label>
                <select id="txtMes" class="form-select shadow-lg">
                      <option value="1" <?php if (date('n') == 1) { echo "selected"; } ?>>Enero</option>
                      <option value="2" <?php if (date('n') == 2) { echo "selected"; } ?>>Febrero</option>
                      <option value="3" <?php if (date('n') == 3) { echo "selected"; } ?>>Marzo</option>
                      <option value="4" <?php if (date('n') == 4) { echo "selected"; } ?>>Abril</option>
                      <option value="5" <?php if (date('n') == 5) { echo "selected"; } ?>>Mayo</option>
                      <option value="6" <?php if (date('n') == 6) { echo "selected"; } ?>>Junio</option>
                      <option value="7" <?php if (date('n') == 7) { echo "selected"; } ?>>Julio</option>
                      <option value="8" <?php if (date('n') == 8) { echo "selected"; } ?>>Agosto</option>
                      <option value="9" <?php if (date('n') == 9) { echo "selected"; } ?>>Septiembre</option>
                      <option value="10" <?php if (date('n') == 10) { echo "selected"; } ?>>Octubre</option>
                      <option value="11" <?php if (date('n') == 11) { echo "selected"; } ?>>Noviembre</option>
                      <option value="12" <?php if (date('n') == 12) { echo "selected"; } ?>>Diciembre</option>
                </select>
            </div>
        </div>
        <div class="modal-footer mt-3">
          <button class="btn btn-primary rounded-pill" onclick="ConfirmarRegistrar()">Guardar Egreso</button>
          <button class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
