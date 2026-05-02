<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Iniciar Sesi&oacute;n</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/Logo_Innova.png  " rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
  <style>
   .tarjeta{
    opacity: 0.9;
   }
    
   .fondo-login {
    position: relative;
    background: url(imagenes/fondo.avif) center center / cover no-repeat fixed;
}

.fondo-login::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: -1;
}
 </style>
</head>

<body class="hold-transition login-page fondo-login"  style="background:
linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)),
url(imagenes/fondo.avif);
background-attachment: fixed;
background-position: center;
background-repeat: no-repeat;
background-size: cover;
    ">

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
            
              <div class="d-flex justify-content-center py-4">
              </div>

              <div class="card mb-3 tarjeta">

                <div class="card-body">

                  <div class="image text-center pt-2" >
                    <img src="imagenes/cabecera.jpg" class="img-circle elevation-2" alt="User Image" width="100%">
                  </div>
                  <div class="pt-1 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Iniciar Sesi&oacute;n</h5>
                  </div>

                  <form class="row g-3 " method="post">

                    <div class="col-12">
                        <div class="form-floating mb-3">
                          <input type="text" class="form-control" id="usuario" placeholder="Usuario">
                          <label for="floatingInput">Usuario</label>
                        </div>
                    </div>

                    <div class="col-12">
                      <div class="form-floating mb-3 position-relative">
                        <input type="password" class="form-control" id="contra" placeholder="Contrase&ntilde;a">
                        <label for="floatingInput">Contrase&ntilde;a</label>
                        <span class="position-absolute end-0 top-50 translate-middle-y pe-3" style="cursor: pointer; z-index: 10;" onclick="togglePassword()">
                          <i class="bi bi-eye" id="togglePasswordIcon"></i>
                        </span>
                      </div>
                    </div>
                   
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="button" onclick="autenticacion();">Iniciar Sesi&oacute;n</button>
                    </div>
                   
                    <br>
                  </form>

                </div>
              </div>
            </div>
          </div>
        </div>

      </section>

    </div>
  </main>

  <?php
  $ruta_assets = "assets/";
  include_once "contenido/extensionesFooter.php";
  ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <div class="modal fade" id="ModalCargarPagina">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-body">
              <div class="text-center">
                <div class="spinner-border" role="status">
                  <span class="visually-hidden"></span>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('contra');
      const icon = document.getElementById('togglePasswordIcon');
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
      } else {
        passwordInput.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
      }
    }

    $(document).ready(function() {
        $("#miInput").keydown(function(event) {
            if (event.keyCode === 13) {
                event.preventDefault();
               autenticacion()
            }
        });
        
        $(document).keydown(function(event) {
            if (event.keyCode === 13) {
               autenticacion()
            }
        });
    });

    function autenticacion(){
        var user = $("#usuario").val();
        var contra = $("#contra").val();

        if(user == "" || contra == ""){
          Swal.fire({
            icon: 'warning',
            title: 'Campos requeridos',
            text: 'Debe ingresar el usuario y la contrase\u00f1a.'
          });
          return false;
        }

        $.ajax({
        url: "respuestaParcial.php?operacion=iniciarSesion",
        type: 'POST',
        data: {
            user: user,
            contra: contra
            },
            success: function(data) {
                if(data == 'ok'){
                    $("#ModalCargarPagina").modal("show");
                    window.location.href = "view/anuncios/";
                }
                else{
                  Swal.fire({
                    icon: 'error',
                    title: 'Acceso denegado',
                    text: 'El usuario o la contrase\u00f1a son incorrectos.'
                  });
                }
            }
        })
    }

</script>

</body>

</html>
