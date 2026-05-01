<?php
if(!isset($ruta_assets)){
    $ruta_assets = "../../assets/";
}
?>
<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
    class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="<?php echo $ruta_assets; ?>vendor/apexcharts/apexcharts.min.js"></script>
<script src="<?php echo $ruta_assets; ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $ruta_assets; ?>vendor/chart.js/chart.umd.js"></script>
<script src="<?php echo $ruta_assets; ?>vendor/echarts/echarts.min.js"></script>
<script src="<?php echo $ruta_assets; ?>vendor/quill/quill.min.js"></script>
<script src="<?php echo $ruta_assets; ?>vendor/simple-datatables/simple-datatables.js"></script>
<script src="<?php echo $ruta_assets; ?>vendor/tinymce/tinymce.min.js"></script>
<script src="<?php echo $ruta_assets; ?>vendor/php-email-form/validate.js"></script>

<!-- jQuery -->
<script src="<?php echo $ruta_assets; ?>vendor/jquery/jquery.min.js"></script>
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<!-- <script src="assets/vendor/js/lightbox.js"></script> -->
<!-- <script src="assets/vendor/dist/js/lightbox-plus-jquery.js"></script> -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script> -->
<!-- Template Main JS File -->
<script src="<?php echo $ruta_assets; ?>js/main.js"></script>

<!-- DataTables responsive -->
<!-- <link rel="stylesheet" type="text/css" href="<?php echo $ruta_assets; ?>vendor/dataTables-bs4/css/dataTables.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $ruta_assets; ?>vendor/dataTables-bs4/css/responsive.bootstrap4.min.css" />
    <script type="text/javascript" src="<?php echo $ruta_assets; ?>vendor/dataTables-bs4/js/datatables.min.js"></script>
    <script type="text/javascript" src="<?php echo $ruta_assets; ?>vendor/dataTables-bs4/js/dataTables.responsive.min.js"></script> -->
<!-- DataTables  & Plugins -->
<script src="<?php echo $ruta_assets; ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo $ruta_assets; ?>vendor/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="<?php echo $ruta_assets; ?>vendor/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="<?php echo $ruta_assets; ?>vendor/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="<?php echo $ruta_assets; ?>vendor/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="<?php echo $ruta_assets; ?>vendor/datatables-buttons/js/buttons.bootstrap4.min.js"></script>

<!-- <script src="<?php echo $ruta_assets; ?>vendor/fullcalendar/main.js"></script> -->
<!-- fullcalendar español-->
<!-- <script src="<?php echo $ruta_assets; ?>vendor/fullcalendar/locales/es.js"></script> -->

<style>
/* =========================================================
   Modernización Global de DataTables
   ========================================================= */
table.dataTable {
    border-collapse: collapse !important;
    margin-top: 0px !important;
    margin-bottom: 15px !important;
    width: 100% !important;
}
table.dataTable.table-bordered, 
table.dataTable.table-bordered th, 
table.dataTable.table-bordered td {
    border: none !important;
}
table.dataTable th, table.dataTable td {
    border-bottom: 1px solid #edf2f9 !important;
    padding: 12px 15px !important;
    vertical-align: middle !important;
}
table.dataTable thead th {
    background-color: #f8f9fa !important;
    color: #6c757d !important;
    font-weight: 600 !important;
    text-transform: uppercase !important;
    font-size: 0.75rem !important;
    letter-spacing: 0.5px !important;
    border-bottom: 2px solid #e9ecef !important;
}
table.dataTable tbody tr {
    transition: all 0.2s ease !important;
}
table.dataTable tbody tr:hover {
    background-color: #f1f4f8 !important;
    transform: scale(1.002) !important;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05) !important;
    z-index: 10 !important;
    position: relative !important;
    border-radius: 8px !important;
}
.dataTables_wrapper .dataTables_filter input {
    border-radius: 20px !important;
    padding: 6px 15px !important;
    border: 1px solid #ced4da !important;
    outline: none !important;
    box-shadow: inset 0 1px 2px rgba(0,0,0,.075) !important;
    transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out !important;
}
.dataTables_wrapper .dataTables_filter input:focus {
    border-color: #86b7fe !important;
    box-shadow: 0 0 0 0.25rem rgba(13,110,253,.25) !important;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.page-item .page-link {
    border-radius: 50% !important;
    margin: 0 3px !important;
    width: 35px;
    height: 35px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: none !important;
    color: #6c757d;
    background-color: #f8f9fa;
    transition: all 0.2s ease;
}
.dataTables_wrapper .dataTables_paginate .paginate_button.page-item.active .page-link {
    background-color: #0d6efd !important;
    color: white !important;
    box-shadow: 0 3px 6px rgba(13,110,253,0.4) !important;
}
.dataTables_wrapper .dataTables_info {
    font-size: 0.85rem !important;
    color: #aab2bd !important;
    padding-top: 10px !important;
}
.dataTables_wrapper .dataTables_length select {
    border-radius: 10px !important;
    padding: 4px 10px !important;
    border: 1px solid #ced4da !important;
}
/* Contenedor responsivo sin bordes sucios */
.table-responsive {
    border: none !important;
}
/* Eliminar espacio entre cabecera y cuerpo en scrollY */
.dataTables_scrollHeadInner, .dataTables_scrollHeadInner table {
    margin-bottom: 0 !important;
    padding-bottom: 0 !important;
}
.dataTables_scrollBody table {
    margin-top: 0 !important;
    padding-top: 0 !important;
}
</style>

<script>
$(document).ready(function() {
    // defaults globales
    $.extend(true, $.fn.dataTable.defaults, {
        "scrollY": "350px",     // Alto fijo del contenedor de la tabla
        "scrollX": true,        // Scroll horizontal habilitado
        "scrollCollapse": true, // Permite que la tabla se encoja si tiene pocas filas
        "language": {
            "processing":     "Procesando...",
            "search":         "Buscar:",
            "searchPlaceholder": "...",
            "lengthMenu":     "Mostrar _MENU_",
            "info":           "Mostrando _START_ a _END_ de _TOTAL_",
            "infoEmpty":      "Mostrando 0 a 0 de 0",
            "infoFiltered":   "(filtrado de _MAX_)",
            "loadingRecords": "Cargando...",
            "zeroRecords":    "No se encontraron coincidencias",
            "emptyTable":     "No hay datos en esta tabla",
            "paginate": {
                "first":      "«",
                "previous":   "‹",
                "next":       "›",
                "last":       "»"
            }
        }
    });
    
    // Forzar limpieza de bordes al inicializar
    $(document).on('init.dt', function (e, settings) {
        var api = new $.fn.dataTable.Api(settings);
        $(api.table().node()).removeClass('table-bordered').addClass('table table-hover table-borderless');
    });
});
</script>