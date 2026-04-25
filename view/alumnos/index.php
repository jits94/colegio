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
         <div class="col-md-6" style="text-align:left;">
                        <h1>Lista de Alumnos</h1>
                    </div>
                    <div class="col-md-6" style="text-align:right;">
                         <button class="btn btn-primary rounded-button" type="button" onclick="agregar()">Agregar Alumnos</button> 
                           &nbsp; <button class="btn btn-success rounded-button" type="button" onclick="excel()">Cargar Excel</button> 
                    </div>
                                                                                                                                        
                </div>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row mt-3">
        

        <div class="col-lg-12">     

          <div class="card shadow-lg" style="border-top:solid 3px blue;">
            <div class="card-body">
             
             
                <div class="row">
                    <div class="col-md-4 mt-2">
                        <label for="form-label">Grado</label>
                        <select  id="txtCodGradoFiltro" class="form-select shadow-lg">
                            <?php echo $iparametro->DropDownCursos($_SESSION['codTipoUsuario'],$_SESSION['codigousuario']); ?>
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
                     <div class="col-md-4 mt-2">
                        <label for="form-label">Gestión</label>
                        <input type="number" class="form-control shadow-lg" id="txtGestionFiltro" value="<?php echo date('Y'); ?>">
                        
                    </div>  
                    
                </div>
                 <div class="row">
                  <div class="col-md-12 mt-3" style="text-align:right;">
                         <button class="btn btn-secondary rounded-button" type="button" onclick="filtrar()">Filtrar</button> 
                    </div> 
               </div>
                <!-- Table with stripped rows -->

                <hr>
               
             
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

         $("#txtNombre").keydown(function(event) {
            if (event.keyCode === 13) { // 13 = Enter
                event.preventDefault(); // evita que se envíe el formulario
               ConfirmarRegistrar();
               
            }
        });

          $("#txtApellidos").keydown(function(event) {
            if (event.keyCode === 13) { // 13 = Enter
                event.preventDefault(); // evita que se envíe el formulario
               ConfirmarRegistrar();
                
            }
        });


           $("#txtRude").keydown(function(event) {
            if (event.keyCode === 13) { // 13 = Enter
                event.preventDefault(); // evita que se envíe el formulario
               ConfirmarRegistrar();
                
            }
        });

          $("#txtGestion").keydown(function(event) {
            if (event.keyCode === 13) { // 13 = Enter
                event.preventDefault(); // evita que se envíe el formulario
               ConfirmarEditar();
                
            }
        });

          $("#txtNombreEdit").keydown(function(event) {
            if (event.keyCode === 13) { // 13 = Enter
                event.preventDefault(); // evita que se envíe el formulario
               ConfirmarEditar();
               
            }
        });

          $("#txtApellidosEdit").keydown(function(event) {
            if (event.keyCode === 13) { // 13 = Enter
                event.preventDefault(); // evita que se envíe el formulario
               ConfirmarEditar();
                
            }
        });

            $("#txtRudeEdit").keydown(function(event) {
            if (event.keyCode === 13) { // 13 = Enter
                event.preventDefault(); // evita que se envíe el formulario
               ConfirmarEditar();
                
            }
        });

              $("#txtGestionEdit").keydown(function(event) {
            if (event.keyCode === 13) { // 13 = Enter
                event.preventDefault(); // evita que se envíe el formulario
               ConfirmarEditar();
                
            }
        });

        //filtrar();
        
      })

      
      function excel(){

        window.open('../cargarAlumnos/');
      }

       function agregar(){

        $("#modalCrear").modal('show');
      }

      function ConfirmarRegistrar(){

         var codGrado = $("#txtCodGrado").val();  
           var codProfesor = $("#txtCodProfesor").val();  
        var nombre = $("#txtNombre").val();
          var apellido = $("#txtApellidos").val();
          var rude = $("#txtRude").val();
        var gestion = $("#txtGestion").val();

        if(codGrado == "0"){
             swal("Oops!!","Debe seleccionar un grado", {
                      icon: "warning",
                    
                    });
                    return;
        }

        //   if(codProfesor == "0"){
        //      swal("Oops!!","Debe seleccionar un profesor(a)", {
        //               icon: "warning",
                    
        //             });
        //             return;
        // }

          if(nombre == ""){
             swal("Oops!!","Debe ingresar el nombre", {
                      icon: "warning",
                    
                    });
                    return;
        }

         if(apellido == ""){
             swal("Oops!!","Debe ingresar el apellido", {
                      icon: "warning",
                    
                    });
                    return;
        }

        if(rude == ""){
             swal("Oops!!","Debe ingresar el codigo rude", {
                      icon: "warning",
                    
                    });
                    return;
        }

           if(gestion == ""){
             swal("Oops!!","Debe ingresar la gestión", {
                      icon: "warning",
                    
                    });
                    return;
        }

           $("#divCargandoCrear").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=crearAlumno",
              type: "POST",        
              data: {
                    codGrado:codGrado,
                    codProfesor: codProfesor,
                    nombre:nombre,
                    apellido:apellido,
                    rude: rude,
                    gestion: gestion
              },          
              dataType: "json",  
              success: function(data, textStatus, jqXHR) {
                $("#divCargandoCrear").html('');
                if(data['request'] == 'ok'){
                    //$("#txtCodGrado").val('0');  
                   $("#txtNombre").val("");
                    $("#txtApellidos").val('');
                    $("#txtRude").val('');
                    //$("#modalCrear").modal('hide');
                   
                    swal("Exito!", "Alumno registrado correctamente!", {
                        icon: "success",
                        timer: 800,
                        buttons: false
                    });

                    setTimeout(function () {
                        $("#txtNombre").val('').focus();
                    }, 900); // mayor al timer

                   // filtrar();
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
               text: "¿Seguro que deseas activar al alumno "+nombre+"?",
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
                        confirmarActivarAlumno(codigo);                      
                    } else {
                        swal.close();
                    }
                });

        }

        function confirmarActivarAlumno(codigo){

          
             $.ajax({
              url: "../../respuestaParcial.php?operacion=ActivarAlumno",
              type: "POST",  
              dataType: "json",      
              data: {
                codigo:codigo                 
              },            
              success: function(data, textStatus, jqXHR) {
            
                if(data['request'] == 'ok'){
                   swal("Exito!", "El alumno fue habilitado correctamente", {
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
                text: "¿Seguro que deseas eliminar al alumno "+nombre+"?",
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
                        confirmareliminarAlumno(codigo);                      
                    } else {
                        swal.close();
                    }
                });

        }

        function confirmareliminarAlumno(codigo){

          
             $.ajax({
              url: "../../respuestaParcial.php?operacion=eliminarAlumno",
              type: "POST",  
              dataType: "json",      
              data: {
                codigo:codigo                 
              },            
              success: function(data, textStatus, jqXHR) {
            
                if(data['request'] == 'ok'){
                   swal("Exito!", "El alumno fue eliminado correctamente", {
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

      function editarDatos(id,codCurso,codProfesor,nombres,apellidos,rude,gestion){
        $("#txtidEdit").val(id);
        $("#txtCodGradoEdit").val(codCurso);
        $("#txtCodProfesorEdit").val(codProfesor);
        $("#txtNombreEdit").val(nombres);
        $("#txtApellidosEdit").val(apellidos);
        $("#txtRudeEdit").val(rude);
        $("#txtGestionEdit").val(gestion);
        $("#modalEditar").modal('show');
      }

       function ConfirmarEditar(){

         var codigo = $("#txtidEdit").val();
          var codCurso = $("#txtCodGradoEdit").val();  
           var codProfesor = $("#txtCodProfesorEdit").val();  
          var nombres = $("#txtNombreEdit").val();
          var apellidos = $("#txtApellidosEdit").val();
          var rude = $("#txtRudeEdit").val();
          var gestion = $("#txtGestionEdit").val();

           $("#divCargandoEditar").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Modificando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=editarAlumno",
              type: "POST",        
              data: {
                codigo: codigo,
                codProfesor: codProfesor,
                codCurso: codCurso,
                nombres: nombres,
                apellidos: apellidos,
                 rude: rude,
                 gestion: gestion
              },          
              dataType: "json",  
              success: function(data, textStatus, jqXHR) {
                $("#divCargandoEditar").html('');
                if(data['request'] == 'ok'){
                  
                    $("#modalEditar").modal('hide')
                   
                    swal("Exito!","Alumno modificado correctamente!", {
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

       function traerCursosHabilitados(){

          var codProfesor = $("#txtCodProfesor").val();
          
         // $("#divResultado").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=traerCursosHabilitados",
              type: "POST",        
              data: {
                codProfesor:codProfesor 
                
              },            
              success: function(data, textStatus, jqXHR) {
            
                $("#txtCodGrado").html('');
                $("#txtCodGrado").html(data);
              
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  swal("Oops!","error de ajax, intenta nuevamente!", {
                      icon: "warning",
                    
                    });             
              }
          });
      }


      function filtrar(){

          var codCurso = $("#txtCodGradoFiltro").val();
            var estado = $("#txtEstadoFiltro").val();
          var gestion = $("#txtGestionFiltro").val();
        
            if(codCurso == "0"){
             swal("Oops!!","Debe seleccionar algun grado para ver los alumnos", {
                      icon: "warning",
                    
                    });
                    return;
            }
             if(gestion == ""){
             swal("Oops!!","Debe ingresar la gestion para ver los alumnos", {
                      icon: "warning",
                    
                    });
                    return;
            }

          $("#divResultado").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=traerAlumnos",
              type: "POST",        
              data: {
                codCurso:codCurso,
                estado:estado,
                gestion: gestion
                
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
 
  </script>
    
        

      <div class="modal fade" id="modalCrear">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" >Ingresar Datos</h4>             
            </div>
            <div class="modal-body">             
                <div  class="row"> 
                    <div class="col-md-12 mt-2" style="display:none">
                        <label for="form-label">Profesor</label>
                        <select  id="txtCodProfesor" class="form-select shadow-lg" onchange="traerCursosHabilitados()">
                            <?php echo $iparametro->DropDownProfesor(); ?>
                        </select>
                    </div>        
                    <div class="col-md-12 mt-2">
                        <label for="form-label">Grado</label>
                        <select  id="txtCodGrado" class="form-select shadow-lg">
                            <?php  echo $iparametro->DropDownCursos(); ?>
                        </select>
                    </div>     
                        
                     <div class="col-md-12 mt-2">
                        <label for="form-label">Nombres</label>
                        <input type="text" class="form-control shadow-lg" id="txtNombre">
                    </div>  
                      <div class="col-md-12 mt-2">
                        <label for="form-label">Apellidos</label>
                        <input type="text" class="form-control shadow-lg" id="txtApellidos">
                    </div>  
                       <div class="col-md-12 mt-2">
                        <label for="form-label">Código Rude</label>
                        <input type="number" class="form-control shadow-lg" id="txtRude">
                    </div>  

                         <div class="col-md-12 mt-2">
                        <label for="form-label">Gestión</label>
                        <input type="number" class="form-control shadow-lg" id="txtGestion" value="<?php echo date("Y") ?>">
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
                        <label for="form-label">Grado</label>
                        <select  id="txtCodGradoEdit" class="form-select shadow-lg">
                            <?php echo $iparametro->DropDownCursos(); ?>
                        </select>
                    </div>    
                       <div class="col-md-12 mt-2" style="display: none;">
                        <label for="form-label">Profesor</label>
                        <select  id="txtCodProfesorEdit" class="form-select shadow-lg">
                            <?php echo $iparametro->DropDownProfesor(); ?>
                        </select>
                    </div>                
                     <div class="col-md-12 mt-2">
                        <label for="form-label">Nombres</label>
                        <input type="text" class="form-control shadow-lg" id="txtNombreEdit">
                    </div>  
                      <div class="col-md-12 mt-2">
                        <label for="form-label">Apellidos</label>
                        <input type="text" class="form-control shadow-lg" id="txtApellidosEdit">
                    </div>  
                     <div class="col-md-12 mt-2">
                        <label for="form-label">Código Rude</label>
                        <input type="number" class="form-control shadow-lg" id="txtRudeEdit">
                    </div>  
                     <div class="col-md-12 mt-2">
                        <label for="form-label">Gestión</label>
                        <input type="number" class="form-control shadow-lg" id="txtGestionEdit" value="<?php echo date("Y") ?>">
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