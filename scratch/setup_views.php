<?php
$base_path = 'c:\\xampp\\htdocs\\colegio\\';

// ------------------------ INGRESOS (MENSUALIDADES) ------------------------ //
$ingresosHTML = <<<'EOD'
<?php 
include '../../contenido/sesion.php'; 
include '../../clases/registro.php';
include '../../clases/parametros.php';
$registro = new registro();
$iparametro = new parametros();
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
             <h1>Registro de Mensualidades (Ingresos)</h1>
         </div>
         <div class="col-md-6" style="text-align:right;">
              <button class="btn btn-primary" type="button" onclick="agregar()">Registrar Ingreso</button>
         </div>
     </div>
    </div>
    <section class="section">
      <div class="row mt-3">
        <div class="col-lg-12">     
          <div class="card shadow-lg" style="border-top:solid 3px blue;">
            <div class="card-body">
              <div class="row pt-3">
                  <div class="col-md-3">
                      <label>Gestión</label>
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
        filtrar();
      })
      function agregar(){ $("#modalCrear").modal('show'); }

      function ConfirmarRegistrar(){
          var codAlumno = $("#txtAlumno").val();  
          var monto = $("#txtMonto").val();
          var fechaPago = $("#txtFecha").val();
          var gestion = $("#txtGestion").val();
          var mes = $("#txtMes").val();
          var concepto = $("#txtConcepto").val();
          
          if(codAlumno == 0 || monto == "" || concepto == ""){ swal('Ops', 'Llene los datos básicos.', 'warning'); return; }

          $.post("../../respuestaParcial.php?operacion=crearIngreso", {
              codAlumno: codAlumno, monto: monto, fechaPago: fechaPago, gestion: gestion, mes: mes, concepto: concepto
          }, function(data){
              if(data.request == 'ok') {
                  swal('Exito','Ingreso guardado', 'success');
                  $("#modalCrear").modal('hide');
                  filtrar();
              } else { swal('Error', data.mensaje, 'error'); }
          }, "json");
      }

      function eliminarIngreso(id){
          swal({ title: "¿Eliminar registro?", type: "warning", icon: "warning",
              buttons: { confirm: {text: "Si", className: "btn btn-success"}, cancel: {visible: true, className: "btn btn-danger"} }
          }).then((Delete) => {
              if (Delete) {
                  $.post("../../respuestaParcial.php?operacion=eliminarIngreso", {id: id}, function(data){
                      if(data.request=='ok'){ swal('Eliminado','', 'success'); filtrar(); } 
                  }, "json");
              }
          });
      }

      function filtrar(){
          var gestion = $("#txtGestionFiltro").val();
          var mes = $("#txtMesFiltro").val();
          $("#divResultado").html('Cargando...');
          $.post("../../respuestaParcial.php?operacion=traerIngresos", {
              gestion: gestion, mes: mes
          }, function(data){
              $("#divResultado").html(data);
              $('#tablaHistorico').DataTable({"scrollY": "350px", "scrollX": true});
          });
      }
  </script>
  <div class="modal fade" id="modalCrear">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"><h4 class="modal-title">Ingresar Pago</h4></div>
        <div class="modal-body row">             
            <div class="col-md-12 mt-2">
                <label>Estudiante</label>
                <select id="txtAlumno" class="form-select"><?php echo $iparametro->DropDownAlumnos(); ?></select>
            </div>
            <div class="col-md-6 mt-2"><label>Monto (Bs.)</label><input type="number" id="txtMonto" class="form-control" step="0.01"></div>
            <div class="col-md-6 mt-2"><label>Fecha Exacta</label><input type="date" id="txtFecha" class="form-control" value="<?php echo date('Y-m-d');?>"></div>
            <div class="col-md-6 mt-2"><label>Gestión</label><input type="number" id="txtGestion" class="form-control" value="<?php echo date('Y');?>"></div>
            <div class="col-md-6 mt-2"><label>Mes a Pagar</label>
                <select id="txtMes" class="form-select">
                    <?php for($i=1;$i<=12;$i++){ echo "<option value='$i'".(date('n')==$i?' selected':'').">$i</option>"; }?>
                </select>
            </div>
            <div class="col-md-12 mt-2"><label>Concepto</label><input type="text" id="txtConcepto" class="form-control" value="Mensualidad Escolar"></div>
        </div>
        <div class="modal-footer mt-3">   
          <button class="btn btn-primary rounded-pill" onclick="ConfirmarRegistrar()">Guardar Pago</button>                     
          <button class="btn btn-danger rounded-pill" data-bs-dismiss="modal">Cancelar</button>            
        </div>
      </div>        
    </div>      
  </div>
</body>
</html>
EOD;

file_put_contents($base_path . 'view/ingresos/index.php', $ingresosHTML);


