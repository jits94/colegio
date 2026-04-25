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
              
              <!-- Contenedor del Gráfico -->
              <div id="reportsChart" class="mt-5"></div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </main>
  <?php include_once "../../contenido/piePagina.php"; ?>
  <?php include_once "../../contenido/extensionesFooter.php"; ?>
  <script>
      var chart = null;

      $(document).ready(function() {
        filtrar();
      })

      function filtrar(){
          var gestion = $("#txtGestionFiltro").val();
          $("#divResultado").html('Generando Reporte y Gráficos...');
          $.post("../../respuestaParcial.php?operacion=balanceGeneral", {
              gestion: gestion
          }, function(data){
              $("#divResultado").html(data.html);
              $('#tablaHistorico').DataTable({
                  "bPaginate": false, 
                  "scrollY": "450px", 
                  "scrollX": true, 
                  "searching": false, 
                  "info": false,
                  "ordering": false 
              });
              
              renderChart(data.ingresos, data.egresos, gestion);
          }, "json");
      }

      function renderChart(ingresos, egresos, gestion) {
          if (chart) { chart.destroy(); }
          
          var options = {
            series: [{
              name: 'Total Ingresos',
              data: ingresos
            }, {
              name: 'Total Egresos',
              data: egresos
            }],
            chart: {
              height: 400,
              type: 'area', // Linea sutilmente rellenada que se ve más moderna
              toolbar: { show: true }
            },
            colors: ['#0d6efd', '#dc3545'], // Azul para ingresos, Rojo para egresos
            fill: {
                type: "gradient",
                gradient: { shadeIntensity: 1, opacityFrom: 0.3, opacityTo: 0.1, stops: [0, 90, 100] }
            },
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: {
              categories: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
              title: { text: 'Meses del Año ' + gestion }
            },
            yaxis: {
                title: { text: 'Cantidades Totales (Bs.)' }
            },
            tooltip: {
              y: { formatter: function (val) { return "Bs. " + val } }
            }
          };

          chart = new ApexCharts(document.querySelector("#reportsChart"), options);
          chart.render();
      }
  </script>
</body>
</html>