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
      
      <h1>Centralizador Anual de Notas</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row mt-3">
        

        <div class="col-lg-12">     

          <div class="card shadow-lg" style="border-top:solid 3px blue;">
            <div class="card-body">
               <div class="row">
                    <div class="col-md-3 mt-2"  >
                        <label for="form-label">Profesor</label>
                        <select  id="txtCodProfesorFiltro" class="form-select shadow-lg" onchange="traerCursosHabilitados()">
                            <?php echo $iparametro->DropDownProfesor($_SESSION['codTipoUsuario'],$_SESSION['codigousuario']); ?>
                        </select>
                    </div>    
              
                    <div class="col-md-3 mt-2">
                        <label for="form-label">Grado</label>
                        <select  id="txtCodGradoFiltro" class="form-select shadow-lg"  onchange="traerMateriasHabilitadas()">
                         
                            <?php //echo $iparametro->DropDownCursos($_SESSION['codTipoUsuario'],$_SESSION['codigousuario']); ?>
                        </select>
                    </div> 

                    <div class="col-md-3 mt-2">
                        <label for="form-label">Materia</label>
                        <select  id="txtCodMateriaFiltro" class="form-select shadow-lg" >
                            <?php //echo $iparametro->DropDownCursos(); ?>
                        </select>
                    </div> 

                    <div class="col-md-3 mt-2">
                        <label for="form-label">Gestion</label>
                        <input type="number" id="txtGestionFiltro" class="form-control shadow-lg" value="<?php echo date('Y'); ?>">
                        
                    </div>  
                     
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
  <!-- <link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
  <script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script> -->

<!-- DataTables core -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

<!-- FixedColumns -->
<link rel="stylesheet" href="https://cdn.datatables.net/fixedcolumns/4.3.0/css/fixedColumns.dataTables.min.css">
<script src="https://cdn.datatables.net/fixedcolumns/4.3.0/js/dataTables.fixedColumns.min.js"></script>

<!-- Buttons -->
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>

<!-- JSZip (OBLIGATORIO para Excel) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

