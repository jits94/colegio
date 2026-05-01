 
 <?php 

$actual_link = "$_SERVER[REQUEST_URI]";
$parteslink = explode("/", $actual_link);
$nombredelarchivo = end($parteslink);
$_SESSION['last_activity'] = time();
 ?>
 <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    
    <ul class="sidebar-nav" id="sidebar-nav">

    <li style="text-align: center;">
       <img src="../../imagenes/persona.png" alt="Profile" width="50px" height="50px" class="rounded-circle"><br><br>
              <h6><b><?php echo $_SESSION['nombre']; ?></b></h6>
              <h6><b><?php echo $_SESSION['tipoUsuario']; ?></b></h6>
            </li>

    <li class="nav-heading">Menu</li>
       
    <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == '../anuncios/') { echo 'active';}  ?>" href="../anuncios/">
          <i class="bi bi-megaphone"></i>
          <span>Anuncios  </span>
        </a>
    </li>
       
       <!-- <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == 'producto.php') { echo 'active';}  ?>" href="compras.php">
          <i class="bi bi-cart-check"></i>
          <span>Compras  </span>
        </a>
      </li>
       <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == 'proyectos.php') { echo 'active';}  ?>" href="proyectos.php">
        <i class="bi bi-card-checklist"></i>
          <span>Proyectos  </span>
        </a>
      </li> -->

      <?php if($_SESSION['codTipoUsuario'] == 1 || $_SESSION['codTipoUsuario'] == 3 || $_SESSION['codTipoUsuario'] == 5){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == '../curso/') { echo 'active';}  ?>" href="../curso/">
          <i class="bi bi-boxes"></i>
          <span>Curso  </span>
        </a>
      </li>
         <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == '../materia/') { echo 'active';}  ?>" href="../materia/">
          <i class="bi bi-book"></i>
          <span>Materia  </span>
        </a>
      </li>

        <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == '../profesor/') { echo 'active';}  ?>" href="../profesor/">
        <i class="bi bi-person-workspace"></i>
          <span>Profesor  </span>
        </a>
      </li>

      <?php } ?>
        <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == '../alumnos/') { echo 'active';}  ?>" href="../alumnos/">
          <i class="bi bi-people"></i>
          <span>Alumnos  </span>
        </a>
      </li>

       <?php if($_SESSION['codTipoUsuario'] == 1 ||  $_SESSION['codTipoUsuario'] == 2 || $_SESSION['codTipoUsuario'] == 4){ ?>
      <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == '../notas/') { echo 'active';}  ?>" href="../notas/">
         <i class="bi bi-archive"></i>
          <span>Registrar Notas  </span>
        </a>
      </li>

      <?php } ?>

      <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == '../centralizador/') { echo 'active';}  ?>" href="../centralizador/">
          <i class="bi bi-file-check"></i>
          <span>Centralizar Anual  </span>
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == '../boletin/') { echo 'active';}  ?>" href="../boletin/">
       <i class="bi bi-file-earmark-pdf"></i>
          <span>Generar Boletín  </span>
        </a>
      </li>
      

       <?php if($_SESSION['codTipoUsuario'] == 1 || $_SESSION['codTipoUsuario'] == 4){ ?>
      <li class="nav-heading">FINANZAS</li>
      <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == '../ingresos/') { echo 'active';}  ?>" href="../ingresos/">
       <i class="bi bi-cash-coin"></i>
          <span>Mensualidades (Ingresos)  </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == '../deudores/') { echo 'active';}  ?>" href="../deudores/">
       <i class="bi bi-person-x"></i>
          <span>Deudores  </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == '../egresos/') { echo 'active';}  ?>" href="../egresos/">
       <i class="bi bi-cart-dash"></i>
          <span>Egresos  </span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == '../balance/') { echo 'active';}  ?>" href="../balance/">
       <i class="bi bi-bar-chart-line"></i>
          <span>Balance General  </span>
        </a>
      </li>
      <?php } ?>

       <?php if($_SESSION['codTipoUsuario'] == 1 || $_SESSION['codTipoUsuario'] == 3 || $_SESSION['codTipoUsuario'] == 5){ ?>

      <li class="nav-heading">CONFIGURACION</li>

      <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == '../informacion/') { echo 'active';}  ?>" href="../informacion/">
      <i class="bi bi-info-circle"></i>
            <span>Unidad Educativa</span>
          </a>
      </li>

       <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == '../usuario/') { echo 'active';}  ?>" href="../usuario/">
      <i class="bi bi-person-vcard-fill"></i>
            <span>Usuarios</span>
          </a>
      </li>

        <?php } ?>
      <!-- <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == 'calendario.php') { echo 'active';} ?>" href="calendario.php">
          <i class="bi bi-calendar"></i>
          <span>Calendario  </span>
        </a>
      </li> -->
      <!-- <li class="nav-heading">REPORTES</li>

      <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == 'reportecompras.php') { echo 'active';} ?>" href="reporteCompras.php">
          <i class="bi bi-bookmark-plus-fill"></i>
          <span>Reporte Compras</span>
        </a>
      </li>

       <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == 'reportecapital.php') { echo 'active';} ?>" href="reporteCapital.php">
          <i class="bi bi-bookmark-plus-fill"></i>
          <span>Reporte de Capital</span>
        </a>
      </li> -->

      <!-- <li class="nav-item">
        <a class="nav-link collapsed  <?php if (strtolower($nombredelarchivo) == 'acontecimientos.php') { echo 'active';} ?>" href="acontecimientos.php">
          <i class="bi bi-archive-fill"></i>
          <span>Acontecimientos</span>
        </a>
      </li> -->
      <!-- End Dashboard Nav -->

      <!-- 
      <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Components</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="components-alerts.html">
              <i class="bi bi-circle"></i><span>Alerts</span>
            </a>
          </li>        
        </ul>
      </li> -->
      <!-- End Components Nav -->

     

      <!-- <li class="nav-heading">Pages</li>

      <li class="nav-item">
        <a class="nav-link collapsed" href="users-profile.html">
          <i class="bi bi-person"></i>
          <span>Profile</span>
        </a>
      </li> -->
      <!-- End Profile Page Nav -->


    </ul>

  </aside><!-- End Sidebar-->