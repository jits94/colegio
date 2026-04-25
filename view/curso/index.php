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
                        <h1>Lista de Cursos</h1>
                    </div>
                    <div class="col-md-6" style="text-align:right;">
                         <button class="btn btn-primary rounded-button" type="button" onclick="agregar()">Agregar Curso</button>&nbsp;
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

      function ConfirmarGenerarPdfMensual(){  
                
        var anho = $("#txtGestion").val();  
        var mes = $("#txtMes").val();
       
        var url ="docs/historicosAnual.php?mes=" + mes +"&gestion="+ anho;
          window.open(url, this.target,'left=5,top=5,width=1000,height=800,resizable,scrollbars=yes');        
      }

      function ConfirmarRegistrar(){

         var grado = $("#txtGrado").val();  
        var nivel = $("#txtNivel").val();
         
        
        if(grado == ""){
             swal("Debe indicar el grado", {
                      icon: "warning",
                    
                    });
                    return;
        }

         if(nivel == ""){
             swal("Debe indicar el nivel", {
                      icon: "warning",
                    
                    });
                    return;
        }
           $("#divCargandoCrear").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=crearCurso",
              type: "POST",        
              data: {
                grado:grado,
                nivel:nivel
              },          
              dataType: "json",  
              success: function(data, textStatus, jqXHR) {
                $("#divCargandoCrear").html('');
                if(data['request'] == 'ok'){
                    $("#txtGrado").val('');  
                    $("#txtNivel").val('');
                   
                    $("#modalCrear").modal('hide');
                   
                    swal("Exito! Producto creado correctamente!", {
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
                    $("#divCargandoCrear").html('');                 
                    swal("Oops!","Error de ajax, intenta nuevamente!", {
                      icon: "warning",
                    
                    });
              }

          });

      }

        function ActivarDato(codCurso,grado,nivel){
               swal({
                title: "Confirmar ",
               text: "¿Seguro que deseas activar el curso "+grado+" de "+nivel+"?",
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
                        confirmarActivarMateria(codCurso);                      
                    } else {
                        swal.close();
                    }
                });

        }

        function confirmarActivarMateria(codCurso){

          
             $.ajax({
              url: "../../respuestaParcial.php?operacion=AcivarCurso",
              type: "POST",  
              dataType: "json",      
              data: {
                codCurso:codCurso                 
              },            
              success: function(data, textStatus, jqXHR) {
            
                if(data['request'] == 'ok'){
                   swal("Exito!", "El curso fue eliminado correctamente", {
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



        function eliminarDato(codCurso,grado,nivel){

           

               swal({
                title: "Confirmar ",
                text: "¿Seguro que deseas eliminar el curso "+grado+" de "+nivel+"?",
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
                        confirmareliminarCurso(codCurso);                      
                    } else {
                        swal.close();
                    }
                });

        }

        function confirmareliminarCurso(codCurso){

          
             $.ajax({
              url: "../../respuestaParcial.php?operacion=eliminarCurso",
              type: "POST",  
              dataType: "json",      
              data: {
                codCurso:codCurso                 
              },            
              success: function(data, textStatus, jqXHR) {
            
                if(data['request'] == 'ok'){
                   swal("Exito!", "El curso fue eliminado correctamente", {
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

      function editarDatos(codCurso,grado,nivel){
        $("#txtCodCursoEdit").val(codCurso);
        $("#txtGradoEdit").val(grado);
        $("#txtNivelEdit").val(nivel);
        $("#modalEditar").modal('show');
      }

       function ConfirmarEditar(){

          var codigo = $("#txtCodCursoEdit").val();  
          var grado = $("#txtGradoEdit").val();
          var nivel = $("#txtNivelEdit").val();
        
           $("#divCargandoEditar").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Modificando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=editarCurso",
              type: "POST",        
              data: {
                codigo: codigo,
                grado: grado,
                nivel: nivel
              },          
              dataType: "json",  
              success: function(data, textStatus, jqXHR) {
                $("#divCargandoEditar").html('');
                if(data['request'] == 'ok'){
                  
                    $("#modalEditar").modal('hide')
                   
                    swal("Exito!","Curso modificado correctamente!", {
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
              url: "../../respuestaParcial.php?operacion=traerCurso",
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
                        <label for="form-label">Grado</label>
                        <input type="text" class="form-control shadow-lg" id="txtGrado" placeholder="Cuarto">
                    </div>                  
                     <div class="col-md-12 mt-2">
                        <label for="form-label">Nivel</label>
                        <input type="text" class="form-control shadow-lg" id="txtNivel" placeholder="Secundario">
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
                    <input type="hidden" class="form-control" id="txtCodCursoEdit">
                    <div class="col-md-12 mt-2">
                        <label for="form-label">Grado</label>
                        <input type="text" class="form-control Shadow-lg" id="txtGradoEdit">
                    </div>                  
                    <div class="col-md-12 mt-2">
                        <label for="form-label">Nivel</label>  
                        <input type="text" class="form-control Shadow-lg" id="txtNivelEdit">
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