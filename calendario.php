<?php  
 include 'contenido/sesion.php'; 
require_once "clases/parametros.php";
require_once "clases/registro.php";

$iparametro = new parametros();
$iregistro = new registro();


$actividades = $iregistro->traerActividadesHistorico(@$_POST['txtCodOrganizacion'],@$_POST['txtCodMeta']);
$acontecimientos = $iregistro->traerActividadesHistorico_Acontecimientos();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Históricos Universitario</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <?php include_once "contenido/extensiones.php"; ?>

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
<style>
  .rounded-button {
    padding: 10px 20px; /* Ajusta el padding según tus preferencias */
    border-radius: 20px; /* Define el radio de los bordes para hacerlo redondeado */
   
    border: none; /* Elimina el borde */
    cursor: pointer; /* Cambia el cursor al pasar sobre el botón */
    font-size: 16px; /* Tamaño del texto */
    box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.6);
}



</style>
  <!-- =======================================================
  * Template Name: NiceAdmin
  * Updated: May 30 2023 with Bootstrap v5.3.0
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

<div class="wrapper">
<?php include_once "contenido/encabezado.php"; ?>

<?php include_once "contenido/menu.php"; ?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Actividades</h1>
     
    </div><!-- End Page Title -->

    <section class="section">
     
        <div class="row">
          
        <div class="col-lg-12">

            <div class="card shadow-lg"  style="border-top:solid 3px blue;">
              <div class="card-body">
                
                <!-- Accordion without outline borders -->
                <div class="accordion accordion-flush" id="accordionFlushExample">
                  <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                      <button class="accordion-button " type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="true" aria-controls="flush-collapseOne">
                        <h5 class="card-title">Filtros</h5>
                      </button>                   
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                      <div class="accordion-body">
                        <form id="miFormulario" action="calendario.php" method="post">
                          <div class="row m-3">
                          
                            <div class="col-lg-3 col-md-6 col-sm-12">
                              <label for="" class="form-label">Organizacion</label>
                              <select class="form-select" id="txtCodOrganizacion" name="txtCodOrganizacion">
                                  <?php echo $iparametro->DropDownTraerOrganizacion(@$_POST["txtCodOrganizacion"]) ?>
                              </select>  
                            </div>  
                            
                            <div class="col-lg-3 col-md-6 col-sm-12">
                              <label for="txtCodMeta" class="form-label">Metas </label>
                              <select class="form-select" id="txtCodMeta" name="txtCodMeta" required>
                                <?php echo $iparametro->DropDownTraerMetas(@$_POST["txtCodMeta"]) ?>
                            
                              </select>                
                            </div>

                          </div>
                       
                        <div class="row m-3">
                    
                            <div class="col-md-12" style="text-align:right;">
                              <button class="btn btn-primary rounded-button" type="submit">Filtrar</button>
                            </div>
                        </div>
                        </form>
                      </div>
                    </div>
                  </div>
                
              
                </div><!-- End Accordion without outline borders -->

              </div>
            </div>

        </div>


          <div class="col-md-12">
            <div class="card info-box shadow-lg"  style="border-top:solid 3px blue;">
              <div class="card-body p-4">
                <!-- THE CALENDAR -->
               
                <div id="calendar"></div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>

    </section>


   

  </main><!-- End #main -->


  <?php include_once "contenido/piePagina.php"; ?>
  </div>
  <?php 
  $ruta_assets = "assets/";
  include_once "contenido/extensionesFooter.php"; 
  ?>


     <!-- Modal Registrar descripcion --> 
     <div class="modal fade" id="modal_ver_datos">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Datos de la Actividad</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <div  class="row">       
                <input type="hidden" id='txtCodHistorico' class="form-control" >        
                <input type="hidden" id='txtTipoVista' class="form-control" disabled >          
                    <div class="col-md-12">
                         <label for="form-label">Nombre Actividad</label>
                         <input type="text" id='txtNombre' class="form-control"  disabled>                                           
                    </div>
                    <div class="col-md-6 mt-3 divHistorico">
                         <label for="form-label">Organizacion</label>
                         <input type="text" id='txtOrganizacion' class="form-control" disabled >                                           
                    </div>
                    <div class="col-md-6 mt-3  divHistorico">
                         <label for="form-label">Meta</label>
                         <input type="text" id='txtMeta' class="form-control" disabled  >                                           
                    </div>
                    <div class="col-md-12 mt-3">
                         <label for="form-label">Descripcion Actividad</label>
                         <textarea  cols="3" id='txtDescripcion' class="form-control" disabled></textarea>
                                                                
                    </div>
                </div>
                <div id='divContenedor'></div>
            </div>
            <div class="modal-footer col-md-12">   
              <button type="button" class="btn btn-primary rounded-button" id='btnVerHistorico'onclick="verHistorico()">Ver Historico</button>                                    
              <button type="button" class="btn btn-danger rounded-button" data-bs-dismiss="modal">Cerrar</button>            
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->


  <!-- <script src="assets/js/script.js"></script> -->
  <script>


