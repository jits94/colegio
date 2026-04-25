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
      cursor: pointer; /* Cambia el cursor al pasar sobre el botón */
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
         <div class="col-md-12" style="text-align:left;">
                        <h1>Lista de Profesores</h1>
                    </div>
                    <!-- <div class="col-md-6" style="text-align:right;">
                         <button class="btn btn-primary rounded-button" type="button" onclick="agregar()">Agregar Profesor</button> 
                    </div> --><br>
                          <div class="alert alert-primary d-flex align-items-center" role="alert">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </svg>
  <div>
    Los profesores se agregan al crear un usuario &nbsp;&nbsp; <button class="btn btn-primary rounded-button" type="button" onclick="irUsuario()">Ir a Usuario</button> 
  </div>
</div>                                                                                                              
                </div>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row mt-3">
        

        <div class="col-lg-12">     

          <div class="card shadow-lg" style="border-top:solid 3px blue;">
            <div class="card-body">
             
             
                <div class="row" style='display:none;'>
                    <div class="col-md-4 mt-2">
                        <label for="form-label">Grado</label>
                        <select  id="txtCodGradoFiltro" class="form-select shadow-lg">
                            <?php echo $iparametro->DropDownCursos(); ?>
                        </select>
                    </div> 
                    <div class="col-md-4 mt-2">
                        <label for="form-label">Estado</label>
                        <select  id="txtEstadoFiltro" class="form-select shadow-lg">
                            <option value="">Todos</option>
                            <option value="0" selected >Activos</option>
                            <option value="1">Eliminados</option>
                        </select>
                    </div>   
                     <div class="col-md-4 mt-3" style="text-align:right;">
                         <button class="btn btn-secondary rounded-button" type="button" onclick="filtrar()">Filtrar</button> 
                    </div> 
                </div>
              <br>
              <h4>Resultado</h4>
                <!-- Table with stripped rows -->

              
             
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
        
      })
 
      function irUsuario(){

        window.open('../usuario/');
      }

      
      function agregar(){

        $("#modalCrear").modal('show');
      }

      

      function ConfirmarRegistrar(){

       
        var nombre = $("#txtNombre").val();
       
        

          if(nombre == ""){
             swal("Oops!!","Debe ingresar el nombre", {
                      icon: "warning",
                    
                    });
                    return;
        }

      
           $("#divCargandoCrear").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=crearProfesor",
              type: "POST",        
              data: {                     
                nombre:nombre
              },          
              dataType: "json",  
              success: function(data, textStatus, jqXHR) {
                $("#divCargandoCrear").html('');
                if(data['request'] == 'ok'){
                    //$("#txtCodGrado").val('0');  
                   $("#txtNombre").val("");
                    
                    $("#modalCrear").modal('hide');
                   
                    swal("Exito!", "Profesor registrado correctamente!", {
                        icon: "success",
                        timer: 800 
                    });
 
                    filtrar();
                }
                else{
                    swal("Oops!",data['mensaje'], {
                        icon: "warning",
                      
                    })
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

        function ActivarDato(codigo,nombre){
               swal({
                title: "Confirmar ",
               text: "¿Seguro que deseas activar al profesor "+nombre+"?",
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
                        confirmarActivarProfesor(codigo);                      
                    } else {
                        swal.close();
                    }
                });

        }

        function confirmarActivarProfesor(codigo){

          
             $.ajax({
              url: "../../respuestaParcial.php?operacion=ActivarProfesor",
              type: "POST",  
              dataType: "json",      
              data: {
                codigo:codigo                 
              },            
              success: function(data, textStatus, jqXHR) {
            
                if(data['request'] == 'ok'){
                   swal("Exito!", "El Profesor fue habilitado correctamente", {
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



        function eliminarDato(codigo,nombre){
           
               swal({
                title: "Confirmar ",
                text: "¿Seguro que deseas eliminar al Profesor "+nombre+"?",
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
                        confirmareliminarProfesor(codigo);                      
                    } else {
                        swal.close();
                    }
                });

        }

        function confirmareliminarProfesor(codigo){

          
             $.ajax({
              url: "../../respuestaParcial.php?operacion=eliminarProfesor",
              type: "POST",  
              dataType: "json",      
              data: {
                codigo:codigo                 
              },            
              success: function(data, textStatus, jqXHR) {
            
                if(data['request'] == 'ok'){
                   swal("Exito!", "El Profesor fue eliminado correctamente", {
                       icon: "success",
                       buttons: { confirm: { className: "btn btn-success" } },
                       timer: 2000
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

      function editarDatos(id,nombres){
        $("#txtidEdit").val(id);
        
        $("#txtNombreEdit").val(nombres);
        
        $("#modalEditar").modal('show');
      }

       function ConfirmarEditar(){

         var codigo = $("#txtidEdit").val();
         
          var nombres = $("#txtNombreEdit").val();
        
        
           $("#divCargandoEditar").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Modificando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=editarProfesor",
              type: "POST",        
              data: {
                codigo: codigo,               
                nombres: nombres 
              },          
              dataType: "json",  
              success: function(data, textStatus, jqXHR) {
                $("#divCargandoEditar").html('');
                if(data['request'] == 'ok'){
                  
                    $("#modalEditar").modal('hide')
                   
                    swal("Exito!","Profesor modificado correctamente!", {
                      icon: "success",
                      timer: 100, // Tiempo en milisegundos (3 segundos)
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

           var codCurso = $("#txtCodGradoFiltro").val();
        //   var estado = $("#txtEstadoFiltro").val();
        
        //     if(codCurso == "0"){
        //      swal("Oops!!","Debe seleccionar algun grado para ver los Profesors", {
        //               icon: "warning",
                    
        //             });
        //             return;
        //     }

          $("#divResultado").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=traerProfesor",
              type: "POST",        
              data: {
                codCurso:codCurso 
                
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
            // $('#tablaHistorico').DataTable({
            //     "paging": true,
            //     "lengthChange": false,
            //     "searching": true,
            //     "ordering": true,
            //     "info": true,
            //      "dom": '<"row mb-2"<"col-sm-12"l><"col-sm-12"f>>t<"row mt-2"<"col-sm-12"i><"col-sm-12"p>>',

            //     language: {
            //         processing:     "Procesando...",
            //         search:         "Buscar:",
            //         lengthMenu:     "Mostrar _MENU_ registros",
            //         info:           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            //         infoEmpty:      "Mostrando registros del 0 al 0 de un total de 0 registros",
            //         infoFiltered:   "(filtrado de un total de _MAX_ registros)",
            //         infoPostFix:    "",
            //         loadingRecords: "Cargando...",
            //         zeroRecords:    "No se encontraron resultados",
            //         emptyTable:     "Ningún dato disponible en esta tabla",
            //         paginate: {
            //             first:      "Primero",
            //             previous:   "Anterior",
            //             next:       "Siguiente",
            //             last:       "Último"
            //         },
            //         aria: {
            //             sortAscending:  ": Activar para ordenar la columna de manera ascendente",
            //             sortDescending: ": Activar para ordenar la columna de manera descendente"
            //         }
            //     }
            // });
        
      }
 

        function verCurso(id,nombres){
        $("#txtcodProfesorAddCurso").val(id);        
        $("#txtNombreAddCurso").val(nombres);
        
          traerCurso();
        $("#modalVerCurso").modal('show');
      }

       function traerCurso(){

           var codProfesor = $("#txtcodProfesorAddCurso").val();
       

          $("#divResultadoCurso").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=traerCursoTutor",
              type: "POST",        
              data: {
                codProfesor:codProfesor 
                
              },            
              success: function(data, textStatus, jqXHR) {
            
                $("#divResultadoCurso").html('');
                $("#divResultadoCurso").html(data);
                FormatoDatatableMaterias('tablaCurso');
              
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  $("#divResultado").html('<div class="alert alert-danger" role="alert">Algo salio mal!, por favor intente nuevamente</div>');                 
              }
          });
      }


      function AgregarCurso(){
        $("#modalAgregarCurso").modal('show');
        $("#modalVerCurso").modal('hide');
      }

      function ConfirmarRegistrarCurso(){

       
        var codProfesor = $("#txtcodProfesorAddCurso").val();
        var CodGrado = $("#txtCodGrado2").val();
       

        if(CodGrado == "0"){
            swal("Oops!!","Debe seleccionar un grado", {
                icon: "warning",                    
            });
            return;
        }

      
      
          $("#divCargandoCrear").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=crearCursoTutor",
              type: "POST",        
              data: {                     
                codProfesor:codProfesor,
                CodGrado:CodGrado
              },          
              dataType: "json",  
              success: function(data, textStatus, jqXHR) {
                $("#divCargandoCrear").html('');
                if(data['request'] == 'ok'){
                    $("#txtCodGrado2").val('0');  
                 
                    $("#modalAgregarCurso").modal('hide');
                    $("#modalVerCurso").modal('show');
                    swal("Exito!", "Registrado correctamente!", {
                        icon: "success",
                        timer: 500 
                    });
 
                    traerCurso();
                }
                else{
                    swal("Oops!",data['mensaje'], {
                        icon: "warning",
                      
                    })
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


         function ActivarDatoCurso(codigo,grado){
               swal({
                title: "Confirmar ",
               text: "¿Seguro que deseas activar el curso  de "+grado+"?",
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
                        confirmarActivarCurso(codigo);                      
                    } else {
                        swal.close();
                    }
                });

        }

        function confirmarActivarCurso(codigo){

          
             $.ajax({
              url: "../../respuestaParcial.php?operacion=ActivarCursoTutor",
              type: "POST",  
              dataType: "json",      
              data: {
                codigo:codigo                 
              },            
              success: function(data, textStatus, jqXHR) {
            
                if(data['request'] == 'ok'){
                   swal("Exito!", "Habilitado correctamente", {
                       icon: "success",
                       buttons: { confirm: { className: "btn btn-success" } },
                       timer: 1500
                   });
                  traerCurso();
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



        function eliminarDatoCurso(codigo,grado){
           
               swal({
                title: "Confirmar ",
                text: "¿Seguro que deseas eliminar el curos de "+grado+"?",
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
                        confirmareliminarCurso(codigo);                      
                    } else {
                        swal.close();
                    }
                });

        }

        function confirmareliminarCurso(codigo){

          
             $.ajax({
              url: "../../respuestaParcial.php?operacion=eliminarCursoTutor",
              type: "POST",  
              dataType: "json",      
              data: {
                codigo:codigo                 
              },            
              success: function(data, textStatus, jqXHR) {
            
                if(data['request'] == 'ok'){
                   swal("Exito!", "Eliminado correctamente", {
                       icon: "success",
                       buttons: { confirm: { className: "btn btn-success" } },
                       timer: 2000
                   });
                  traerCurso();
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


        ///////////// materia curso ////////////////////
       function verMateria(id,nombres){
        $("#txtcodProfesorAddMateria").val(id);        
        $("#txtNombreAddMateria").val(nombres);
        
          traerMateriasCurso();
        $("#modalVerMaterias").modal('show');
      }

       function traerMateriasCurso(){

           var codProfesor = $("#txtcodProfesorAddMateria").val();
       

          $("#divResultadoMaterias").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=traerMateriasProfesor",
              type: "POST",        
              data: {
                codProfesor:codProfesor 
                
              },            
              success: function(data, textStatus, jqXHR) {
            
                $("#divResultadoMaterias").html('');
                $("#divResultadoMaterias").html(data);
                FormatoDatatableMaterias('tablaMaterias');
              
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  $("#divResultado").html('<div class="alert alert-danger" role="alert">Algo salio mal!, por favor intente nuevamente</div>');                 
              }
          });
      }

        function FormatoDatatableMaterias(tabla){       
            $('#'+tabla).DataTable().destroy();
            $('#'+tabla).DataTable({
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": false,
                "scrollX": true,
                "dom": '<"row mb-2"<"col-sm-12"l><"col-sm-12"f>>t<"row mt-2"<"col-sm-12"i><"col-sm-12"p>>',
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json"
                }
            });
        }

        // Adjust columns when modals are shown to fix alignment issues
        $(document).on('shown.bs.modal', '.modal', function () {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        });

      function AgregarMateria(){
        $("#modalAgregarMaterias").modal('show');
        $("#modalVerMaterias").modal('hide');
      }

      function ConfirmarRegistrarMateria(){

       
        var codProfesor = $("#txtcodProfesorAddMateria").val();
        var CodGrado = $("#txtCodGrado").val();
        var CodMateria = $("#txtCodMateria").val();
         var gestion = $("#txtGestion").val();

        if(CodGrado == "0"){
            swal("Oops!!","Debe seleccionar un grado", {
                icon: "warning",                    
            });
            return;
        }

        if(CodMateria == "0"){
            swal("Oops!!","Debe seleccionar una materia", {
                icon: "warning",                    
            });
            return;
        }

        if(gestion == ""){
            swal("Oops!!","Debe indicar la gestión", {
                icon: "warning",                    
            });
            return;
        }
      
          $("#divCargandoCrear").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=crearCursoMateria",
              type: "POST",        
              data: {                     
                codProfesor:codProfesor,
                CodGrado:CodGrado,
                CodMateria:CodMateria,
                gestion: gestion
              },          
              dataType: "json",  
              success: function(data, textStatus, jqXHR) {
                $("#divCargandoCrear").html('');
                if(data['request'] == 'ok'){
                    $("#txtCodGrado").val('0');  
                    $("#txtCodMateria").val("0");
                   

                    $("#modalAgregarMaterias").modal('hide');
                    $("#modalVerMaterias").modal('show');
                    swal("Exito!", "Registrado correctamente!", {
                        icon: "success",
                        timer: 500 
                    });
 
                    traerMateriasCurso();
                }
                else{
                    swal("Oops!",data['mensaje'], {
                        icon: "warning",
                      
                    })
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


         function ActivarDatoMateria(codigo,nombre,grado){
               swal({
                title: "Confirmar ",
               text: "¿Seguro que deseas activar la materia de "+nombre+" de "+grado+"?",
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
                        confirmarActivarCursoMateria(codigo);                      
                    } else {
                        swal.close();
                    }
                });

        }

        function confirmarActivarCursoMateria(codigo){

          
             $.ajax({
              url: "../../respuestaParcial.php?operacion=ActivarCursoMateria",
              type: "POST",  
              dataType: "json",      
              data: {
                codigo:codigo                 
              },            
              success: function(data, textStatus, jqXHR) {
            
                if(data['request'] == 'ok'){
                   swal("Exito!", "Habilitado correctamente", {
                       icon: "success",
                       buttons: { confirm: { className: "btn btn-success" } },
                       timer: 1500
                   });
                  traerMateriasCurso();
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



        function eliminarDatoMateria(codigo,nombre,grado){
           
               swal({
                title: "Confirmar ",
                text: "¿Seguro que deseas eliminar la materia de "+nombre+" de "+grado+"?",
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
                        confirmareliminarCursoMateria(codigo);                      
                    } else {
                        swal.close();
                    }
                });

        }

        function confirmareliminarCursoMateria(codigo){

          
             $.ajax({
              url: "../../respuestaParcial.php?operacion=eliminarCursoMateria",
              type: "POST",  
              dataType: "json",      
              data: {
                codigo:codigo                 
              },            
              success: function(data, textStatus, jqXHR) {
            
                if(data['request'] == 'ok'){
                   swal("Exito!", "Eliminado correctamente", {
                       icon: "success",
                       buttons: { confirm: { className: "btn btn-success" } },
                       timer: 2000
                   });
                  traerMateriasCurso();
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

  </script>
    

    <div class="modal fade" id="modalVerCurso">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" >Cursos</h4>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">             
                <div  class="row mb-3"> 
                    <input type="hidden" class="form-control" id="txtcodProfesorAddCurso">
                                 
                    <div class="col-md-4 mt-2">
                        <label for="form-label">Nombre Profesor</label>                      
                        <input type="text" class="form-control shadow-lg" disabled id="txtNombreAddCurso">
                    </div>                        
                </div>     
                <div id="divResultadoCurso"></div>          
            </div>
            <div class="modal-footer col-md-12 mt-3">   
              <button type="button" class="btn btn-primary rounded-button" onclick="AgregarCurso()">Agregar Curso</button>                     
              <button type="button" class="btn btn-danger rounded-button" data-bs-dismiss="modal">Cerrar</button>            
            </div>
          </div>        
        </div>      
      </div>

        <div class="modal fade" id="modalAgregarCurso">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" >Ingresar Cursos</h4>             
            </div>
            <div class="modal-body">             
                <div  class="row"> 
                                
                     <div class="col-md-12 mt-2">
                        <label for="form-label">Grado</label>
                        <select  id="txtCodGrado2" class="form-select shadow-lg">
                            <?php echo $iparametro->DropDownCursos(); ?>
                        </select>
                    </div>                                             
                </div>     
                <div id="divCargandoAddCurso"></div>          
            </div>
            <div class="modal-footer col-md-12 mt-3">   
              <button type="button" class="btn btn-primary rounded-button" onclick="ConfirmarRegistrarCurso()">Registrar</button>                     
              <button type="button" class="btn btn-danger rounded-button" data-bs-target="#modalVerCurso" data-bs-toggle="modal" data-bs-dismiss="modal">Volver</button>            
            </div>
          </div>        
        </div>      
      </div>


        
      <div class="modal fade" id="modalVerMaterias">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" >Materias Habilitadas</h4>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">             
                <div  class="row mb-3"> 
                    <input type="hidden" class="form-control" id="txtcodProfesorAddMateria">
                                 
                    <div class="col-md-4 mt-2">
                        <label for="form-label">Nombre Profesor</label>
                        <input type="text" class="form-control shadow-lg" disabled id="txtNombreAddMateria">
                    </div>                        
                </div>     
                <div id="divResultadoMaterias"></div>          
            </div>
            <div class="modal-footer col-md-12 mt-3">   
              <button type="button" class="btn btn-primary rounded-button" onclick="AgregarMateria()">Agregar Materia</button>                     
              <button type="button" class="btn btn-danger rounded-button" data-bs-dismiss="modal">Cerrar</button>            
            </div>
          </div>        
        </div>      
      </div>

        <div class="modal fade" id="modalAgregarMaterias">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" >Ingresar Materias</h4>             
            </div>
            <div class="modal-body">             
                <div  class="row"> 
                                
                     <div class="col-md-12 mt-2">
                        <label for="form-label">Grado</label>
                        <select  id="txtCodGrado" class="form-select shadow-lg">
                            <?php echo $iparametro->DropDownCursos(); ?>
                        </select>
                    </div>    
                       <div class="col-md-12 mt-2">
                        <label for="form-label">Materia</label>
                        <select  id="txtCodMateria" class="form-select shadow-lg">
                            <?php echo $iparametro->DropDownMateria(); ?>
                        </select>
                    </div>    
                      <div class="col-md-12 mt-2">
                        <label for="form-label">Gestion</label>
                        <input type="gestion" id="txtGestion"  class="form-control shadow-lg" value="<?php echo date('Y'); ?>">                        
                    </div>    
                </div>     
                <div id="divCargandoAddMaterias"></div>          
            </div>
            <div class="modal-footer col-md-12 mt-3">   
              <button type="button" class="btn btn-primary rounded-button" onclick="ConfirmarRegistrarMateria()">Registrar</button>                     
              <button type="button" class="btn btn-danger rounded-button" data-bs-target="#modalVerMaterias" data-bs-toggle="modal" data-bs-dismiss="modal">Volver</button>            
            </div>
          </div>        
        </div>      
      </div>


      <div class="modal fade" id="modalCrear">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" >Ingresar Datos</h4>
             
            </div>
            <div class="modal-body">             
                <div  class="row"> 
                                
                     <div class="col-md-12 mt-2">
                        <label for="form-label">Nombres</label>
                        <input type="text" class="form-control shadow-lg" id="txtNombre">
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
                    <input type="hidden" class="form-control" id="txtidEdit">
                                 
                     <div class="col-md-12 mt-2">
                        <label for="form-label">Nombre</label>
                        <input type="text" class="form-control shadow-lg" id="txtNombreEdit">
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