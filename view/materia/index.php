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

  <style>
    .rounded-button {
      padding: 10px 20px; /* Ajusta el padding según tus preferencias */
      border-radius: 20px; /* Define el radio de los bordes para hacerlo redondeado */
    
      border: none; /* Elimina el borde */
      cursor: pointer; /* Cambia el Materiar al pasar sobre el botón */
      font-size: 16px; /* Tamaño del texto */
      box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.6);
      text-align: right;
    }
  </style>

  <!-- Template Main CSS File -->
  <link href="../../assets/css/style.css" rel="stylesheet">
 
</head>

<body>

<?php include_once "../../contenido/encabezado.php"; ?>

<?php include_once "../../contenido/menu.php"; ?>

  <main id="main" class="main">

    <div class="pagetitle">
      
     <div class="row">
         <div class="col-md-6" style="text-align:left;">
                        <h1>Lista de Materias</h1>
                    </div>
                    <div class="col-md-6" style="text-align:right;">
                         <button class="btn btn-primary rounded-button" type="button" onclick="agregar()">Agregar Materia</button>&nbsp;
                    </div>
                                                                                                                                        
                </div>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row mt-3">
        

        <div class="col-lg-12">     

          <div class="card shadow-lg" style="border-top:solid 3px blue;">
            <div class="card-body">
              <h5 class="card-title">Resultado</h5>
             
             
                <!-- Table with stripped rows -->

                
              <br>
                  <div id="divResultado"></div>
            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <?php include_once "../../contenido/piePagina.php"; ?>
  <?php include_once "../../contenido/extensionesFooter.php"; ?>
  <script>

      $(document).ready(function() {
        filtrar();
        //FormatoDatatable();
      })

      
      function agregar(){

        $("#modalCrear").modal('show');
      }
 
      function ConfirmarRegistrar(){

         var nombre = $("#txtNombre").val();  
       var area = $("#txtArea").val();  
         var saberes = $("#txtSaberes option:selected").text();  
        
        if(nombre == ""){
             swal("Debe indicar el nombre de la materia", {
                      icon: "warning",
                    
                    });
                    return;
        }

       

       
           $("#divCargandoCrear").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=crearMateria",
              type: "POST",        
              data: {
                nombre:nombre ,
                 area:area ,
                 saberes:saberes 
              },          
              dataType: "json",  
              success: function(data, textStatus, jqXHR) {
                $("#divCargandoCrear").html('');
                if(data['request'] == 'ok'){
                    $("#txtNombre").val('');  
                   
                   
                    $("#modalCrear").modal('hide');
                   
                    swal("Exito!","La materia fue creada correctamente!", {
                      icon: "success",
                      timer: 1500, // Tiempo en milisegundos (3 segundos)
                    });
                    filtrar();
                }
                else{
                    swal("Oops!",data['mensaje'], {
                        icon: "warning",
                      
                    });
                }
              
              },
              error: function(jqXHR, textStatus, errorThrown) {
                    $("#divCargandoCrear").html('');                 
                    swal("Oops!","Error de ajax, intenta nuevamente!", {
                      icon: "warning",
                    
                    });
              }

          });

      }


        function ActivarDato(codMateria,nombre){
               swal({
                title: "Confirmar ",
                text: "¿Seguro que deseas activar la Materia "+nombre+"?",
                type: "warning",
                icon: "warning",
                buttons: {
                    confirm: {
                    text: "Si, Confirmar",
                    className: "btn btn-success",
                    },
                    cancel: {
                    visible: true,
                    className: "btn btn-danger",
                    },
                },
                }).then((Delete) => {
                    if (Delete) {
                        confirmarActivarMateria(codMateria);                      
                    } else {
                        swal.close();
                    }
                });

        }

        function confirmarActivarMateria(codMateria){

          
             $.ajax({
              url: "../../respuestaParcial.php?operacion=ActivarMateria",
              type: "POST",  
              dataType: "json",      
              data: {
                codMateria:codMateria                 
              },            
              success: function(data, textStatus, jqXHR) {
            
                if(data['request'] == 'ok'){
                   swal("Exito!", "La Materia fue eliminada correctamente", {
                       icon: "success",
                       buttons: { confirm: { className: "btn btn-success" } },
                       timer: 1500
                   });
                  filtrar();
                }
                else{
                      swal("Ooops!", data['mensaje'], {
                            icon: "warning",
                            buttons: { confirm: { className: "btn btn-warning" } },
                        });
                }
                            
              },
              error: function(jqXHR, textStatus, errorThrown) {
                swal("Ooops!", 'Algo salio mal!, por favor intente nuevamente', {
                            icon: "warning",
                            buttons: { confirm: { className: "btn btn-warning" } },
                        });
                        
              }
          });

        }


        function eliminarDato(codMateria,nombre){
               swal({
                title: "Confirmar ",
                text: "¿Seguro que deseas eliminar la Materia "+nombre+"?",
                type: "warning",
                icon: "warning",
                buttons: {
                    confirm: {
                    text: "Si, Confirmar",
                    className: "btn btn-success",
                    },
                    cancel: {
                    visible: true,
                    className: "btn btn-danger",
                    },
                },
                }).then((Delete) => {
                    if (Delete) {
                        confirmareliminarMateria(codMateria);                      
                    } else {
                        swal.close();
                    }
                });

        }

        function confirmareliminarMateria(codMateria){

          
             $.ajax({
              url: "../../respuestaParcial.php?operacion=eliminarMateria",
              type: "POST",  
              dataType: "json",      
              data: {
                codMateria:codMateria                 
              },            
              success: function(data, textStatus, jqXHR) {
            
                if(data['request'] == 'ok'){
                   swal("Exito!", "La Materia fue eliminada correctamente", {
                       icon: "success",
                       buttons: { confirm: { className: "btn btn-success" } },
                       timer: 1500
                   });
                  filtrar();
                }
                else{
                      swal("Ooops!", data['mensaje'], {
                            icon: "warning",
                            buttons: { confirm: { className: "btn btn-warning" } },
                        });
                }
                            
              },
              error: function(jqXHR, textStatus, errorThrown) {
                swal("Ooops!", 'Algo salio mal!, por favor intente nuevamente', {
                            icon: "warning",
                            buttons: { confirm: { className: "btn btn-warning" } },
                        });
                        
              }
          });

        }

      function editarDatos(codMateria,nombre,area,saberes){
        $("#txtCodMateriaEdit").val(codMateria);
        $("#txtMateriaEdit").val(nombre); 
         $("#txtAreaEdit").val(area); 
          $("#txtSaberesEdit").val(saberes);        
        $("#modalEditar").modal('show');
      }

       function ConfirmarEditar(){

          var codigo = $("#txtCodMateriaEdit").val();  
          var nombre = $("#txtMateriaEdit").val();
          var area = $("#txtAreaEdit").val();  
         var saberes = $("#txtSaberesEdit option:selected").text();  
        
           $("#divCargandoEditar").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Modificando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=editarMateria",
              type: "POST",        
              data: {
                codigo: codigo,
                nombre: nombre,
                area: area,
                saberes: saberes
                
              },          
              dataType: "json",  
              success: function(data, textStatus, jqXHR) {
                $("#divCargandoEditar").html('');
                if(data['request'] == 'ok'){
                  
                    $("#modalEditar").modal('hide')
                   
                    swal("Exito!","Materia modificada correctamente!", {
                      icon: "success",
                      timer: 2000, // Tiempo en milisegundos (3 segundos)
                    });
                    filtrar();
                }
                else{
                        swal("Oops!",data['mensaje'], {
                        icon: "warning",
                      
                    });
                }
              
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  $("#divCargandoEditar").html('');                 
                    swal("Oops!","error de ajax, intenta nuevamente!", {
                      icon: "warning",
                    
                    });
              }

          });

      }

      function filtrar(){

          var nombre = $("#txtNombreActividad").val();
        
          $("#divResultado").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=traerMateria",
              type: "POST",        
              data: {
                nombre:nombre 
              },            
              success: function(data, textStatus, jqXHR) {
            
                $("#divResultado").html('');
                $("#divResultado").html(data);
                FormatoDatatable();
              
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  $("#divResultado").html('<div class="alert alert-danger" role="alert">Algo salio mal!, por favor intente nuevamente</div>');                 
              }
          });
      }

      function FormatoDatatable(){       
            $('#tablaHistorico').DataTable().destroy();
          $('#tablaHistorico').DataTable({ "scrollY": "450px", "scrollX": true });
        
      }
 
      document.getElementById('txtArea').addEventListener('input', function () {
          this.value = this.value.toUpperCase();
      });

       document.getElementById('txtAreaEdit').addEventListener('input', function () {
          this.value = this.value.toUpperCase();
      });

      function verAsignaciones(codMateria, nombreMateria) {
          $("#titleAsignaciones").text("Asignaciones de: " + nombreMateria);
          $("#divAsignaciones").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $("#modalAsignaciones").modal('show');
          
          $.ajax({
              url: "../../respuestaParcial.php?operacion=traerAsignacionesMateria",
              type: "POST",
              data: { codMateria: codMateria },
              success: function(data) {
                  $("#divAsignaciones").html(data);
              },
              error: function() {
                  $("#divAsignaciones").html('<div class="alert alert-danger">Error al cargar las asignaciones.</div>');
              }
          });
      }

  </script>
    
        

      <div class="modal fade" id="modalCrear">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" >Ingresar Datos</h4>
             
            </div>
            <div class="modal-body">             
                <div  class="row"> 
                    <div class="col-md-12 mt-2">
                        <label for="form-label">Nombre Materia</label>
                        <input type="text" class="form-control shadow-lg" id="txtNombre"  >
                    </div>                  

                    <div class="col-md-12 mt-4 text-center">
                        <label for="form-label"><b>Datos para la libreta</b></label>                        
                    </div>    
                   
                    <div class="col-md-12 mt-4">
                        <label for="form-label">Area Curricular</label>
                        <input type="text" class="form-control shadow-lg" id="txtArea" style="text-transform: uppercase;">
                    </div>

                    <div class="col-md-12 mt-2">
                        <label for="form-label">Saberes y Conocimientos</label>
                        <select  id="txtSaberes" class="form-select shadow-lg">
                          <option value="">Seleccionar</option>
                          <option value="">COMUNIDAD Y SOCIEDAD</option>
                          <option value="">CIENCIA TECNOLOGÍA Y PRODUCCIÓN</option>
                          <option value="">VIDA TIERRA TERRITORIO</option>
                          <option value="">COSMOS Y PENSAMIENTO</option>                          
                        </select>
                        
                    </div>    
                </div>     
                <div id="divCargandoCrear"></div>          
            </div>
            <div class="modal-footer col-md-12 mt-3">   
              <button type="button" class="btn btn-primary rounded-button" onclick="ConfirmarRegistrar()">Registrar</button>                     
              <button type="button" class="btn btn-danger rounded-button" data-bs-dismiss="modal">Cerrar</button>            
            </div>
          </div>        
        </div>      
      </div>
     
      <div class="modal fade" id="modalEditar">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" >Editar Datos</h4>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">             
                <div  class="row"> 
                    <input type="hidden" class="form-control" id="txtCodMateriaEdit">
                    <div class="col-md-12 mt-2">
                        <label for="form-label">Nombre Materia</label>
                        <input type="text" class="form-control shadow-lg" id="txtMateriaEdit">
                    </div>                  
               
                     <div class="col-md-12 mt-4 text-center">
                        <label for="form-label"><b>Datos para la libreta</b></label>                        
                    </div> 


                       <div class="col-md-12 mt-4">
                        <label for="form-label">Area Curricular</label>
                        <input type="text" class="form-control shadow-lg" id="txtAreaEdit" style="text-transform: uppercase;">
                    </div>

                    <div class="col-md-12 mt-2">
                        <label for="form-label">Saberes y Conocimientos</label>
                        <select  id="txtSaberesEdit" class="form-select shadow-lg">
                          <option value="">Seleccionar</option>
                          <option>COMUNIDAD Y SOCIEDAD</option>
                          <option>CIENCIA TECNOLOGÍA Y PRODUCCIÓN</option>
                          <option>VIDA TIERRA TERRITORIO</option>
                          <option>COSMOS Y PENSAMIENTO</option>                          
                        </select>
                        
                    </div>    
                   
                </div>     
                <div id="divCargandoEditar"></div>          
            </div>
            <div class="modal-footer col-md-12 mt-3">   
              <button type="button" class="btn btn-primary rounded-button" onclick="ConfirmarEditar()">Confirmar</button>                     
              <button type="button" class="btn btn-danger rounded-button" data-bs-dismiss="modal">Cerrar</button>            
            </div>
          </div>        
        </div>      
      </div>

      <div class="modal fade" id="modalAsignaciones">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="titleAsignaciones">Asignaciones de la Materia</h4>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="divAsignaciones"></div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger rounded-button" data-bs-dismiss="modal">Cerrar</button>
            </div>
          </div>
        </div>
      </div>

</body>

</html>