// ------------------------ EGRESOS ------------------------ //
$egresosHTML = <<<'EOD'
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
             <h1>Control de Egresos</h1>
         </div>
         <div class="col-md-6" style="text-align:right;">
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
                      <label>Gestión</label>
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
        filtrar();
      })
      function agregar(){ $("#modalCrear").modal('show'); }

      function ConfirmarRegistrar(){
          var monto = $("#txtMonto").val();
          var fechaEgreso = $("#txtFecha").val();
          var gestion = $("#txtGestion").val();
          var mes = $("#txtMes").val();
          var concepto = $("#txtConcepto").val();
          
          if(monto == "" || concepto == ""){ swal('Ops', 'Llene el monto y el concepto.', 'warning'); return; }

          $.post("../../respuestaParcial.php?operacion=crearEgreso", {
              monto: monto, fechaEgreso: fechaEgreso, gestion: gestion, mes: mes, concepto: concepto
          }, function(data){
              if(data.request == 'ok') {
                  swal('Exito','Egreso guardado', 'success');
                  $("#txtConcepto").val('');$("#txtMonto").val('');
                  $("#modalCrear").modal('hide');
                  filtrar();
              } else { swal('Error', data.mensaje, 'error'); }
          }, "json");
      }

      function eliminarEgreso(id){
          swal({ title: "¿Eliminar registro?", type: "warning", icon: "warning",
              buttons: { confirm: {text: "Si", className: "btn btn-success"}, cancel: {visible: true, className: "btn btn-danger"} }
          }).then((Delete) => {
              if (Delete) {
                  $.post("../../respuestaParcial.php?operacion=eliminarEgreso", {id: id}, function(data){
                      if(data.request=='ok'){ swal('Eliminado','', 'success'); filtrar(); } 
                  }, "json");
              }
          });
      }

      function filtrar(){
          var gestion = $("#txtGestionFiltro").val();
          var mes = $("#txtMesFiltro").val();
          $("#divResultado").html('Cargando...');
          $.post("../../respuestaParcial.php?operacion=traerEgresos", {
              gestion: gestion, mes: mes
          }, function(data){
              $("#divResultado").html(data);
              $('#tablaHistorico').DataTable({"scrollY": "350px", "scrollX": true});
          });
      }
  </script>
  <div class="modal fade" id="modalCrear">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header"><h4 class="modal-title">Registrar Egreso</h4></div>
        <div class="modal-body row">             
            <div class="col-md-12 mt-2"><label>Concepto del Gasto</label><input type="text" id="txtConcepto" class="form-control" placeholder="Ej: Pago de Luz"></div>
            <div class="col-md-6 mt-2"><label>Monto (Bs.)</label><input type="number" id="txtMonto" class="form-control" step="0.01"></div>
            <div class="col-md-6 mt-2"><label>Fecha</label><input type="date" id="txtFecha" class="form-control" value="<?php echo date('Y-m-d');?>"></div>
            <div class="col-md-6 mt-2"><label>Gestión</label><input type="number" id="txtGestion" class="form-control" value="<?php echo date('Y');?>"></div>
            <div class="col-md-6 mt-2"><label>Mes Correspondiente</label>
                <select id="txtMes" class="form-select">
                    <?php for($i=1;$i<=12;$i++){ echo "<option value='$i'".(date('n')==$i?' selected':'').">$i</option>"; }?>
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
EOD;

file_put_contents($base_path . 'view/egresos/index.php', $egresosHTML);


// ------------------------ BALANCE ------------------------ //
$balanceHTML = <<<'EOD'
<?php 
include '../../contenido/sesion.php'; 
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
             <h1>Balance General (Ganancia Líquida)</h1>
         </div>
     </div>
    </div>
    <section class="section">
      <div class="row mt-3">
        <div class="col-lg-12">     
          <div class="card shadow-lg" style="border-top:solid 3px green;">
            <div class="card-body">
              <div class="row pt-3">
                  <div class="col-md-4">
                      <label>Ver balances de la Gestión (Año)</label>
                      <input type="number" id="txtGestionFiltro" class="form-control" value="<?php echo date('Y'); ?>">
                  </div>
                  <div class="col-md-2 mt-4">
                      <button class="btn btn-success w-100" onclick="filtrar()">  Ver Balance</button>
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
        filtrar();
      })

      function filtrar(){
          var gestion = $("#txtGestionFiltro").val();
          $("#divResultado").html('Analizando...');
          $.post("../../respuestaParcial.php?operacion=balanceGeneral", {
              gestion: gestion
          }, function(data){
              $("#divResultado").html(data);
              $('#tablaHistorico').DataTable({"bPaginate": false, "scrollY": "500px", "scrollX": true, "searching": false, "info": false});
          });
      }
  </script>
</body>
</html>
EOD;

file_put_contents($base_path . 'view/balance/index.php', $balanceHTML);

echo "Views generated correctly.\n";
