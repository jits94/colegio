<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Iniciar Sesi&oacute;n</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <link href="assets/img/Logo_Innova.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700|Nunito:400,600,700,800|Poppins:400,500,600,700" rel="stylesheet">

  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <link href="assets/css/style.css" rel="stylesheet">
  <style>
    :root {
      --login-navy: #0f2740;
      --login-blue: #1f6fb2;
      --login-sky: #78b7ff;
      --login-gold: #f5c35b;
      --login-ice: rgba(255, 255, 255, 0.16);
      --login-glass: rgba(255, 255, 255, 0.72);
      --login-text: #13314f;
    }

    body.login-page {
      min-height: 100vh;
      font-family: "Nunito", sans-serif;
      background:
        radial-gradient(circle at top left, rgba(120, 183, 255, 0.32), transparent 26%),
        radial-gradient(circle at bottom right, rgba(245, 195, 91, 0.22), transparent 28%),
        linear-gradient(135deg, rgba(10, 28, 48, 0.88), rgba(18, 64, 107, 0.74)),
        url(imagenes/login-fondo-generado.png) center center / cover no-repeat fixed;
      color: #fff;
      overflow-x: hidden;
    }

    .login-shell {
      position: relative;
      min-height: 100vh;
      padding: 32px 0;
      display: flex;
      align-items: center;
    }

    .login-shell::before,
    .login-shell::after {
      content: "";
      position: absolute;
      border-radius: 999px;
      filter: blur(8px);
      opacity: 0.8;
      animation: floatBlob 8s ease-in-out infinite;
      pointer-events: none;
    }

    .login-shell::before {
      width: 180px;
      height: 180px;
      top: 8%;
      left: 6%;
      background: rgba(120, 183, 255, 0.18);
    }

    .login-shell::after {
      width: 220px;
      height: 220px;
      right: 6%;
      bottom: 10%;
      background: rgba(245, 195, 91, 0.16);
      animation-delay: -3s;
    }

    .login-grid {
      position: relative;
      z-index: 2;
      align-items: center;
    }

    .login-panel {
      width: 100%;
      max-width: 460px;
      margin-left: auto;
    }

    .login-story {
      padding: 26px 14px 26px 0;
      animation: fadeUp 0.75s ease;
    }

    .login-badge {
      display: inline-flex;
      align-items: center;
      gap: 8px;
      padding: 8px 14px;
      border-radius: 999px;
      background: rgba(255, 255, 255, 0.14);
      border: 1px solid rgba(255, 255, 255, 0.16);
      font-size: 0.92rem;
      font-weight: 700;
      letter-spacing: 0.02em;
      margin-bottom: 18px;
      backdrop-filter: blur(10px);
    }

    .login-title {
      font-family: "Poppins", sans-serif;
      font-size: clamp(2.2rem, 3vw, 3.4rem);
      font-weight: 700;
      line-height: 1.08;
      margin-bottom: 16px;
      color: #fff;
      max-width: 560px;
    }

    .login-copy {
      max-width: 540px;
      color: rgba(255, 255, 255, 0.82);
      font-size: 1.02rem;
      line-height: 1.75;
      margin-bottom: 28px;
    }

    .login-highlights {
      display: grid;
      grid-template-columns: repeat(2, minmax(0, 1fr));
      gap: 14px;
      max-width: 560px;
    }

    .highlight-card {
      padding: 16px 18px;
      border-radius: 20px;
      background: var(--login-ice);
      border: 1px solid rgba(255, 255, 255, 0.12);
      backdrop-filter: blur(12px);
      box-shadow: 0 18px 40px rgba(4, 16, 33, 0.18);
    }

    .highlight-card i {
      font-size: 1.35rem;
      color: var(--login-gold);
      display: inline-block;
      margin-bottom: 10px;
    }

    .highlight-card h6 {
      margin: 0 0 6px;
      font-size: 1rem;
      font-weight: 700;
      color: #fff;
    }

    .highlight-card p {
      margin: 0;
      color: rgba(255, 255, 255, 0.72);
      font-size: 0.92rem;
      line-height: 1.5;
    }
    .login-panel {
      animation: fadeUp 0.85s ease;
    }

    .login-card {
      border: 0;
      border-radius: 28px;
      overflow: hidden;
      background: var(--login-glass);
      backdrop-filter: blur(18px);
      box-shadow: 0 30px 60px rgba(6, 21, 38, 0.32);
    }

    .login-card-body {
      padding: 30px 28px 28px;
      color: var(--login-text);
    }

    .login-kicker {
      font-size: 0.82rem;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      color: var(--login-blue);
      margin-bottom: 8px;
    }

    .login-heading {
      font-family: "Poppins", sans-serif;
      font-size: 1.75rem;
      font-weight: 700;
      margin-bottom: 8px;
      color: var(--login-navy);
    }

    .login-subcopy {
      margin-bottom: 22px;
      color: #53708c;
      line-height: 1.6;
      font-size: 0.98rem;
    }

    .login-form .form-floating > .form-control {
      height: 58px;
      border-radius: 16px;
      border: 1px solid rgba(15, 39, 64, 0.12);
      background: rgba(255, 255, 255, 0.88);
      box-shadow: none;
      padding-right: 52px;
      color: var(--login-navy);
    }

    .login-form .form-floating > label {
      color: #68819a;
    }

    .login-form .form-control:focus {
      border-color: rgba(31, 111, 178, 0.55);
      box-shadow: 0 0 0 0.22rem rgba(31, 111, 178, 0.12);
    }

    .toggle-password {
      cursor: pointer;
      z-index: 3;
      color: #4d6883;
      transition: color 0.2s ease;
    }

    .toggle-password:hover {
      color: var(--login-blue);
    }

    .login-cta {
      height: 56px;
      border: 0;
      border-radius: 16px;
      font-weight: 800;
      font-size: 1rem;
      letter-spacing: 0.02em;
      background: linear-gradient(135deg, var(--login-blue), #2459a6);
      box-shadow: 0 16px 28px rgba(31, 111, 178, 0.28);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .login-cta:hover {
      transform: translateY(-1px);
      box-shadow: 0 20px 32px rgba(31, 111, 178, 0.34);
    }

    .login-footer-note {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-top: 18px;
      padding: 14px 16px;
      border-radius: 16px;
      background: rgba(19, 49, 79, 0.06);
      color: #5d7791;
      font-size: 0.92rem;
    }

    .login-footer-note i {
      color: var(--login-blue);
      font-size: 1.05rem;
    }

    @keyframes fadeUp {
      from {
        opacity: 0;
        transform: translateY(18px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @keyframes floatBlob {
      0%, 100% {
        transform: translate3d(0, 0, 0);
      }
      50% {
        transform: translate3d(0, -14px, 0);
      }
    }

    @media (max-width: 991.98px) {
      body.login-page {
        background-attachment: scroll;
      }

      .login-shell {
        padding: 24px 0;
        align-items: flex-start;
      }

      .login-grid {
        justify-content: center;
      }

      .login-panel {
        max-width: 640px;
        margin: 0 auto 10px;
      }

      .login-story {
        padding: 0;
        padding-right: 0;
        text-align: center;
        margin-bottom: 24px;
      }

      .login-copy,
      .login-title,
      .login-highlights {
        margin-left: auto;
        margin-right: auto;
      }

      .login-title {
        max-width: 680px;
      }

      .login-copy {
        max-width: 640px;
      }
    }

    @media (max-width: 575.98px) {
      .login-shell {
        padding: 12px 0;
      }

      .container {
        padding-left: 14px;
        padding-right: 14px;
      }

      .section.min-vh-100 {
        min-height: auto !important;
      }

      .login-grid {
        gap: 18px !important;
      }

      .login-panel {
        max-width: 100%;
      }

      .login-highlights {
        grid-template-columns: 1fr;
      }

      .login-card {
        border-radius: 22px;
      }

      .login-card-body {
        padding: 22px 18px 22px;
      }

      .login-title {
        font-size: 1.9rem;
      }

      .login-copy {
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: 20px;
      }

      .login-badge {
        font-size: 0.82rem;
        padding: 8px 12px;
      }

      .login-heading {
        font-size: 1.5rem;
      }

      .login-subcopy,
      .login-footer-note span,
      .highlight-card p {
        font-size: 0.9rem;
      }

      .login-form .form-floating > .form-control,
      .login-cta {
        height: 54px;
      }
    }

    @media (max-width: 380px) {
      .login-card-body {
        padding: 20px 15px;
      }

      .login-title {
        font-size: 1.72rem;
      }

      .login-highlights {
        gap: 12px;
      }

      .highlight-card {
        padding: 14px 15px;
      }
    }
  </style>
</head>

<body class="login-page">
  <main class="login-shell">
    <div class="container">
      <section class="section min-vh-100 d-flex align-items-center py-4">
        <div class="row g-4 login-grid w-100">
          <div class="col-lg-7 order-2 order-lg-1">
            <div class="login-story">
              <div class="login-badge">
                <i class="bi bi-mortarboard-fill"></i>
                <span>Plataforma Acad&eacute;mica Escolar</span>
              </div>
              <h1 class="login-title">Sistema para la gesti&oacute;n del colegio.</h1>
              <p class="login-copy">
                Ingresa al sistema para administrar estudiantes, finanzas, notas y comunicados desde un entorno pensado para el ritmo diario de una unidad educativa.
              </p>

              <div class="login-highlights">
                <div class="highlight-card">
                  <i class="bi bi-people-fill"></i>
                  <h6>Comunidad conectada</h6>
                  <p>Centraliza la informaci&oacute;n acad&eacute;mica, administrativa y financiera en un solo lugar.</p>
                </div>
                <div class="highlight-card">
                  <i class="bi bi-journal-check"></i>
                  <h6>Trabajo ordenado</h6>
                  <p>Accede de forma r&aacute;pida a registros, reportes y procesos diarios del colegio.</p>
                </div>
                <div class="highlight-card">
                  <i class="bi bi-bar-chart-line-fill"></i>
                  <h6>Seguimiento constante</h6>
                  <p>Consulta balances, avances y datos relevantes con una experiencia m&aacute;s simple.</p>
                </div>
                <div class="highlight-card">
                  <i class="bi bi-shield-lock-fill"></i>
                  <h6>Ingreso seguro</h6>
                  <p>Autenticaci&oacute;n protegida para cada perfil de usuario dentro del sistema.</p>
                </div>
              </div>
            </div>
          </div>

          <div class="col-lg-5 order-1 order-lg-2">
            <div class="login-panel">
              <div class="card login-card">
                <div class="login-card-body">
                  <div class="login-kicker">Bienvenido</div>
                  <h2 class="login-heading">Iniciar sesi&oacute;n</h2>
                  <p class="login-subcopy">
                    Introduce tus credenciales para continuar con la gesti&oacute;n acad&eacute;mica y administrativa.
                  </p>

                  <form class="row g-3 login-form" method="post">
                    <div class="col-12">
                      <div class="form-floating">
                        <input type="text" class="form-control" id="usuario" placeholder="Usuario" autocomplete="username">
                        <label for="usuario">Usuario</label>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="form-floating position-relative">
                        <input type="password" class="form-control" id="contra" placeholder="Contrase&ntilde;a" autocomplete="current-password">
                        <label for="contra">Contrase&ntilde;a</label>
                        <span class="position-absolute end-0 top-50 translate-middle-y pe-3 toggle-password" onclick="togglePassword()">
                          <i class="bi bi-eye" id="togglePasswordIcon"></i>
                        </span>
                      </div>
                    </div>

                    <div class="col-12">
                      <button class="btn btn-primary w-100 login-cta" type="button" onclick="autenticacion();">
                        Ingresar al sistema
                      </button>
                    </div>
                  </form>

                  <div class="login-footer-note">
                    <i class="bi bi-stars"></i>
                    <span>Dise&ntilde;ado para acompa&ntilde;ar la organizaci&oacute;n diaria del colegio de forma &aacute;gil.</span>
                  </div>
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
      $(document).keydown(function(event) {
        if (event.keyCode === 13) {
          autenticacion();
        }
      });
    });

    function autenticacion() {
      var user = $("#usuario").val();
      var contra = $("#contra").val();

      if (user == "" || contra == "") {
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
          if (data == 'ok') {
            $("#ModalCargarPagina").modal("show");
            window.location.href = "view/anuncios/";
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Acceso denegado',
              text: 'El usuario o la contrase\u00f1a son incorrectos.'
            });
          }
        }
      });
    }
  </script>

</body>

</html>
