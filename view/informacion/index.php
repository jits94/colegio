<?php 
 include '../../contenido/sesion.php'; 
include '../../clases/registro.php';
include '../../clases/parametros.php';

$registro = new registro();
$iparametro = new parametros();

$datos = $registro->DatosColegio();
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

    

    <section class="section">
      <div class="row mt-3">
        
 
               

              <div class="col-md-12">
                <div class="card" style='border-top:3px solid blue;'>
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                      <h4 class="card-title">Datos de la Unidad Educativa</h4>
                    </div>
                  </div>
                  <div class="card-body">   
                    <br><br>   
                    <div class="row">     
                         <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label>Código de la Unidad</label>
                                <input id="txtCodigoUnidad"  type="text" class="form-control shadow-lg"  value="<?php echo $datos->codigoUnidad; ?>"/>
                            </div>
                        </div>                                                                          
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label>Unidad Educativa</label>
                                <input id="txtUnidadEducativa"  type="text" class="form-control shadow-lg"  value="<?php echo $datos->unidadEducativa; ?>"/>
                            </div>
                        </div>  
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label>Distrito Educativo</label>
                                <input id="txtDistrito"  type="text" class="form-control shadow-lg"  value="<?php echo $datos->distritoEducativo; ?>"/>
                            </div>
                        </div>
                      
                         <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label>Departamento</label>
                                <select class="form-select shadow-lg" id="txtCodDepartamento"> 
                                    <?php echo $iparametro->DropDownDepartamento($datos->codDepartamento); ?>
                                </select>
                            </div>
                        </div> 
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label>Dependencia</label>
                                <input id="txtDependencia"  type="text" class="form-control shadow-lg"  value="<?php echo $datos->dependencia; ?>"/>
                            </div>
                        </div>  
                       
                        <div class="col-sm-3 mb-3">
                            <div class="form-group">
                                <label>Turno</label>
                                <input id="txtTurno"  type="text" class="form-control shadow-lg"  value="<?php echo $datos->turno; ?>"/>
                            </div>
                        </div>  
                        <div class="col-sm-12 mt-3">
                            <div id='divCargandoCrear'></div>
                        </div>

                        <div class="col-sm-12 mt-3">
                             <button class="btn btn-primary rounded-button" type="button" onclick="ConfirmarRegistrar()">Guardar</button>&nbsp;
                             
                           
                        </div>                     
                    </div>

                   
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

         var codigoUnidad = $("#txtCodigoUnidad").val(); 
        var UnidadEducativa = $("#txtUnidadEducativa").val();  
        var Distrito = $("#txtDistrito").val();  
        var CodDepartamento = $("#txtCodDepartamento").val();  
        var Dependencia = $("#txtDependencia").val();  
        var Turno = $("#txtTurno").val();  
       
        
            // if(nombre == ""){
            //     swal("Debe indicar el nombre de la materia", {
            //             icon: "warning",
                        
            //             });
            //             return;
            // }

       
           $("#divCargandoCrear").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=crearDatosColegio",
              type: "POST",        
              data: {
                codigoUnidad: codigoUnidad,
                UnidadEducativa:UnidadEducativa ,
                Distrito:Distrito ,
                CodDepartamento:CodDepartamento ,
                Dependencia:Dependencia ,
                Turno:Turno
              },          
              dataType: "json",  
              success: function(data, textStatus, jqXHR) {
                $("#divCargandoCrear").html('');
                if(data['request'] == 'ok'){
                   
                    swal("Exito!","Información registrada correctamente!", {
                      icon: "success",
                      timer: 1500, // Tiempo en milisegundos (3 segundos)
                    });
                    
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

      function editarDatos(codMateria,nombre){
        $("#txtCodMateriaEdit").val(codMateria);
        $("#txtMateriaEdit").val(nombre);        
        $("#modalEditar").modal('show');
      }

       function ConfirmarEditar(){

          var codigo = $("#txtCodMateriaEdit").val();  
          var nombre = $("#txtMateriaEdit").val();
         
        
           $("#divCargandoEditar").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Modificando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=editarMateria",
              type: "POST",        
              data: {
                codigo: codigo,
                nombre: nombre
                
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
            $('#tablaHistorico').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                 "dom": '<"row mb-2"<"col-sm-12"l><"col-sm-12"f>>t<"row mt-2"<"col-sm-12"i><"col-sm-12"p>>',

                language: {
                    processing:     "Procesando...",
                    search:         "Buscar:",
                    lengthMenu:     "Mostrar _MENU_ registros",
                    info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                    infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
                    infoFiltered:   "(filtrado de un total de _MAX_ registros)",
                    infoPostFix:    "",
                    loadingRecords: "Cargando...",
                    zeroRecords:    "No se encontraron resultados",
                    emptyTable:     "Ningún dato disponible en esta tabla",
                    paginate: {
                        first:      "Primero",
                        previous:   "Anterior",
                        next:       "Siguiente",
                        last:       "Último"
                    },
                    aria: {
                        sortAscending:  ": Activar para ordenar la columna de manera ascendente",
                        sortDescending: ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });
        
      }
 
  </script>
    
        

      <div class="modal fade" id="modalCrear">
        <div class="modal-dialog modal-sm">
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

                    <div class="col-md-12 mt-2 text-center">
                        <label for="form-label"><b>Nombres para la libreta</b></label>                        
                    </div>    
                   
                    <div class="col-md-12 mt-2">
                        <label for="form-label">Area Curricular</label>
                        <input type="text" class="form-control shadow-lg" id="txtNombre"  >
                    </div>

                    <div class="col-md-12 mt-2">
                        <label for="form-label">Saberes y Conocimientos</label>
                        <input type="text" class="form-control shadow-lg" id="txtNombre"  >
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
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" >Editar Datos</h4>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">             
                <div  class="row"> 
                    <input type="hidden" class="form-control" id="txtCodMateriaEdit">
                    <div class="col-md-12 mt-2">
                        <label for="form-label">Grado</label>
                        <input type="text" class="form-control Shadow-lg" id="txtMateriaEdit">
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

</body>

</html>