<?php 
 include '../../contenido/sesion.php'; 
 include '../../clases/registro.php';
 $registro = new registro();
 $codTipoUsuario = $_SESSION['codTipoUsuario'];
 // Roles permitidos para crear: Superusuario(1), Director(3), Secretaría(5)
 $puedeCrear = in_array($codTipoUsuario, [1, 3, 5]);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <?php include_once "../../contenido/extensiones.php"; ?>
  <link href="../../assets/css/style.css" rel="stylesheet">
  <style>
    .announcement-card {
      border-radius: 15px;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      border: none;
      border-left: 5px solid #4154f1;
    }
    .announcement-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .announcement-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 10px;
    }
    .announcement-title {
      font-weight: 700;
      color: #012970;
      font-size: 1.25rem;
    }
    .announcement-date {
      font-size: 0.85rem;
      color: #899bbd;
    }
    .announcement-body {
      color: #444444;
      line-height: 1.6;
    }
    .announcement-footer {
      margin-top: 15px;
      padding-top: 10px;
      border-top: 1px solid #ebeef4;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 0.85rem;
    }
    .author-badge {
      background: #f6f9ff;
      padding: 5px 12px;
      border-radius: 20px;
      color: #4154f1;
      font-weight: 600;
    }
    .expiry-badge {
      color: #dc3545;
      font-weight: 500;
    }
    #announcements-container {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
      gap: 20px;
    }
    @media (max-width: 576px) {
      #announcements-container {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>

<body>
  <?php include_once "../../contenido/encabezado.php"; ?>
  <?php include_once "../../contenido/menu.php"; ?>

  <main id="main" class="main">
    <div class="pagetitle">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h1>Anuncios y Comunicados</h1>
          <nav>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
              <li class="breadcrumb-item active">Anuncios</li>
            </ol>
          </nav>
        </div>
        <?php if ($puedeCrear): ?>
          <button class="btn btn-primary rounded-pill px-4 shadow" onclick="nuevoAnuncio()">
            <i class="bi bi-plus-lg me-1"></i> Nuevo Anuncio
          </button>
        <?php endif; ?>
      </div>
    </div>

    <section class="section">
      <div id="announcements-container" class="mt-4">
        <!-- Los anuncios se cargarán aquí -->
      </div>
      
      <div id="no-announcements" class="text-center py-5 d-none">
        <img src="../../assets/img/not-found.svg" alt="No hay anuncios" style="max-width: 200px; opacity: 0.5;">
        <h4 class="mt-3 text-muted">No hay anuncios vigentes en este momento.</h4>
      </div>
    </section>

    <!-- Modal Nuevo Anuncio -->
    <div class="modal fade" id="modalAnuncio" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content shadow-lg border-0" style="border-radius: 15px;">
          <div class="modal-header border-0 pb-0">
            <h5 class="modal-title fw-bold" style="color: #012970;">Publicar Nuevo Anuncio</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body p-4">
            <form id="formAnuncio">
              <div class="mb-3">
                <label class="form-label fw-semibold">Título</label>
                <input type="text" id="txtTitulo" class="form-control rounded-3" placeholder="Ej: Suspensión de clases" required>
              </div>
              <div class="mb-3">
                <label class="form-label fw-semibold">Descripción / Contenido</label>
                <textarea id="txtDescripcion" class="form-control rounded-3" rows="4" placeholder="Escribe el mensaje aquí..." required></textarea>
              </div>
              <div class="mb-0">
                <label class="form-label fw-semibold">Fecha de Vencimiento</label>
                <input type="date" id="txtFechaVencimiento" class="form-control rounded-3" required min="<?php echo date('Y-m-d'); ?>">
                <div class="form-text">El anuncio dejará de mostrarse después de esta fecha.</div>
              </div>
            </form>
          </div>
          <div class="modal-footer border-0 pt-0">
            <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-primary rounded-pill px-4" onclick="guardarAnuncio()">Publicar</button>
          </div>
        </div>
      </div>
    </div>
  </main>

  <?php include_once "../../contenido/piePagina.php"; ?>

  <?php 
  $ruta_assets = "../../assets/";
  include_once "../../contenido/extensionesFooter.php"; 
  ?>

  <script>
    $(document).ready(function() {
      cargarAnuncios();
    });

    function nuevoAnuncio() {
      $('#formAnuncio')[0].reset();
      $('#modalAnuncio').modal('show');
    }

    function cargarAnuncios() {
      $.ajax({
        url: '../../respuestaParcial.php?operacion=traerAnuncios',
        type: 'GET',
        dataType: 'json',
        success: function(res) {
          let html = '';
          if (res.length > 0) {
            $('#no-announcements').addClass('d-none');
            res.forEach(a => {
              html += `
                <div class="card announcement-card shadow-sm mb-0">
                  <div class="card-body p-4">
                    <div class="announcement-header">
                      <span class="announcement-title">${a.titulo}</span>
                      ${<?php echo $puedeCrear ? 'true' : 'false' ?> ? 
                        `<button class="btn btn-sm text-danger" onclick="eliminarAnuncio(${a.id})"><i class="bi bi-trash"></i></button>` : ''
                      }
                    </div>
                    <div class="announcement-date mb-3">
                      <i class="bi bi-calendar-event me-1"></i> Publicado: ${formatearFecha(a.fecha_creacion)}
                    </div>
                    <div class="announcement-body">
                      ${a.descripcion.replace(/\n/g, '<br>')}
                    </div>
                    <div class="announcement-footer">
                      <span class="author-badge"><i class="bi bi-person-fill me-1"></i> ${a.autorNombre} ${a.autorApellidos}</span>
                      <span class="expiry-badge"><i class="bi bi-clock-history me-1"></i> Expira: ${a.fecha_vencimiento}</span>
                    </div>
                  </div>
                </div>
              `;
            });
            $('#announcements-container').html(html);
          } else {
            $('#announcements-container').html('');
            $('#no-announcements').removeClass('d-none');
          }
        }
      });
    }

    function guardarAnuncio() {
      let titulo = $('#txtTitulo').val();
      let descripcion = $('#txtDescripcion').val();
      let fecha = $('#txtFechaVencimiento').val();

      if (!titulo || !descripcion || !fecha) {
        Swal.fire('Error', 'Todos los campos son obligatorios', 'error');
        return;
      }

      $.ajax({
        url: '../../respuestaParcial.php?operacion=crearAnuncio',
        type: 'POST',
        data: {
          titulo: titulo,
          descripcion: descripcion,
          fechaVencimiento: fecha
        },
        dataType: 'json',
        success: function(res) {
          if (res.request === 'ok') {
            $('#modalAnuncio').modal('hide');
            Swal.fire('Éxito', 'Anuncio publicado correctamente', 'success');
            cargarAnuncios();
          } else {
            Swal.fire('Error', res.mensaje, 'error');
          }
        }
      });
    }

    function eliminarAnuncio(id) {
      Swal.fire({
        title: '¿Estás seguro?',
        text: "El anuncio ya no será visible para nadie",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '../../respuestaParcial.php?operacion=eliminarAnuncio',
            type: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(res) {
              if (res.request === 'ok') {
                Swal.fire('Eliminado', 'El anuncio ha sido eliminado.', 'success');
                cargarAnuncios();
              }
            }
          });
        }
      });
    }

    function formatearFecha(fechaStr) {
      const fecha = new Date(fechaStr);
      return fecha.toLocaleDateString('es-ES', { day: '2-digit', month: 'long', year: 'numeric' });
    }
  </script>
</body>
</html>
