  <!-- ======= Header ======= -->
  <script>
    // Ocultar la barra lateral de la izquierda por defecto inmediatamente al cargar el body
    // Solo se agrega en escritorio (>= 1200px) porque en movil la clase 'toggle-sidebar' la muestra
    if (window.innerWidth >= 1200) {
      document.body.classList.add('toggle-sidebar');
    }
  </script>
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="../../view/boletin" class="logo d-flex align-items-center">
        <img src="../../imagenes/logoInnova3.png" alt=""   class="logo-img">
        <span class="d-none d-lg-block">SGC</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <!-- <div class="search-bar">
      <form class="search-form d-flex align-items-center" method="POST" action="#">
        <input type="text" name="query" placeholder="Search" title="Enter search keyword">
        <button type="submit" title="Search"><i class="bi bi-search"></i></button>
      </form>
    </div> -->
    <!-- End Search Bar -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <!-- <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li> -->
        <!-- End Search Icon-->

        <!-- <li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-bell"></i>
            <span class="badge bg-primary badge-number">4</span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow notifications">
            <li class="dropdown-header">
              You have 4 new notifications
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-exclamation-circle text-warning"></i>
              <div>
                <h4>Lorem Ipsum</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>30 min. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-x-circle text-danger"></i>
              <div>
                <h4>Atque rerum nesciunt</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>1 hr. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-check-circle text-success"></i>
              <div>
                <h4>Sit rerum fuga</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>2 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="notification-item">
              <i class="bi bi-info-circle text-primary"></i>
              <div>
                <h4>Dicta reprehenderit</h4>
                <p>Quae dolorem earum veritatis oditseno</p>
                <p>4 hrs. ago</p>
              </div>
            </li>

            <li>
              <hr class="dropdown-divider">
            </li>
            <li class="dropdown-footer">
              <a href="#">Show all notifications</a>
            </li>

          </ul> 
         

        </li>-->
        <!-- End Notification Nav -->

         <!--<li class="nav-item dropdown">

          <a class="nav-link nav-icon" href="#" data-bs-toggle="dropdown">
            <i class="bi bi-chat-left-text"></i>
            <span class="badge bg-success badge-number">3</span>
          </a>

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow messages">
            <li class="dropdown-header">
              You have 3 new messages
              <a href="#"><span class="badge rounded-pill bg-primary p-2 ms-2">View all</span></a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-1.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Maria Hudson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>4 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-2.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>Anna Nelson</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>6 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="message-item">
              <a href="#">
                <img src="assets/img/messages-3.jpg" alt="" class="rounded-circle">
                <div>
                  <h4>David Muldon</h4>
                  <p>Velit asperiores et ducimus soluta repudiandae labore officia est ut...</p>
                  <p>8 hrs. ago</p>
                </div>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li class="dropdown-footer">
              <a href="#">Show all messages</a>
            </li>

          </ul>

        </li>-->
        <!-- End Messages Nav -->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="../../imagenes/persona.png" alt="Profile" class="rounded-circle">
              <!-- <i class="fa fa-cubes"></i> -->
            <span class="d-none d-md-block dropdown-toggle ps-2"></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $_SESSION['nombre']; ?></h6>
              <h6><?php echo $_SESSION['tipoUsuario']; ?></h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

           <!-- <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li> -->
              
            <li>
              <a class="dropdown-item d-flex align-items-center" href="#" onclick="cambiarClave()">
                 <i class="bi bi-person"></i>
                <span>Modificar Contraseña</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="../../cerrar_sesion.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Cerrar Sesión</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->


      <style>
      .logo-img {
    width: 50%;
}

/* 📱 tablet */
@media (max-width: 990px) {
    .logo-img {
        width: 100%;
    }
}


 
    </style>

  </header><!-- End Header -->

  <script>

