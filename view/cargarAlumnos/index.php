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
                        <h1>Cargar Lista de Alumnos</h1>
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
                        <label for="form-label">Seleccionar Archivo CSV</label>
                        <input type="file" id="archivo" class="form-control shadow-lg" accept=".csv">                          
                    </div>   
                     <div class="col-md-4 mt-3" style="text-align:right;">
                         <button class="btn btn-secondary rounded-button" type="button"id="btnPreview"  >Previsualizar</button> 
                        
                    </div> 
                </div>
 
                <hr>
                 <div class="row">
                   
                     <div class="col-md-12 mt-3" style="text-align:right;">
                         
                         <button class="btn btn-primary rounded-button" type="button" id="btnGuardar" style="display:none;" onclick="filtrar2()">Guardar Alumnos</button> 
                    </div> 
                </div>

             
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
 
      
      function agregar(){

        $("#modalCrear").modal('show');
      }

        let datosCSV = [];

        $('#btnPreview').click(function () {

            let file = $('#archivo')[0].files[0];
            let codGrado = $('#txtCodGradoFiltro').val();
            
            if (codGrado == '' || codGrado == 0) {
                 swal("Oops!!","Debe seleccionar un grado", {
                      icon: "warning",                    
                    });
                    return;                 
            }

            if (!file) {
                 swal("Oops!!","Seleccione un archivo CSV", {
                      icon: "warning",                    
                    });
                    return;                 
            }

            let formData = new FormData();
            formData.append('archivo', file);

            cargando('Cargando Datos del Excel');

            $.ajax({
                url: "preview_csv.php",
                type: "POST",        
                data: formData,          
                dataType: "json",  
                         contentType: false,
                        processData: false,
                success: function(data, textStatus, jqXHR) {

                    // $.ajax({
                    //     url: 'preview_csv.php',
                    //     type: 'POST',
                    //     dataType: 'json',
                    //     data: formData,
                    //     contentType: false,
                    //     processData: false,
                    //     success: function (data) {
                    //        // let data = JSON.parse(resp);
                    Swal.close();
                 

                    if (data['errores'] > 0) {
                        mensajeError('Oops!',data['mensajeError']);                     
                        
                    }
                    else{
                         $('#btnGuardar').show();
                        mensajeExito('Excel cargado');
                    }
                       $('#divResultado').html('');
                    datosCSV = data['filas'];
                    $('#divResultado').html(data['html']);
                    FormatoDatatable();
                    
                   
                },
                  error: function(xhr, status, error) {
                    // Si hubo un error también cerramos el Swal
                    Swal.close();
                     mensajeError('Oops!','Ocurrió un error en la petición');     
                    
                }
            });
        });

        $('#btnGuardar').click(function () {

         
            let codGrado = $('#txtCodGradoFiltro').val();
           cargando('Guardando Información');
            $.ajax({
                url: '../../respuestaParcial.php?operacion=guardarAlumnos_csv',
                type: 'POST',
                dataType:'json',
                data: { 
                    filas: datosCSV,
                    codGrado: codGrado
                },
                success: function (data) {
                    Swal.close();
                 
                    if (data['request'] == 'ok') {
                        $('#btnGuardar').show();
                        mensajeExito('Datos guardados correctamente');   
                         $('#btnGuardar').hide('slow');
                          $('#divResultado').html(''); 
                    }
                    else{
                         if (data['request'] == 'duplicado') {
                           Swal.fire({
                                icon: 'warning',
                                title: 'Registros Existentes',
                                html: `Los siguientes alumnos ya estan registrados: <ul style="text-align:left">${data['mensaje']}</ul>`
                            });
                        }
                        else{
                            mensajeError('Oops!',data['mensaje']);                                                
                        }                                          
                    }
                },
                 error: function(xhr, status, error) {
                    // Si hubo un error también cerramos el Swal
                    Swal.close();
                     mensajeError('Oops!','Ocurrió un error en la petición');     
                    
                }
            });
        });

      function ConfirmarRegistrar(){

         var codGrado = $("#txtCodGrado").val();  
           var codProfesor = $("#txtCodProfesor").val();  
        var nombre = $("#txtNombre").val();
          var apellido = $("#txtApellidos").val();
        
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
           $("#divCargandoCrear").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=crearAlumno",
              type: "POST",        
              data: {
                    codGrado:codGrado,
                    codProfesor: codProfesor,
                    nombre:nombre,
                    apellido:apellido
              },          
              dataType: "json",  
              success: function(data, textStatus, jqXHR) {
                $("#divCargandoCrear").html('');
                if(data['request'] == 'ok'){
                    //$("#txtCodGrado").val('0');  
                   $("#txtNombre").val("");
                    $("#txtApellidos").val('');
                    //$("#modalCrear").modal('hide');
                   
                    swal("Exito!", "Alumno registrado correctamente!", {
                        icon: "success",
                        timer: 800,
                        buttons: false
                    });

                    setTimeout(function () {
                        $("#txtNombre").val('').focus();
                    }, 900); // mayor al timer

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