$(document).ready(function() {

function ini_events(ele) {
  ele.each(function () {
   
    // create an Event Object (https://fullcalendar.io/docs/event-object)
    // it doesn't need to have a start or end
    var eventObject = {
      title: $.trim($(this).text()) // use the element's text as the event title
    }

    // store the Event Object in the DOM element so we can get to it later
    $(this).data('eventObject', eventObject)

    // make the event draggable using jQuery UI
    $(this).draggable({
      zIndex        : 1070,
      revert        : true, // will cause the event to go back to its
      revertDuration: 0  //  original position after the drag
    })

  })
}

ini_events($('#external-events div.external-event'))

/* initialize the calendar
 -----------------------------------------------------------------*/
//Date for the calendar events (dummy data)
var date = new Date()
var d    = date.getDate(),
    m    = date.getMonth(),
    y    = date.getFullYear()

var Calendar = FullCalendar.Calendar;
var Draggable = FullCalendar.Draggable;

var containerEl = document.getElementById('external-events');
var checkbox = document.getElementById('drop-remove');
var calendarEl = document.getElementById('calendar');

// initialize the external events
// -----------------------------------------------------------------



var calendar = new Calendar(calendarEl, {

    
  headerToolbar: {
    left  : 'prev,next today',
    center: 'title',
    right : 'dayGridMonth,timeGridWeek,timeGridDay'
  },
  //themeSystem: 'bootstrap',
  //Random default events
  locale:'es',
  events:  [

    <?php
  
      $color = "#3a87ad";//Blue
      $actividades->MoveFirst();
      while (!$actividades->EndOfSeek()) {
        
          $row = $actividades->Row();
        if($contador>0){ echo ","; }
        $titulo =  $row->nombreActividad . ' - ' . $row->organizacion;
        ?>
        {
          id: '<?php echo $row->codHistorico; ?>',
          title:  '<?php echo $titulo; ?>',   
          start: '<?php echo  $row->fecha;?>',
          end: '<?php echo $row->fecha; ?>',     
          backgroundColor: '<?php echo $color; ?>', 
          borderColor    : '<?php echo $color; ?>',
          extendedProps: {
            department: 'historico'
          }              
        }
      <?php
      $contador=+1;
      $color = "#3a87ad";//Blue
      }    

    $color = "#7df26b";//verde
      $acontecimientos->MoveFirst();
      while (!$acontecimientos->EndOfSeek()) {
        
          $row = $acontecimientos->Row();
        if($contador>0){ echo ","; }
        $titulo =  $row->nombre ;
        ?>
        {
          id: '<?php echo $row->codAcontecimiento; ?>',
          title:  '<?php echo $titulo; ?>',   
          start: '<?php echo  $row->fecha;?>',
          end: '<?php echo $row->fecha; ?>',     
          backgroundColor: '<?php echo $color; ?>', 
          borderColor    : '<?php echo $color; ?>',
          extendedProps: {
            department: 'acontecimiento'
          }              
        }
      <?php
      $contador=+1;
      $color = "#7df26b";//verde
      }    

      ?>

  ],
  eventClick: function(info) {
  
    MostrarDatos(info.event.id,info.event.title,info.event.extendedProps.department); 
  },
  eventDrop: function(info){
    // $("#id2").val(info.event.id);
    // $("#ModalreprogramarEntrevista").modal("show");
  },
  editable  : true,
  droppable : true, // this allows things to be dropped onto the calendar !!!
});



calendar.render();
// $('#calendar').fullCalendar()

/* ADDING EVENTS */
var currColor = '#3c8dbc' //Red by default
// Color chooser button

})
   
function verHistorico(){
    
  var cod = $("#txtCodHistorico").val();
  var tipoVista =  $("#txtTipoVista").val();
       // var RandString = makeidRandom(15);
       if(tipoVista =='historico'){
        imagen = "./registro.php?cod=" + cod ;
       }
       else{
        imagen = "./acontecimiento.php?cod=" + cod ;
       }
       
    
        // imagen = "./uploadetapas/" + imagen
          window.open(imagen);
   
  }


function MostrarDatos(codHistorico,titulo,descripcion){
  $("#txtCodHistorico").val(codHistorico);
  $("#txtTipoVista").val(descripcion);
           $.ajax({
              url: "respuestaParcial.php?operacion=MostrarDatosHistorico",
              type: "POST",  
              dataType: "json",      
              data: {
                codHistorico: codHistorico,
                descripcion: descripcion             
              },            
              success: function(data, textStatus, jqXHR) {
               
                if(descripcion == 'historico'){
                  $(".divHistorico").show();
                  $("#btnVerHistorico").html('Ver Historico');
                }
                else{
                  $(".divHistorico").hide();
                  $("#btnVerHistorico").html('Ver Acontecimiento');
                }
                $("#txtNombre").val(data['nombre']);
                $("#txtOrganizacion").val(data['organizacion']);
                $("#txtMeta").val(data['meta']);
                $("#txtDescripcion").val(data['descripcion']);
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  $("#divContenedor").html('<div class="alert alert-danger" role="alert">Algo salio mal!, por favor intente nuevamente</div>');                 
              }
          });
          
  
  $("#modal_ver_datos").modal("show");
}
  </script>
</body>

</html>