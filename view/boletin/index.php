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
      
      <h1>Generar Boletin</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row mt-3">
           <div class="alert alert-primary d-flex align-items-center" role="alert">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
    <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
  </svg>&nbsp;&nbsp;
  <div>
    Para ver el boletin en pantalla debe seleccionar el grado y alumno <br>
    Para generar el boletin en pdf debe seleccionar el grado y si no selecciona alumno generara de todo el curso
  </div>
</div>  
<br>

        <div class="col-lg-12">     

          <div class="card shadow-lg" style="border-top:solid 3px blue;">
            <div class="card-body">
              <br>
               <div class="row">
                                   
                    <div class="col-md-4 mt-2">
                        <label for="form-label">Grado</label>
                        <select  id="txtCodGradoFiltro" class="form-select shadow-lg" onchange="traerAlumnosHabilitados()">
                            <?php echo $iparametro->DropDownCursos($_SESSION['codTipoUsuario'],$_SESSION['codigousuario']); ?>
                        </select>
                    </div> 
                      <div class="col-md-4 mt-2">
                        <label for="form-label">Alumnos</label>
                        <select  id="txtCodAlumnoFiltro" class="form-select shadow-lg" >
                            <option value="0">Seleccionar</option>
                            <?php //echo $iparametro->DropDownCursos(); ?>
                        </select>
                    </div> 
                    <div class="col-md-4 mt-2">
                        <label for="form-label">Gestion</label>
                        <input type="number" id="txtGestionFiltro" class="form-control shadow-lg" value="<?php echo date('Y'); ?>">                        
                    </div>                    
                     <div class="col-md-12 mt-3" style="text-align:right;">
                         <button class="btn btn-secondary rounded-button" type="button" onclick="filtrar()">Filtrar</button> 
                         <button class="btn btn-success rounded-button" type="button" onclick="generarBoletin()">Generar Boletin</button> 
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
  <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
  <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>
  <script>
 
       $(document).ready(function() {
 
         traerAlumnosHabilitados();        
        
      })


        function generarBoletin(){

            var codCurso = $("#txtCodGradoFiltro").val();
            var gestion = $("#txtGestionFiltro").val();
            var codAlumno = $("#txtCodAlumnoFiltro").val();
            var nombreAlumno = $("#txtCodAlumnoFiltro option:selected").text();

               if(codCurso == "0"){
                swal("Oops!!","Debe seleccionar un curso para generar boletin de todo el curso", {
                      icon: "warning",                    
                    });
                    return;
            }

            if(codAlumno == "0"){
                   swal({
                title: "Confirmar ",
               text: "Al no seleccionar ningun alumno entonces se va a generar un boletin para todo el curso, ¿Desea Continuar?",
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
                        confirmarGenerarBoletin();                      
                    } else {
                        swal.close();
                    }
                });
                return;
               
            }

         

           

            if(gestion == ""){
                swal("Oops!!","Debe ingresar la gestion", {
                      icon: "warning",                    
                    });
                    return;
            }

               swal({
                title: "Confirmar ",
               text: "¿Seguro que generar el boletín de "+nombreAlumno+"?",
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
                        confirmarGenerarBoletin();                      
                    } else {
                        swal.close();
                    }
                });

        }

         function confirmarGenerarBoletin(){

               var codCurso = $("#txtCodGradoFiltro").val();
            var gestion = $("#txtGestionFiltro").val();
            var codAlumno = $("#txtCodAlumnoFiltro").val();

            if(codAlumno == '' || codAlumno == 0){
                window.open('../../docs/generarBoletinCurso.php?codAlumno='+codAlumno+'&codCurso='+codCurso+'&gestion='+gestion, '_blank');
            }
            else{
                window.open('../../docs/generarBoletin.php?codAlumno='+codAlumno+'&codCurso='+codCurso+'&gestion='+gestion, '_blank');
            }
            
          
        //     $.ajax({
        //       url: "../../respuestaParcial.php?operacion=ActivarAlumno",
        //       type: "POST",  
        //       dataType: "json",      
        //       data: {
        //         codigo:codigo                 
        //       },            
        //       success: function(data, textStatus, jqXHR) {
            
        //         if(data['request'] == 'ok'){
        //            swal("Exito!", "El alumno fue habilitado correctamente", {
        //                icon: "success",
        //                buttons: { confirm: { className: "btn btn-success" } },
        //                timer: 1500
        //            });
        //           filtrar();
        //         }
        //         else{
        //               swal("Ooops!", data['mensaje'], {
        //                     icon: "warning",
        //                     buttons: { confirm: { className: "btn btn-warning" } },
        //                 });
        //         }
                            
        //       },
        //       error: function(jqXHR, textStatus, errorThrown) {
        //         swal("Ooops!", 'Algo salio mal!, por favor intente nuevamente', {
        //                     icon: "warning",
        //                     buttons: { confirm: { className: "btn btn-warning" } },
        //                 });
                        
        //       }
        //   });

        }

       function traerAlumnosHabilitados(){

         
           var codCurso = $("#txtCodGradoFiltro").val();
         
          $.ajax({
              url: "../../respuestaParcial.php?operacion=traerAlumnosHabilitados",
              type: "POST",        
              data: {
               
                codCurso: codCurso
                
              },            
              success: function(data, textStatus, jqXHR) {
            
                $("#txtCodAlumnoFiltro").html('');
                $("#txtCodAlumnoFiltro").html(data);
              
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
          var gestion = $("#txtGestionFiltro").val();
           var codAlumno = $("#txtCodAlumnoFiltro").val();
         
             if(codCurso == "0"){
             swal("Oops!!","Debe seleccionar algun grado", {
                      icon: "warning",                    
                    });
                    return;
            }

            if(codAlumno == "0"){
             swal("Oops!!","Debe seleccionar algun alumno", {
                      icon: "warning",                    
                    });
                    return;
            }

            if(gestion == ""){
                swal("Oops!!","Debe ingresar la gestion", {
                      icon: "warning",                    
                    });
                    return;
            }

         
          $("#divResultado").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=traerBoletin",
              type: "POST",        
              data: {             
                codCurso:codCurso,
                gestion:gestion ,
                codAlumno: codAlumno             
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
                "paging": false,
                "lengthChange": false,
                "searching": false,
                "ordering": false,
                "info": false,
                
                   "scrollY": '450px',   // scroll vertical
                "scrollX": true,      // scroll horizontal
                "scrollCollapse": true,
                "fixedHeader": true,   // cabecera fija
                
                "fixedColumns": {
                    "leftColumns": 1   // 👈 fija las 2 primeras columnas
                }
            });
        
      }
  
  </script>
     
     

</body>

</html>