function cambiarClave(){

    $("#txtClaveActual").val('');
    $("#txtClaveNueva").val('');
    $("#txtClaveNueva2").val('');

    $("#modalModificarContrasenha").modal('show');
}

 function ConfirmarModificarContraseña(){

        var actual = $("#txtClaveActual").val();
        var nueva = $("#txtClaveNueva").val();
        var repeticion = $("#txtClaveNueva2").val();
        var codUsuario = '<?php echo $_SESSION['codigousuario']?>';
        if(actual == "" || repeticion== '' || nueva == ''){
            swal("Oops!!","Debe completar todos los campos", {
                icon: "warning",                    
            });
            return;
        }
        if(nueva != repeticion){
            swal("Oops!!","La nueva contraseña no es igual que la confirmación", {
                icon: "warning",                    
            });
            return;
        }

        let regex = /^[a-zA-Z0-9]+$/;

        if (!regex.test(nueva)) {
            swal("Oops!!","La contraseña contiene caracteres especiales no permitidos, solo se permiten numero y letras", {
                icon: "warning",
            });
            return;
        }
      
         // $("#divCargandoCrear").html('<div class="loading"> <center><i class="fa fa-spinner fa-pulse fa-5x" style="color:#3c8dbc"></i><br/>Cargando ...</center></div>');
          $.ajax({
              url: "../../respuestaParcial.php?operacion=modificarContrasenha",
              type: "POST",        
              data: {                     
                actual:actual,
                nueva:nueva,
                repeticion:repeticion,
                codUsuario:codUsuario
              },          
              dataType: "json",  
              success: function(data, textStatus, jqXHR) {
               
                if(data['request'] == 'ok'){
                   
                    $("#modalModificarContrasenha").modal('hide');
                   
                    swal("Exito!", "Contrasenña modificada correctamente!", {
                        icon: "success",
                        timer: 1500 
                    });
 
                    
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


  </script>
     <div class="modal fade" id="modalModificarContrasenha">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" >Modificar Contraseña</h4>
              <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">             
                <div  class="row mb-3">                     
                                
                    <div class="col-md-12 mt-2">
                        <label for="form-label">Contraseña Actual</label>                      
                        <input type="password" class="form-control shadow-lg"  id="txtClaveActual" autocomplete="off">
                    </div>   
                    
                      <div class="col-md-12 mt-2">
                        <label for="form-label">Nueva Contraseña</label>                      
                        <input type="password" class="form-control shadow-lg"  id="txtClaveNueva" autocomplete="username">
                    </div> 

                      <div class="col-md-12 mt-2">
                        <label for="form-label">Confirmar Nueva Contraseña</label>                      
                        <input type="password" class="form-control shadow-lg"  id="txtClaveNueva2" autocomplete="username">
                    </div> 
                </div>     
               
            </div>
            <div class="modal-footer col-md-12 mt-3">   
              <button type="button" class="btn btn-primary rounded-button" onclick="ConfirmarModificarContraseña()">Modificar</button>                     
              <button type="button" class="btn btn-danger rounded-button" data-bs-dismiss="modal">Cerrar</button>            
            </div>
          </div>        
        </div>      
      </div>


      <script>
          function cargando(titulo){
 
          Swal.fire({
            title: titulo,
            html: 'Por favor espera ⏳',
            allowOutsideClick: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });

        }


        function mensajeAviso(titulo,mensaje){
 
                    Swal.fire({
                        title: titulo,
                        icon: "warning",
                        draggable: true,
                        text: mensaje,
                        confirmButtonColor: "#d33",
                      });

        }

        function mensajeError(titulo,mensaje){
 
                    Swal.fire({
                        title: titulo,
                        icon: "warning",
                        draggable: true,
                        text: mensaje,
                        confirmButtonColor: "#d33",
                      });

        }

        function mensajeExito(titulo){
 
                    Swal.fire({
                        title: titulo,
                        icon: "success",
                        timer: 1200,
                        draggable: true
                      });

        }

      </script>