<!-- Botones HTML5 -->
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
  <script>

       
    function mostrarFilaSer(){
        var estado = $("#txtColumnaSer").val();

       
        if(estado == 1){
            $(".cabe_Ser").attr("colspan", 1);  
          $("#txtColumnaSer").val(0);
          $(".ser").hide('slow');
          $("#btnSer").html('+');
        }
        else{
             $(".cabe_Ser").attr("colspan", 4);  
          $("#txtColumnaSer").val(1);
          $(".ser").show('slow');
          $("#btnSer").html('-');
        }
    }

    function mostrarFilaSaber(){
        var estado = $("#txtColumnaSaber").val();

       
        if(estado == 1){
            $(".cabe_Saber").attr("colspan", 1);  
          $("#txtColumnaSaber").val(0);
          $(".saber").hide('slow');
          $("#btnSaber").html('+');
        }
        else{
             $(".cabe_Saber").attr("colspan", 7);  
          $("#txtColumnaSaber").val(1);
          $(".saber").show('slow');
          $("#btnSaber").html('-');
        }
    }

      function mostrarFilaHacer(){
        var estado = $("#txtColumnaHacer").val();

       
        if(estado == 1){
            $(".cabe_Hacer").attr("colspan", 1);  
          $("#txtColumnaHacer").val(0);
          $(".hacer").hide('slow');
          $("#btnHacer").html('+');
        }
        else{
             $(".cabe_Hacer").attr("colspan", 7);  
          $("#txtColumnaHacer").val(1);
          $(".hacer").show('slow');
          $("#btnHacer").html('-');
        }
    }

      function mostrarFilaDecidir(){
        var estado = $("#txtColumnaDecidir").val();

       
        if(estado == 1){
            $(".cabe_Decidir").attr("colspan", 1);  
          $("#txtColumnaDecidir").val(0);
          $(".decidir").hide('slow');
          $("#btnDecidir").html('+');
        }
        else{
             $(".cabe_Decidir").attr("colspan", 4);  
          $("#txtColumnaDecidir").val(1);
          $(".decidir").show('slow');
          $("#btnDecidir").html('-');
        }
    }

      $(document).ready(function() {

         $("#txtNombre").keydown(function(event) {
            if (event.keyCode === 13) { // 13 = Enter
                event.preventDefault(); // evita que se envíe el formulario
               ConfirmarRegistrar();
               
            }
        });

          traerCursosHabilitados();

        //filtrar();
        
      })

      
      function agregar(){

        $("#modalCrear").modal('show');
      }

      

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
 
      function editarDatos(id,codCurso,codProfesor,nombres,apellidos){
        $("#txtidEdit").val(id);
        $("#txtCodGradoEdit").val(codCurso);
        $("#txtCodProfesorEdit").val(codProfesor);
        $("#txtNombreEdit").val(nombres);
        $("#txtApellidosEdit").val(apellidos);
        $("#modalEditar").modal('show');
      }

       function ConfirmarEditar(){

         var codigo = $("#txtidEdit").val();
          var codCurso = $("#txtCodGradoEdit").val();  
           var codProfesor = $("#txtCodProfesorEdit").val();  
          var nombres = $("#txtNombreEdit").val();
          var apellidos = $("#txtApellidosEdit").val();
        
           $("#divCargandoEditar").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Modificando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=editarAlumno",
              type: "POST",        
              data: {
                codigo: codigo,
                codProfesor: codProfesor,
                codCurso: codCurso,
                nombres: nombres,
                apellidos: apellidos
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

          var codProfesor = $("#txtCodProfesorFiltro").val();
          
         // $("#divResultado").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=traerCursosHabilitados",
              type: "POST",        
              data: {
                codProfesor:codProfesor 
                
              },            
              success: function(data, textStatus, jqXHR) {
            
                $("#txtCodGradoFiltro").html('');
                $("#txtCodGradoFiltro").html(data);
              
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  swal("Oops!","error de ajax, intenta nuevamente!", {
                      icon: "warning",
                    
                    });             
              }
          });
      }

        function traerMateriasHabilitadas(){

          var codProfesor = $("#txtCodProfesorFiltro").val();
           var codCurso = $("#txtCodGradoFiltro").val();
         // $("#divResultado").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=traerMateriasHabilitadas",
              type: "POST",        
              data: {
                codProfesor:codProfesor,
                codCurso: codCurso,
                origen: 'centralizador',
                codTipoUsuario: '<?php echo $_SESSION['codTipoUsuario']; ?>'
                
              },            
              success: function(data, textStatus, jqXHR) {
            
                $("#txtCodMateriaFiltro").html('');
                $("#txtCodMateriaFiltro").html(data);
              
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  swal("Oops!","error de ajax, intenta nuevamente!", {
                      icon: "warning",
                    
                    });             
              }
          });
        }
      function filtrar(){

           var codProfesor = $("#txtCodProfesorFiltro").val();

          var codCurso = $("#txtCodGradoFiltro").val();
          var gestion = $("#txtGestionFiltro").val();
           var codMateria = $("#txtCodMateriaFiltro").val();
         
        
            if(codCurso == "0"){
             swal("Oops!!","Debe seleccionar algun grado", {
                      icon: "warning",
                    
                    });
                    return;
            }

            if(codMateria == "0"){
                swal("Oops!!","Debe seleccionar una materia", {
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
              url: "../../respuestaParcial.php?operacion=traerCentralizadorNotas",
              type: "POST",        
              data: {
                codProfesor:codProfesor,
                codCurso:codCurso,
                gestion:gestion,
                codMateria:codMateria 
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
                "ordering": true,
                "info": false,
                 "dom": 'Bfrtip', // Define dónde se muestran los botones
                  "buttons": [
                      {
                          extend: 'excelHtml5',
                          text: '<i class="fa-solid fa-file-excel"></i> Exportar a Excel',
                          title: 'Datos_Exportados', // Nombre del archivo
                          className: 'btn btn-success', // (opcional, si usas Bootstrap)
                          exportOptions: {
                              columns: [0,1,2,3,4,5] // índices de columnas a exportar
                          }
                      }
                  ],     
                   "scrollY": '450px',   // scroll vertical
                "scrollX": true,      // scroll horizontal
                "scrollCollapse": true,
                "fixedHeader": true,   // cabecera fija
                 
                "fixedColumns": {
                    "leftColumns": 2   // 👈 fija las 2 primeras columnas
                }
            });
        
      }
 

        function registrarNota(codCursoAlumno,codMateria,tipo,posicion){
 
            var trimestre = $("#txtTrimestreFiltro").val();
            var valor = $("#txt"+tipo+"_"+posicion+"_"+codMateria+"_"+codCursoAlumno).val();
            if(tipo == 'Ser' && valor > 5){
              valor = 5;
              $("#txt"+tipo+"_"+posicion+"_"+codMateria+"_"+codCursoAlumno).val(5);
                swal("Oops!",'Para el SER el valor maximo permitido es 5', {
                        icon: "warning",                      
                    })
            }
            if(tipo == 'Ser' && valor > 5){
              valor = 5;
              $("#txt"+tipo+"_"+posicion+"_"+codMateria+"_"+codCursoAlumno).val(valor);
                swal("Oops!",'Para el SER el valor maximo permitido es 5', {
                        icon: "warning",                      
                    })
            }
             if(tipo == 'Saber' && valor > 45){
              valor = 45;
              $("#txt"+tipo+"_"+posicion+"_"+codMateria+"_"+codCursoAlumno).val(valor);
                swal("Oops!",'Para el SABER el valor maximo permitido es 45', {
                        icon: "warning",                      
                    })
            }
             if(tipo == 'Hacer' && valor > 40){
              valor = 40;
              $("#txt"+tipo+"_"+posicion+"_"+codMateria+"_"+codCursoAlumno).val(valor);
                swal("Oops!",'Para el HACER el valor maximo permitido es 40', {
                        icon: "warning",                      
                    })
            }
             if(tipo == 'Decibir' && valor > 5){
              valor = 5;
              $("#txt"+tipo+"_"+posicion+"_"+codMateria+"_"+codCursoAlumno).val(valor);
                swal("Oops!",'Para el DECIDIR el valor maximo permitido es 5', {
                        icon: "warning",                      
                    })
            }

              if(tipo == 'AutoEvaliacion' && valor > 5){
              valor = 5;
              $("#txt"+tipo+"_"+posicion+"_"+codMateria+"_"+codCursoAlumno).val(valor);
                swal("Oops!",'Para la AUTOEVALUACION el valor maximo permitido es 5', {
                        icon: "warning",                      
                    })
            }

            if(valor == ''){              
              valor = 0;
                $("#txt"+tipo+"_"+posicion+"_"+codMateria+"_"+codCursoAlumno).val(valor);
            }
            //$("#divCargandoCrear").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
            $.ajax({
              url: "../../respuestaParcial.php?operacion=registrarNota",
              type: "POST",        
              data: {
                    codCursoAlumno:codCursoAlumno,
                    codMateria: codMateria,
                    valor:valor,
                    tipo: tipo,
                    posicion: posicion,
                    trimestre: trimestre
              },          
              dataType: "json",  
              success: function(data, textStatus, jqXHR) {
               
                if(data['request'] == 'ok'){                                    
                   
                }
                else{
                    $("#txt"+tipo+"_"+posicion+"_"+codMateria+"_"+codCursoAlumno).val('');
                    swal("Oops!",data['mensaje'], {
                        icon: "warning",                      
                    })
                }
              
              },
              error: function(jqXHR, textStatus, errorThrown) {
                     $("#txt"+tipo+"_"+posicion+"_"+codMateria+"_"+codCursoAlumno).val(''); 
                    swal("Oops!","Error de ajax, intenta nuevamente!", {
                      icon: "warning",
                    
                    });
              }

          });

      }


      $(document).on('input', '.notaSer', function () {

          let fila = $(this).closest('tr');

          let suma = 0;
          let contador = 0;

          fila.find('.notaSer').each(function () {
              let valor = parseFloat($(this).val());
  
            console.log('valor: '+valor);
              if (!isNaN(valor) && valor != 0) {
                  suma += valor;
                  contador++;
              }
          });

          let promedio = (contador > 0) ? (suma / contador) : 0;
          console.log('promedio: '+promedio);
       
          fila.find('.promedioSer').val(promedio.toFixed(0));
          calcularTotalTrimestral(fila);
      });

      
      $(document).on('input', '.notaSaber', function () {

          let fila = $(this).closest('tr');

          let suma = 0;
          let contador = 0;

          fila.find('.notaSaber').each(function () {
              let valor = parseFloat($(this).val());
  
            console.log('valor: '+valor);
              if (!isNaN(valor) && valor != 0) {
                  suma += valor;
                  contador++;
              }
          });

          let promedio = (contador > 0) ? (suma / contador) : 0;
          console.log('promedio: '+promedio);
       
          fila.find('.promedioSaber').val(promedio.toFixed(0));
          calcularTotalTrimestral(fila);
      });


      $(document).on('input', '.notaHacer', function () {

          let fila = $(this).closest('tr');

          let suma = 0;
          let contador = 0;

          fila.find('.notaHacer').each(function () {
              let valor = parseFloat($(this).val());
  
            console.log('valor: '+valor);
              if (!isNaN(valor) && valor != 0) {
                  suma += valor;
                  contador++;
              }
          });

          let promedio = (contador > 0) ? (suma / contador) : 0;
          console.log('promedio: '+promedio);
       
          fila.find('.promedioHacer').val(promedio.toFixed(0));
          calcularTotalTrimestral(fila);
      });


      $(document).on('input', '.notaDecidir', function () {

          let fila = $(this).closest('tr');

          let suma = 0;
          let contador = 0;

          fila.find('.notaDecidir').each(function () {
              let valor = parseFloat($(this).val());
  
            console.log('valor: '+valor);
              if (!isNaN(valor) && valor != 0) {
                  suma += valor;
                  contador++;
              }
          });

          let promedio = (contador > 0) ? (suma / contador) : 0;
          console.log('promedio: '+promedio);
       
          fila.find('.promedioDecidir').val(promedio.toFixed(0));
          calcularTotalTrimestral(fila);
      });

      $(document).on('input', '.autoevaluacion', function () {

          let fila = $(this).closest('tr');

          calcularTotalTrimestral(fila);
      });

      function calcularTotalTrimestral(fila) {

        let total = 0;

        fila.find('.promedio').each(function () {
            let valor = parseFloat($(this).val());
            if (!isNaN(valor) && valor != 0) {
             console.log('valor: '+valor);
                total += valor;
            }
        });

        let auto = parseFloat(fila.find('.autoevaluacion').val());
        if (!isNaN(auto)) {
            total += auto;
        }

        fila.find('.totalTrimestral').val(total.toFixed(0));
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