<?php
include '../../contenido/sesion.php';
include '../../clases/registro.php';
include '../../clases/parametros.php';
$registro = new registro();
$iparametro = new parametros();
$vieneDeBalance = isset($_GET['origen']) && $_GET['origen'] === 'balance';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include_once "../../contenido/extensiones.php"; ?>
    <link href="../../assets/css/style.css" rel="stylesheet">
</head>

<body>
    <?php include_once "../../contenido/encabezado.php"; ?>
    <?php include_once "../../contenido/menu.php"; ?>
    <main id="main" class="main">
        <div class="pagetitle">
            <div class="row">
                <div class="col-md-6" style="text-align:left;">
                    <h1>Registro de Mensualidades (Ingresos)</h1>
                </div>
                <div class="col-md-6" style="text-align:right;">
                    <?php if($vieneDeBalance){ ?>
                    <a class="btn btn-secondary me-2" href="../balance/">Volver al Balance</a>
                    <?php } ?>
                    <button class="btn btn-primary" type="button" onclick="agregar()">Registrar Ingreso</button>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row mt-3">
                <div class="col-lg-12">
                    <div class="card shadow-lg" style="border-top:solid 3px blue;">
                        <div class="card-body">
                            <div class="row pt-3">
                                <div class="col-md-2">
                                    <label>Gestion</label>
                                    <input type="number" id="txtGestionFiltro" class="form-control"
                                        value="<?php echo date('Y'); ?>" onchange="traerAlumnosFiltroIngreso()">
                                </div>
                                <div class="col-md-2">
                                    <label>Mes</label>
                                    <select id="txtMesFiltro" class="form-select">
                                        <option value="0">Todos los Meses</option>
                                        <option value="1">Enero</option>
                                        <option value="2">Febrero</option>
                                        <option value="3">Marzo</option>
                                        <option value="4">Abril</option>
                                        <option value="5">Mayo</option>
                                        <option value="6">Junio</option>
                                        <option value="7">Julio</option>
                                        <option value="8">Agosto</option>
                                        <option value="9">Septiembre</option>
                                        <option value="10">Octubre</option>
                                        <option value="11">Noviembre</option>
                                        <option value="12">Diciembre</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Curso</label>
                                    <select id="txtCursoFiltro" class="form-select" onchange="traerAlumnosFiltroIngreso()">
                                        <?php echo $iparametro->DropDownCursos(); ?>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label>Alumno</label>
                                    <select id="txtAlumnoFiltro" class="form-select">
                                        <option value="0">Todos los alumnos</option>
                                    </select>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <button class="btn btn-dark w-100" onclick="filtrar()">Aplicar Filtro</button>
                                </div>
                            </div>
                            <br>
                            <div id="divResultado"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include_once "../../contenido/piePagina.php"; ?>
    <?php include_once "../../contenido/extensionesFooter.php"; ?>
    <script>
        $(document).ready(function () {
            aplicarFiltrosDesdeUrl();
            traerAlumnosFiltroIngreso(function () {
                filtrar();
            });
        });

        function aplicarFiltrosDesdeUrl() {
            var params = new URLSearchParams(window.location.search);
            var gestion = params.get('gestion');
            var mes = params.get('mes');

            if (gestion) {
                $("#txtGestionFiltro").val(gestion);
            }

            if (mes) {
                $("#txtMesFiltro").val(mes);
                $("#txtMes").val(mes);
            }
        }

        function agregar() { $("#modalCrear").modal('show'); }

        function ConfirmarRegistrar() {
            var codAlumno = $("#txtAlumno").val();
            var monto = $("#txtMonto").val();
            var fechaPago = $("#txtFecha").val();
            var gestion = $("#txtGestion").val();
            var mes = $("#txtMes").val();
            var concepto = $("#txtConcepto").val();

            if (codAlumno == 0 || monto == "" || concepto == "") { swal('Ops', 'Llene los datos basicos.', 'warning'); return; }

            $.post("../../respuestaParcial.php?operacion=crearIngreso", {
                codAlumno: codAlumno, monto: monto, fechaPago: fechaPago, gestion: gestion, mes: mes, concepto: concepto
            }, function (data) {
                if (data.request == 'ok') {
                    swal('Exito', 'Ingreso guardado', 'success');
                    $("#modalCrear").modal('hide');
                    filtrar();
                } else { swal('Error', data.mensaje, 'error'); }
            }, "json");
        }

        function eliminarIngreso(id) {
            swal({
                title: "¿Eliminar registro?", type: "warning", icon: "warning",
                buttons: { confirm: { text: "Si", className: "btn btn-success" }, cancel: { visible: true, className: "btn btn-danger" } }
            }).then((Delete) => {
                if (Delete) {
                    $.post("../../respuestaParcial.php?operacion=eliminarIngreso", { id: id }, function (data) {
                        if (data.request == 'ok') { swal('Eliminado', '', 'success'); filtrar(); }
                    }, "json");
                }
            });
        }

        function traerAlumnosHabilitados() {
            var gestion = $("#txtGestionAlumno").val();
            var codCurso = $("#txtGradoAlumno").val();
            $("#txtAlumno").html('<option value="0">Cargando...</option>');
            $.post("../../respuestaParcial.php?operacion=traerAlumnosFiltroFinanzas", {
                gestion: gestion, codCurso: codCurso
            }, function (data) {
                $("#txtAlumno").html(data);
            });
        }

        function traerAlumnosFiltroIngreso(callback) {
            var gestion = $("#txtGestionFiltro").val();
            var codCurso = $("#txtCursoFiltro").val();
            var alumnoSeleccionado = $("#txtAlumnoFiltro").attr('data-selected') || "0";

            if (codCurso == 0 || codCurso == "") {
                $("#txtAlumnoFiltro").html('<option value="0">Todos los alumnos</option>');
                $("#txtAlumnoFiltro").removeAttr('data-selected');
                if (typeof callback === 'function') callback();
                return;
            }

            $("#txtAlumnoFiltro").html('<option value="0">Cargando...</option>');
            $.post("../../respuestaParcial.php?operacion=traerAlumnosFiltroFinanzas", {
                gestion: gestion, codCurso: codCurso
            }, function (data) {
                $("#txtAlumnoFiltro").html('<option value="0">Todos los alumnos</option>' + data);
                $("#txtAlumnoFiltro").val(alumnoSeleccionado);
                $("#txtAlumnoFiltro").removeAttr('data-selected');
                if (typeof callback === 'function') callback();
            });
        }

        function filtrar() {
            var gestion = $("#txtGestionFiltro").val();
            var mes = $("#txtMesFiltro").val();
            var codCurso = $("#txtCursoFiltro").val();
            var codAlumno = $("#txtAlumnoFiltro").val();
            $("#divResultado").html('Cargando...');
            $.post("../../respuestaParcial.php?operacion=traerIngresos", {
                gestion: gestion, mes: mes, codCurso: codCurso, codAlumno: codAlumno
            }, function (data) {
                $("#divResultado").html(data);
                $('#tablaHistorico').DataTable({ "scrollX": true });
            });
        }
    </script>
    <div class="modal fade" id="modalCrear">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Ingresar Pago</h4>
                </div>
                <div class="modal-body row">
                    <div class="col-md-6 mt-2">
                        <label>Gestion Estudiantil</label>
                        <input type="number" id="txtGestionAlumno" class="form-control shadow-lg"
                            value="<?php echo date('Y'); ?>" onchange="traerAlumnosHabilitados()">
                    </div>
                    <div class="col-md-6 mt-2">
                        <label>Grado del Alumno</label>
                        <select id="txtGradoAlumno" class="form-select shadow-lg" onchange="traerAlumnosHabilitados()">
                            <?php echo $iparametro->DropDownCursos(); ?>
                        </select>
                    </div>
                    <div class="col-md-12 mt-2">
                        <label>Estudiante (Activos)</label>
                        <select id="txtAlumno" class="form-select shadow-lg">
                            <option value="0">Seleccione Gestion y Grado primero...</option>
                        </select>
                    </div>
                    <div class="col-md-6 mt-2"><label>Monto a Pagar (Bs.)</label><input type="number" id="txtMonto"
                            class="form-control shadow-lg" step="0.01" value="0"></div>
                    <div class="col-md-6 mt-2" style="display:none;"><label>Fecha Registro Pago</label><input
                            type="date" id="txtFecha" class="form-control shadow-lg"
                            value="<?php echo date('Y-m-d'); ?>"></div>
                    <div class="col-md-6 mt-2" style="display: none;"><label>Gestion de Cobro</label><input type="number" id="txtGestion"
                            class="form-control shadow-lg" value="<?php echo date('Y'); ?>" readonly></div>
                    <div class="col-md-6 mt-2"><label>Mes a Pagar</label>
                        <select id="txtMes" class="form-select shadow-lg">
                            <option value="1" <?php if (date('n') == 1) { echo "selected"; } ?>>Enero</option>
                            <option value="2" <?php if (date('n') == 2) { echo "selected"; } ?>>Febrero</option>
                            <option value="3" <?php if (date('n') == 3) { echo "selected"; } ?>>Marzo</option>
                            <option value="4" <?php if (date('n') == 4) { echo "selected"; } ?>>Abril</option>
                            <option value="5" <?php if (date('n') == 5) { echo "selected"; } ?>>Mayo</option>
                            <option value="6" <?php if (date('n') == 6) { echo "selected"; } ?>>Junio</option>
                            <option value="7" <?php if (date('n') == 7) { echo "selected"; } ?>>Julio</option>
                            <option value="8" <?php if (date('n') == 8) { echo "selected"; } ?>>Agosto</option>
                            <option value="9" <?php if (date('n') == 9) { echo "selected"; } ?>>Septiembre</option>
                            <option value="10" <?php if (date('n') == 10) { echo "selected"; } ?>>Octubre</option>
                            <option value="11" <?php if (date('n') == 11) { echo "selected"; } ?>>Noviembre</option>
                            <option value="12" <?php if (date('n') == 12) { echo "selected"; } ?>>Diciembre</option>
                        </select>
                    </div>
                    <div class="col-md-12 mt-2" style="display: none;">
                        <label>Concepto</label>
                        <input type="text" id="txtConcepto" class="form-control shadow-lg" value="Mensualidad Escolar">
                    </div>
                </div>
                <div class="modal-footer mt-3">
                    <button class="btn btn-primary rounded-pill" onclick="ConfirmarRegistrar()">Guardar Pago</button>
                    <button class="btn btn-danger rounded-pill" data-bs-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
