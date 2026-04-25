<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);
//include "../template/s_sesion.php";

include 'clases/parametros.php';
require_once "clases/registro.php";

$iregistro = new registro();

$iparametro = new parametros();

$operacion = $_GET["operacion"];
$op = @$_GET['op'];

if ($operacion == "crearAnuncio") {
    $titulo = @$_POST["titulo"];
    $descripcion = @$_POST["descripcion"];
    $fechaVencimiento = @$_POST["fechaVencimiento"];
    $codUsuario = $_SESSION['codigousuario'];

    $res = $iregistro->crearAnuncio($titulo, $descripcion, $fechaVencimiento, $codUsuario);
    echo json_encode($res);
    exit();
}

if ($operacion == "traerAnuncios") {
    $res = $iregistro->traerAnuncios();
    echo json_encode($res);
    exit();
}

if ($operacion == "eliminarAnuncio") {
    $id = @$_POST["id"];
    $res = $iregistro->eliminarAnuncio($id);
    echo json_encode($res);
    exit();
}

if ($operacion == "guardarAlumnos_csv") {

    $filas = @$_POST["filas"];
    $codGrado = @$_POST["codGrado"];
    $res = $iregistro->crearAlumnoCSV($filas, $codGrado);

    echo json_encode($res);
}

if ($operacion == "ActivarUsuario") {

    $codigo = @$_POST["codigo"];
    $res = $iregistro->ActivarUsuario($codigo);

    echo json_encode($res);
}

if ($operacion == "eliminarUsuario") {

    $codigo = @$_POST["codigo"];
    $res = $iregistro->eliminarUsuario($codigo);

    echo json_encode($res);
}


if ($operacion == "editarUsuario") {

    $codigo = @$_POST["codigo"];

    $nombre = @$_POST["nombres"];
    $apellido = @$_POST["apellidos"];
    $usuario = @$_POST["usuario"];
    $tipoUsuario = @$_POST["codTipoUsuario"];
    $clave = @$_POST["clave"];

    $res = $iregistro->editarUsuario($codigo, $nombre, $apellido, $usuario, $tipoUsuario, $clave);

    echo json_encode($res);

}

if ($operacion == "crearUsuario") {


    $nombre = @$_POST["nombre"];
    $apellido = @$_POST["apellido"];
    $usuario = @$_POST["usuario"];
    $tipoUsuario = @$_POST["tipoUsuario"];
    $clave = @$_POST["clave"];

    $res = $iregistro->crearUsuario($nombre, $apellido, $usuario, $tipoUsuario, $clave);

    echo json_encode($res);

}


if ($operacion == "traerUsuario") {



    $res = $iregistro->traerUsuario();

    $html = "";
    $html .= ' <div class="table-responsive">';
    $html .= ' <table class="table datatable table-striped table-hover table-bordered" id="tablaHistorico">';
    $html .= '<thead>';
    $html .= '  <tr>';
    $html .= '    <th scope="col">#</th>';
    $html .= '    <th scope="col">Nombre Completo</th>';
    $html .= '    <th scope="col">Usuario</th>';
    $html .= '    <th scope="col">Tipo Usuario</th>';
    $html .= '    <th scope="col">Estado</th>';
    $html .= '    <th scope="col">Accion</th>';
    $html .= '  </tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    if ($res->RowCount() > 0) {
        $res->MoveFirst();

        $count = 0;
        while (!$res->EndOfSeek()) {

            $count++;
            $row = $res->Row();


            $html .= '<tr>';
            $html .= '    <td>' . $count . '</td>';
            $html .= '    <td>' . ucfirst(strtolower($row->nombreUsuario)) . '</td>';
            $html .= '    <td>' . $row->usuario . '</td>';
            $html .= '    <td>' . $row->tipoUsuario . '</td>';

            if ($row->baja == 0) {
                $html .= '    <td> <span class="badge bg-success rounded-pill">Activo</span></td>';
            } else {
                $html .= '    <td> <span class="badge bg-danger rounded-pill">Eliminada</span></td>';
            }
            $html .= '<td> ';
            if ($row->baja == 0) {
                $html .= '&nbsp;<button class="btn btn-danger btn-sm"
            title="Eliminar Usuario"
            type="button"
            onclick=\'eliminarDato('
                    . $row->codUsuario . ','
                    . json_encode($row->nombre) . ' )\'>
            <i class="bi bi-trash"></i>
            </button>';
                $html .= '&nbsp;<button class="btn btn-warning btn-sm"
            title="Editar Usuario"
            type="button"
            onclick=\'editarDatos('
                    . json_encode($row->codUsuario) . ','
                    . json_encode($row->nombre) . ','
                    . json_encode($row->apellidos) . ','
                    . json_encode($row->codTipoUsuario) . ','
                    . json_encode($row->usuario) . ')\'>
            <i class="bi bi-pencil"></i>
          </button>';

            } else {
                $html .= '&nbsp;<button class="btn btn-primary btn-sm"
                title="Activar Usuario"
                type="button"
                onclick=\'ActivarDato('
                    . $row->codUsuario . ','
                    . json_encode($row->nombre) . ' )\'>
                <i class="bi bi-check"></i>
                </button>';
            }
            $html .= '</td></tr>';

        }

    }
    $html .= ' </tbody></table>';

    echo $html;


}


if ($operacion == "crearDatosColegio") {

    $codigoUnidad = @$_POST["codigoUnidad"];
    $UnidadEducativa = @$_POST["UnidadEducativa"];
    $Distrito = @$_POST["Distrito"];
    $CodDepartamento = @$_POST["CodDepartamento"];
    $Dependencia = @$_POST["Dependencia"];
    $Turno = @$_POST["Turno"];

    $res = $iregistro->crearDatosColegio($codigoUnidad, $UnidadEducativa, $Distrito, $CodDepartamento, $Dependencia, $Turno);

    echo json_encode($res);

}



if ($operacion == "traerBoletin") {



    $codCurso = @$_POST["codCurso"];
    $gestion = @$_POST["gestion"];
    $codAlumno = @$_POST["codAlumno"];


    $res = $iregistro->traerBoletin($codCurso, $gestion, $codAlumno);

    $html = "";

    $html .= ' <table class="table datatable table-striped table-hover table-bordered" style="text-align:center; font-size:14px;" id="tablaHistorico">';
    $html .= '<thead>';
    $html .= '  <tr>';
    $html .= '    <th scope="col" style="text-align:center;" rowspan=3> Areas Curriculares</th>';
    $html .= '    <th scope="col" style="text-align:center;" rowspan=2>1er. Trismestre</th>';
    $html .= '    <th scope="col" style="text-align:center;" rowspan=2>2do. Trismestre</th>';
    $html .= '    <th scope="col" style="text-align:center;" rowspan=2>3er Trismestre</th>';
    $html .= '    <th scope="col" style="text-align:center;" colspan=2>Promedio Anual</th>';
    $html .= '  </tr>';

    $html .= '  <tr>';
    $html .= '    <th scope="col" style="text-align:center;">Numeral</th>';
    $html .= '    <th scope="col" style="text-align:center;">Literal</th>';
    $html .= '  </tr>';


    $html .= '</thead>';
    $html .= '<tbody>';

    if ($res->RowCount() > 0) {
        $res->MoveFirst();

        $count = 0;
        while (!$res->EndOfSeek()) {

            $count++;
            $row = $res->Row();
            $notas1 = $iregistro->traerNotasAlumnos($row->codMateria, $row->codCursoAlumno, 1, $gestion);
            $promedioPrimerTrimestre = $iregistro->calcularPromedio($notas1);

            $notas2 = $iregistro->traerNotasAlumnos($row->codMateria, $row->codCursoAlumno, 2, $gestion);
            $promedioSegundoTrimestre = $iregistro->calcularPromedio($notas2);

            $notas3 = $iregistro->traerNotasAlumnos($row->codMateria, $row->codCursoAlumno, 3, $gestion);
            $promedioTercerTrimestre = $iregistro->calcularPromedio($notas3);

            $promedioAnualTrimestre = number_format(($promedioPrimerTrimestre + $promedioSegundoTrimestre + $promedioTercerTrimestre) / 3, 0);

            $html .= '<tr>';

            $html .= '    <td style="width:200px;text-align:left;" >' . ucfirst(strtolower($row->materia)) . '</td>';


            $html .= '    <td style="text-align:center;">  ' . $promedioPrimerTrimestre . ' </td>';
            $html .= '    <td style="text-align:center;">  ' . $promedioSegundoTrimestre . ' </td>';
            $html .= '    <td style="text-align:center;">  ' . $promedioTercerTrimestre . ' </td>';

            if ($promedioAnualTrimestre >= 50) {
                $html .= '    <td style="text-align:center;"> <span class="badge bg-success rounded-pill">' . $promedioAnualTrimestre . ' </span></td>';
            } else {
                $html .= '    <td style="text-align:center;"> <span class="badge bg-danger rounded-pill">' . $promedioAnualTrimestre . ' </span></td>';
            }
            $html .= '    <td style="text-align:center;">  </td>';
            $html .= ' </tr>';

        }

    }
    $html .= ' </tbody></table>  ';

    echo $html;


}

if ($operacion == "traerCentralizadorNotas") {


    $codProfesor = @$_POST["codProfesor"];
    $codCurso = @$_POST["codCurso"];
    $gestion = @$_POST["gestion"];
    $codMateria = @$_POST["codMateria"];


    $res = $iregistro->traerNotas($codProfesor, $codCurso, $gestion, $codMateria);

    $html = "";
    //   $html .=' <div class="table-responsive">';
    $html .= ' <table class="table datatable table-striped table-hover table-bordered" style="text-align:center; font-size:14px;" id="tablaHistorico">';
    $html .= '<thead>';
    $html .= '  <tr>';
    $html .= '    <th scope="col">#</th>';
    $html .= '    <th scope="col"> NOMBRE ALUMNO</th>';
    $html .= '    <th scope="col" style="text-align:center;">PRIMER TRIMESTRE</th>';
    $html .= '    <th scope="col" style="text-align:center;">SEGUNDO TRIMESTRE</th>';
    $html .= '    <th scope="col" style="text-align:center;">TERCER TRIMESTRE</th>';
    $html .= '    <th scope="col" style="background-color: #c2d7f7ff;text-align:center;">PROMEDIO ANUAL</th>';
    $html .= '  </tr>';



    $html .= '</thead>';
    $html .= '<tbody>';

    if ($res->RowCount() > 0) {
        $res->MoveFirst();

        $count = 0;
        while (!$res->EndOfSeek()) {

            $count++;
            $row = $res->Row();
            $notas1 = $iregistro->traerNotasAlumnos($row->codMateria, $row->codCursoAlumno, 1, $gestion);
            $promedioPrimerTrimestre = $iregistro->calcularPromedio($notas1);

            $notas2 = $iregistro->traerNotasAlumnos($row->codMateria, $row->codCursoAlumno, 2, $gestion);
            $promedioSegundoTrimestre = $iregistro->calcularPromedio($notas2);

            $notas3 = $iregistro->traerNotasAlumnos($row->codMateria, $row->codCursoAlumno, 3, $gestion);
            $promedioTercerTrimestre = $iregistro->calcularPromedio($notas3);

            $promedioAnualTrimestre = number_format(($promedioPrimerTrimestre + $promedioSegundoTrimestre + $promedioTercerTrimestre) / 3, 0);

            $html .= '<tr>';
            $html .= '    <td>' . $count . '</td>';
            $html .= '    <td style="width:200px;text-align:left;" >' . ucfirst(strtolower($row->nombreAlumno)) . '</td>';


            $html .= '    <td style="text-align:center;">  ' . $promedioPrimerTrimestre . ' </td>';
            $html .= '    <td style="text-align:center;">  ' . $promedioSegundoTrimestre . ' </td>';
            $html .= '    <td style="text-align:center;">  ' . $promedioTercerTrimestre . ' </td>';

            if ($promedioAnualTrimestre >= 50) {
                $html .= '    <td style="text-align:center;"> <span class="badge bg-success rounded-pill">' . $promedioAnualTrimestre . ' </span></td>';
            } else {
                $html .= '    <td style="text-align:center;"> <span class="badge bg-danger rounded-pill">' . $promedioAnualTrimestre . ' </span></td>';
            }
            $html .= ' </tr>';

        }

    }
    $html .= ' </tbody></table>  ';

    echo $html;


}


if ($operacion == "traerNotas") {


    $codProfesor = @$_POST["codProfesor"];
    $codCurso = @$_POST["codCurso"];
    $gestion = @$_POST["gestion"];
    $codMateria = @$_POST["codMateria"];
    $trimestre = @$_POST["trimestre"];

    $res = $iregistro->traerNotas($codProfesor, $codCurso, $gestion, $codMateria);

    $html = "";
    //   $html .=' <div class="table-responsive">';
    $html .= ' <table class="table datatable table-striped table-hover table-bordered" style="text-align:center; font-size:14px;" id="tablaHistorico">';
    $html .= '<thead>';
    $html .= '  <tr>';
    $html .= '    <th scope="col" rowspan=2>#</th>';
    $html .= '    <th scope="col" rowspan=2> NOMBRE ALUMNO</th>';
    $html .= '    <th scope="col" colspan=1 class="cabe_Ser">SER / 10</th>';
    $html .= '    <th scope="col" colspan=1 class="cabe_Saber">SABER / 45</th>';
    $html .= '    <th scope="col" colspan=1 class="cabe_Hacer">HACER / 40</th>';
    // $html .='    <th scope="col" colspan=1 class="cabe_Decidir">DECIDIR / 5</th>';
    $html .= '    <th scope="col" style="background-color: #ecebb7ff;" rowspan=2>AUTOEVALUACIÓN / 5</th>';
    $html .= '    <th scope="col" style="background-color: #c2d7f7ff;" rowspan=2>PROM. TRIMESTRAL</th>';
    $html .= '  </tr>';

    $html .= '  <tr>';

    $html .= '    <th scope="col" class="ser" style="display:none;"><input type="number" style="width:60px;" class="form-control-plaintext" readonly> </th>';
    $html .= '    <th scope="col" class="ser" style="display:none;"><input type="number" style="width:60px;" class="form-control-plaintext" readonly></th>';
    $html .= '    <th scope="col" class="ser" style="display:none;"><input type="number" style="width:60px;" class="form-control-plaintext" readonly></th>';
    $html .= "    <th scope='col' style='background-color: #d6d6d6ff;'>PROMEDIO
     <button id='btnSer' class='pull-right' onclick='mostrarFilaSer()'>+</button>
                                      <input type='hidden' id='txtColumnaSer' value='0'></th>";

    $html .= '    <th scope="col" class="saber" style="display:none;"><input type="number" style="width:60px;" class="form-control-plaintext" readonly></th>';
    $html .= '    <th scope="col" class="saber" style="display:none;"><input type="number" style="width:60px;" class="form-control-plaintext" readonly></th>';
    $html .= '    <th scope="col" class="saber" style="display:none;"><input type="number" style="width:60px;" class="form-control-plaintext" readonly></th>';
    $html .= '    <th scope="col" class="saber" style="display:none;"><input type="number" style="width:60px;" class="form-control-plaintext" readonly></th>';
    $html .= '    <th scope="col" class="saber" style="display:none;"><input type="number" style="width:60px;" class="form-control-plaintext" readonly></th>';
    $html .= '    <th scope="col" class="saber" style="display:none;"><input type="number" style="width:60px;" class="form-control-plaintext" readonly></th>';
    $html .= "    <th scope='col' style='background-color: #d6d6d6ff;'>PROMEDIO
     <button id='btnSaber' class='pull-right' onclick='mostrarFilaSaber()'>+</button>
                                      <input type='hidden' id='txtColumnaSaber' value='0'></th>";

    $html .= '    <th scope="col" class="hacer" style="display:none;"><input type="number" style="width:60px;" class="form-control-plaintext" readonly></th>';
    $html .= '    <th scope="col" class="hacer" style="display:none;"><input type="number" style="width:60px;" class="form-control-plaintext" readonly></th>';
    $html .= '    <th scope="col" class="hacer" style="display:none;"><input type="number" style="width:60px;" class="form-control-plaintext" readonly></th>';
    $html .= '    <th scope="col" class="hacer" style="display:none;"><input type="number" style="width:60px;" class="form-control-plaintext" readonly></th>';
    $html .= '    <th scope="col" class="hacer" style="display:none;"><input type="number" style="width:60px;" class="form-control-plaintext" readonly></th>';
    $html .= '    <th scope="col" class="hacer" style="display:none;"><input type="number" style="width:60px;" class="form-control-plaintext" readonly></th>';
    $html .= "    <th scope='col' style='background-color: #d6d6d6ff;'>PROMEDIO
     <button id='btnHacer' class='pull-right' onclick='mostrarFilaHacer()'>+</button>
                                      <input type='hidden' id='txtColumnaHacer' value='0'></th>";

    // $html .='    <th scope="col" class="decidir" style="display:none;"><input type="number" style="width:60px;" class="form-control-plaintext" readonly></th>';
    // $html .='    <th scope="col" class="decidir" style="display:none;"><input type="number" style="width:60px;" class="form-control-plaintext" readonly></th>';
    // $html .='    <th scope="col" class="decidir" style="display:none;"><input type="number" style="width:60px;" class="form-control-plaintext" readonly></th>';
    //  $html .="    <th scope='col' style='background-color: #d6d6d6ff;'>PROMEDIO
    //  <button id='btnDecidir' class='pull-right' onclick='mostrarFilaDecidir()'>+</button>
    //                                   <input type='hidden' id='txtColumnaDecidir' value='0'></th>";

    $html .= '  </tr>';

    $html .= '</thead>';
    $html .= '<tbody>';

    if ($res->RowCount() > 0) {
        $res->MoveFirst();

        $count = 0;
        while (!$res->EndOfSeek()) {

            $count++;
            $row = $res->Row();
            if($row->codCursoAlumno == '' || $row->codMateria == ''){
                continue   ;
            }
            $notas = $iregistro->traerNotasAlumnos($row->codMateria, $row->codCursoAlumno, $trimestre, $gestion);
            if (!$notas) {
                $notas = (object) [
                    'calificacion1Ser' => 0,
                    'calificacion2Ser' => 0,
                    'calificacion3Ser' => 0,
                    'calificacion1Saber' => 0,
                    'calificacion2Saber' => 0,
                    'calificacion3Saber' => 0,
                    'calificacion4Saber' => 0,
                    'calificacion5Saber' => 0,
                    'calificacion6Saber' => 0,
                    'calificacion1Hacer' => 0,
                    'calificacion2Hacer' => 0,
                    'calificacion3Hacer' => 0,
                    'calificacion4Hacer' => 0,
                    'calificacion5Hacer' => 0,
                    'calificacion6Hacer' => 0,
                    'calificacion1Decidir' => 0,
                    'calificacion2Decidir' => 0,
                    'calificacion3Decidir' => 0,
                    'autoevaluacion' => 0
                ];
            }

            /////////// inicio promedio SER ////////////////
            $promedioSer = 0;
            $totalNotasSer = 0;
            if ($notas->calificacion1Ser != '' && $notas->calificacion1Ser != 0) {
                $totalNotasSer++;
            }
            if ($notas->calificacion2Ser != '' && $notas->calificacion2Ser != 0) {
                $totalNotasSer++;
            }
            if ($notas->calificacion3Ser != '' && $notas->calificacion3Ser != 0) {
                $totalNotasSer++;
            }

            $promedioSer = $notas->calificacion3Ser + $notas->calificacion2Ser + $notas->calificacion1Ser;
            if ($totalNotasSer > 0) {
                $promedioSer = number_format($promedioSer / $totalNotasSer, 0);
            } else {
                $promedioSer = 0; // o null
            }


            /////////// inicio promedio SABER ////////////////
            $promedioSaber = 0;
            $totalNotasSaber = 0;

            if ($notas->calificacion1Saber != '' && $notas->calificacion1Saber != 0) {
                $totalNotasSaber++;
            }
            if ($notas->calificacion2Saber != '' && $notas->calificacion2Saber != 0) {
                $totalNotasSaber++;
            }
            if ($notas->calificacion3Saber != '' && $notas->calificacion3Saber != 0) {
                $totalNotasSaber++;
            }
            if ($notas->calificacion4Saber != '' && $notas->calificacion4Saber != 0) {
                $totalNotasSaber++;
            }
            if ($notas->calificacion5Saber != '' && $notas->calificacion5Saber != 0) {
                $totalNotasSaber++;
            }
            if ($notas->calificacion6Saber != '' && $notas->calificacion6Saber != 0) {
                $totalNotasSaber++;
            }

            $promedioSaber = $notas->calificacion6Saber + $notas->calificacion5Saber + $notas->calificacion4Saber + $notas->calificacion3Saber + $notas->calificacion2Saber + $notas->calificacion1Saber;
            if ($totalNotasSaber > 0) {
                $promedioSaber = number_format($promedioSaber / $totalNotasSaber, 0);
            } else {
                $promedioSaber = 0; // o null
            }



            /////////// inicio promedio HACER ////////////////
            $promedioHacer = 0;
            $totalNotasHacer = 0;
            if ($notas->calificacion1Hacer != '' && $notas->calificacion1Hacer != 0) {
                $totalNotasHacer++;
            }
            if ($notas->calificacion2Hacer != '' && $notas->calificacion2Hacer != 0) {
                $totalNotasHacer++;
            }
            if ($notas->calificacion3Hacer != '' && $notas->calificacion3Hacer != 0) {
                $totalNotasHacer++;
            }
            if ($notas->calificacion4Hacer != '' && $notas->calificacion4Hacer != 0) {
                $totalNotasHacer++;
            }
            if ($notas->calificacion5Hacer != '' && $notas->calificacion5Hacer != 0) {
                $totalNotasHacer++;
            }
            if ($notas->calificacion6Hacer != '' && $notas->calificacion6Hacer != 0) {
                $totalNotasHacer++;
            }

            $promedioHacer = $notas->calificacion6Hacer + $notas->calificacion5Hacer + $notas->calificacion4Hacer + $notas->calificacion3Hacer + $notas->calificacion2Hacer + $notas->calificacion1Hacer;
            if ($totalNotasHacer > 0) {
                $promedioHacer = number_format($promedioHacer / $totalNotasHacer, 0);
            } else {
                $promedioHacer = 0; // o null
            }


            /////////// inicio promedio DECIDIR ////////////////
            $promedioDecidir = 0;
            $totalNotasDecidir = 0;
            // if($notas->calificacion1Decidir != '' && $notas->calificacion1Decidir != 0){
            //     $totalNotasDecidir++;
            // }
            // if($notas->calificacion2Decidir != '' && $notas->calificacion2Decidir != 0){
            //     $totalNotasDecidir++;
            // }
            // if($notas->calificacion3Decidir != '' && $notas->calificacion3Decidir != 0){
            //     $totalNotasDecidir++;
            // }

            // $promedioDecidir = $notas->calificacion3Decidir + $notas->calificacion2Decidir + $notas->calificacion1Decidir;
            // if ($totalNotasDecidir > 0) {
            //     $promedioDecidir = number_format($promedioDecidir / $totalNotasDecidir,0);
            // } else {
            //     $promedioDecidir = 0; // o null
            // }

            $promedioTrimestre = $promedioSer + $promedioSaber + $promedioHacer + $promedioDecidir + $notas->autoevaluacion;

            $html .= '<tr>';
            $html .= '    <td>' . $count . '</td>';
            $html .= '    <td style="width:200px;text-align:left;" >' . ucfirst(strtolower($row->nombreAlumno)) . '</td>';

            $html .= '    <td class="ser" style="display:none;text-align:center;"> <input type="number" style="text-align:center; width:60px;" value="' . $notas->calificacion1Ser . '" class="form-control notaSer" id="txtSer_1_' . $row->codMateria . '_' . $row->codCursoAlumno . '" onchange=\'registrarNota(' . $row->codCursoAlumno . ',' . $row->codMateria . ',"Ser",1)\'></td>';
            $html .= '    <td class="ser" style="display:none;text-align:center;"> <input type="number" style="text-align:center; width:60px;" value="' . $notas->calificacion2Ser . '" class="form-control notaSer" id="txtSer_2_' . $row->codMateria . '_' . $row->codCursoAlumno . '" onchange=\'registrarNota(' . $row->codCursoAlumno . ',' . $row->codMateria . ',"Ser",2)\'></td>';
            $html .= '    <td class="ser" style="display:none;text-align:center;"> <input type="number" style="text-align:center; width:60px;" value="' . $notas->calificacion3Ser . '" class="form-control notaSer" id="txtSer_3_' . $row->codMateria . '_' . $row->codCursoAlumno . '" onchange=\'registrarNota(' . $row->codCursoAlumno . ',' . $row->codMateria . ',"Ser",3)\'></td>';
            $html .= '    <td style=" background-color: #d6d6d6ff;text-align:center;"> <input type="text" style="text-align:center;" class="form-control-plaintext promedio promedioSer" value="' . $promedioSer . '" readonly></td>';

            $html .= '    <td class="saber" style="display:none;text-align:center;"> <input type="number" style="text-align:center; width:60px;" value="' . $notas->calificacion1Saber . '" class="form-control notaSaber" id="txtSaber_1_' . $row->codMateria . '_' . $row->codCursoAlumno . '" onchange=\'registrarNota(' . $row->codCursoAlumno . ',' . $row->codMateria . ',"Saber",1)\'></td>';
            $html .= '    <td class="saber" style="display:none;text-align:center;"> <input type="number" style="text-align:center; width:60px;" value="' . $notas->calificacion2Saber . '" class="form-control notaSaber" id="txtSaber_2_' . $row->codMateria . '_' . $row->codCursoAlumno . '" onchange=\'registrarNota(' . $row->codCursoAlumno . ',' . $row->codMateria . ',"Saber",2)\'></td>';
            $html .= '    <td class="saber" style="display:none;text-align:center;"> <input type="number" style="text-align:center; width:60px;" value="' . $notas->calificacion3Saber . '" class="form-control notaSaber" id="txtSaber_3_' . $row->codMateria . '_' . $row->codCursoAlumno . '" onchange=\'registrarNota(' . $row->codCursoAlumno . ',' . $row->codMateria . ',"Saber",3)\'></td>';
            $html .= '    <td class="saber" style="display:none;text-align:center;"> <input type="number" style="text-align:center; width:60px;" value="' . $notas->calificacion4Saber . '" class="form-control notaSaber" id="txtSaber_4_' . $row->codMateria . '_' . $row->codCursoAlumno . '" onchange=\'registrarNota(' . $row->codCursoAlumno . ',' . $row->codMateria . ',"Saber",4)\'></td>';
            $html .= '    <td class="saber" style="display:none;text-align:center;"> <input type="number" style="text-align:center; width:60px;" value="' . $notas->calificacion5Saber . '" class="form-control notaSaber" id="txtSaber_5_' . $row->codMateria . '_' . $row->codCursoAlumno . '" onchange=\'registrarNota(' . $row->codCursoAlumno . ',' . $row->codMateria . ',"Saber",5)\'></td>';
            $html .= '    <td class="saber" style="display:none;text-align:center;"> <input type="number" style="text-align:center; width:60px;" value="' . $notas->calificacion6Saber . '" class="form-control notaSaber" id="txtSaber_6_' . $row->codMateria . '_' . $row->codCursoAlumno . '" onchange=\'registrarNota(' . $row->codCursoAlumno . ',' . $row->codMateria . ',"Saber",6)\'></td>';
            $html .= '    <td style="background-color: #d6d6d6ff;text-align:center;"> <input type="text" style="text-align:center;" class="form-control-plaintext promedio promedioSaber" value="' . $promedioSaber . '" readonly></td>';

            $html .= '    <td class="hacer" style="display:none;text-align:center;"> <input type="number" style="text-align:center; width:60px;" value="' . $notas->calificacion1Hacer . '" class="form-control notaHacer" id="txtHacer_1_' . $row->codMateria . '_' . $row->codCursoAlumno . '" onchange=\'registrarNota(' . $row->codCursoAlumno . ',' . $row->codMateria . ',"Hacer",1)\'></td>';
            $html .= '    <td class="hacer" style="display:none;text-align:center;"> <input type="number" style="text-align:center; width:60px;" value="' . $notas->calificacion2Hacer . '" class="form-control notaHacer" id="txtHacer_2_' . $row->codMateria . '_' . $row->codCursoAlumno . '" onchange=\'registrarNota(' . $row->codCursoAlumno . ',' . $row->codMateria . ',"Hacer",2)\'></td>';
            $html .= '    <td class="hacer" style="display:none;text-align:center;"> <input type="number" style="text-align:center; width:60px;" value="' . $notas->calificacion3Hacer . '" class="form-control notaHacer" id="txtHacer_3_' . $row->codMateria . '_' . $row->codCursoAlumno . '" onchange=\'registrarNota(' . $row->codCursoAlumno . ',' . $row->codMateria . ',"Hacer",3)\'></td>';
            $html .= '    <td class="hacer" style="display:none;text-align:center;"> <input type="number" style="text-align:center; width:60px;" value="' . $notas->calificacion4Hacer . '" class="form-control notaHacer" id="txtHacer_4_' . $row->codMateria . '_' . $row->codCursoAlumno . '" onchange=\'registrarNota(' . $row->codCursoAlumno . ',' . $row->codMateria . ',"Hacer",4)\'></td>';
            $html .= '    <td class="hacer" style="display:none;text-align:center;"> <input type="number" style="text-align:center; width:60px;" value="' . $notas->calificacion5Hacer . '" class="form-control notaHacer" id="txtHacer_5_' . $row->codMateria . '_' . $row->codCursoAlumno . '" onchange=\'registrarNota(' . $row->codCursoAlumno . ',' . $row->codMateria . ',"Hacer",5)\'></td>';
            $html .= '    <td class="hacer" style="display:none;text-align:center;"> <input type="number" style="text-align:center; width:60px;" value="' . $notas->calificacion6Hacer . '" class="form-control notaHacer" id="txtHacer_6_' . $row->codMateria . '_' . $row->codCursoAlumno . '" onchange=\'registrarNota(' . $row->codCursoAlumno . ',' . $row->codMateria . ',"Hacer",6)\'></td>';
            $html .= '    <td style="background-color: #d6d6d6ff;text-align:center;"><input type="text" style="text-align:center;" class="form-control-plaintext promedio promedioHacer" value="' . $promedioHacer . '" readonly></td>';

            // $html .='    <td class="decidir" style="display:none;text-align:center;"> <input type="number" style="text-align:center; width:60px;" value="'.$notas->calificacion1Decidir.'" class="form-control notaDecidir" id="txtDecidir_1_'.$row->codMateria.'_'.$row->codCursoAlumno.'" onchange=\'registrarNota('.$row->codCursoAlumno.','.$row->codMateria.',"Decidir",1)\'></td>';
            // $html .='    <td class="decidir" style="display:none;text-align:center;"> <input type="number" style="text-align:center; width:60px;" value="'.$notas->calificacion2Decidir.'" class="form-control notaDecidir" id="txtDecidir_2_'.$row->codMateria.'_'.$row->codCursoAlumno.'" onchange=\'registrarNota('.$row->codCursoAlumno.','.$row->codMateria.',"Decidir",2)\'></td>';
            // $html .='    <td class="decidir" style="display:none;text-align:center;"> <input type="number" style="text-align:center; width:60px;" value="'.$notas->calificacion3Decidir.'" class="form-control notaDecidir" id="txtDecidir_3_'.$row->codMateria.'_'.$row->codCursoAlumno.'" onchange=\'registrarNota('.$row->codCursoAlumno.','.$row->codMateria.',"Decidir",3)\'></td>';
            // $html .='    <td style="background-color: #d6d6d6ff;text-align:center;"> <input type="text" style="text-align:center;" class="form-control-plaintext promedio promedioDecidir" value="'.$promedioDecidir.'" readonly></td>';

            $html .= '    <td style=" background-color: #ecebb7ff;text-align:center;" > <input type="number" style="text-align:center; width:60px;" value="' . $notas->autoevaluacion . '" class="form-control autoevaluacion" id="txtAutoEvaliacion_1_' . $row->codMateria . '_' . $row->codCursoAlumno . '" onchange=\'registrarNota(' . $row->codCursoAlumno . ',' . $row->codMateria . ',"AutoEvaliacion",1)\'></td>';
            $html .= '    <td style=" background-color: #c2d7f7ff;text-align:center;"><input type="text" style="text-align:center;" class="form-control-plaintext totalTrimestral" value="' . $promedioTrimestre . '" readonly></td>';

            $html .= '</td></tr>';

        }

    }
    $html .= ' </tbody></table>  ';

    echo $html;


}

if ($operacion == "registrarNota") {


    $codCursoAlumno = @$_POST["codCursoAlumno"];
    $codMateria = @$_POST["codMateria"];
    $valor = @$_POST["valor"];
    $tipo = @$_POST["tipo"];
    $posicion = @$_POST["posicion"];
    $trimestre = @$_POST["trimestre"];
    $gestion = @$_POST["gestion"];

    $res = $iregistro->registrarNota($codCursoAlumno, $codMateria, $valor, $tipo, $posicion, $trimestre, $gestion);

    echo json_encode($res);

}

if ($operacion == "traerAlumnosHabilitados") {


    $codCurso = @$_POST["codCurso"];

    echo $iparametro->DropDownCursoAlumno($codCurso);

}


if ($operacion == "traerMateriasHabilitadas") {

    $codProfesor = @$_POST["codProfesor"];
    $codCurso = @$_POST["codCurso"];
    $origen = @$_POST["origen"];
    $codTipoUsuario = @$_POST["codTipoUsuario"];

    echo $iparametro->DropDownMateriasHabilitados($codProfesor, $codCurso, $origen, $codTipoUsuario);

}

if ($operacion == "traerCursosHabilitadosNotas") {

    $codProfesor = @$_POST["codProfesor"];
    echo $iparametro->DropDownCursosHabilitadosNotas($codProfesor);

}

if ($operacion == "traerCursosHabilitados") {

    $codProfesor = @$_POST["codProfesor"];
    echo $iparametro->DropDownCursosHabilitados($codProfesor);

}

if ($operacion == "ActivarCursoMateria") {

    $codigo = @$_POST["codigo"];
    $res = $iregistro->ActivarCursoMateria($codigo);

    echo json_encode($res);
}

if ($operacion == "eliminarCursoMateria") {

    $codigo = @$_POST["codigo"];
    $res = $iregistro->eliminarCursoMateria($codigo);

    echo json_encode($res);
}


if ($operacion == "ActivarCursoTutor") {

    $codigo = @$_POST["codigo"];
    $res = $iregistro->ActivarCursoTutor($codigo);

    echo json_encode($res);
}

if ($operacion == "eliminarCursoTutor") {

    $codigo = @$_POST["codigo"];
    $res = $iregistro->eliminarCursoTutor($codigo);

    echo json_encode($res);
}

if ($operacion == "crearCursoTutor") {


    $codProfesor = @$_POST["codProfesor"];
    $CodGrado = @$_POST["CodGrado"];


    $res = $iregistro->crearCursoTutor($codProfesor, $CodGrado);

    echo json_encode($res);

}

if ($operacion == "traerCursoTutor") {


    $codProfesor = @$_POST["codProfesor"];


    $res = $iregistro->traerCursoTutor($codProfesor);

    $html = "";
    $html .= ' <table class="table table-striped table-hover table-bordered" id="tablaCurso">';
    $html .= '<thead>';
    $html .= '  <tr>';
    $html .= '    <th scope="col">#</th>';

    $html .= '    <th scope="col">Grado</th>';

    $html .= '    <th scope="col">Estado</th>';
    $html .= '    <th scope="col">Accion</th>';
    $html .= '  </tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    if ($res->RowCount() > 0) {
        $res->MoveFirst();

        $count = 0;
        while (!$res->EndOfSeek()) {

            $count++;
            $row = $res->Row();

            $curso = $row->grado . " - " . $row->nivel;
            $html .= '<tr>';
            $html .= '    <td>' . $count . '</td>';
            $html .= '    <td>' . ucfirst(strtolower($row->grado)) . ' - ' . ucfirst(strtolower($row->nivel)) . '</td>';
            if ($row->baja == 0) {
                $html .= '    <td> <span class="badge bg-success rounded-pill">Activo</span></td>';
            } else {
                $html .= '    <td> <span class="badge bg-danger rounded-pill">Eliminada</span></td>';
            }
            $html .= '<td> ';
            if ($row->baja == 0) {
                $html .= '&nbsp;<button class="btn btn-danger btn-sm"
            title="Eliminar Curso"
            type="button"
            onclick=\'eliminarDatoCurso('
                    . $row->id . ' ,'
                    . json_encode($curso) . ' )\'>
            <i class="bi bi-trash"></i>
            </button>';

            } else {
                $html .= '&nbsp;<button class="btn btn-primary btn-sm"
                title="Activar Curso"
                type="button"
                onclick=\'ActivarDatoCurso('
                    . $row->id . ' ,'
                    . json_encode($curso) . ' )\'>
                <i class="bi bi-check"></i>
                </button>';
            }
            $html .= '</td></tr>';

        }

    }
    $html .= ' </tbody></table>';

    echo $html;


}


if ($operacion == "crearCursoMateria") {


    $codProfesor = @$_POST["codProfesor"];
    $CodGrado = @$_POST["CodGrado"];
    $CodMateria = @$_POST["CodMateria"];
    $gestion = @$_POST["gestion"];

    $res = $iregistro->crearCursoMateria($codProfesor, $CodGrado, $CodMateria, $gestion);

    echo json_encode($res);

}

if ($operacion == "traerMateriasProfesor") {


    $codProfesor = @$_POST["codProfesor"];


    $res = $iregistro->traerMateriasProfesor($codProfesor);

    $html = "";
    $html .= ' <table class="table table-striped table-hover table-bordered" id="tablaMaterias">';
    $html .= '<thead>';
    $html .= '  <tr>';
    $html .= '    <th scope="col">#</th>';
    $html .= '    <th scope="col">Materia</th>';
    $html .= '    <th scope="col">Grado</th>';
    $html .= '    <th scope="col">Gestión</th>';
    $html .= '    <th scope="col">Estado</th>';
    $html .= '    <th scope="col">Accion</th>';
    $html .= '  </tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    if ($res->RowCount() > 0) {
        $res->MoveFirst();

        $count = 0;
        while (!$res->EndOfSeek()) {

            $count++;
            $row = $res->Row();

            $curso = $row->grado . " - " . $row->nivel;
            $html .= '<tr>';
            $html .= '    <td>' . $count . '</td>';
            $html .= '    <td>' . ucfirst(strtolower($row->materia)) . '</td>';
            $html .= '    <td>' . ucfirst(strtolower($row->grado)) . ' - ' . ucfirst(strtolower($row->nivel)) . '</td>';
            $html .= '    <td>' . ucfirst(strtolower($row->gestion)) . '</td>';
            if ($row->baja == 0) {
                $html .= '    <td> <span class="badge bg-success rounded-pill">Activo</span></td>';
            } else {
                $html .= '    <td> <span class="badge bg-danger rounded-pill">Eliminada</span></td>';
            }
            $html .= '<td> ';
            if ($row->baja == 0) {
                $html .= '&nbsp;<button class="btn btn-danger btn-sm"
            title="Eliminar Materia"
            type="button"
            onclick=\'eliminarDatoMateria('
                    . $row->id . ','
                    . json_encode($row->materia) . ','
                    . json_encode($curso) . ' )\'>
            <i class="bi bi-trash"></i>
            </button>';

            } else {
                $html .= '&nbsp;<button class="btn btn-primary btn-sm"
                title="Activar Materia"
                type="button"
                onclick=\'ActivarDatoMateria('
                    . $row->id . ','
                    . json_encode($row->materia) . ','
                    . json_encode($curso) . ' )\'>
                <i class="bi bi-check"></i>
                </button>';
            }
            $html .= '</td></tr>';

        }

    }
    $html .= ' </tbody></table>';

    echo $html;


}


if ($operacion == "ActivarProfesor") {

    $codigo = @$_POST["codigo"];
    $res = $iregistro->ActivarProfesor($codigo);

    echo json_encode($res);
}

if ($operacion == "eliminarProfesor") {

    $codigo = @$_POST["codigo"];
    $res = $iregistro->eliminarProfesor($codigo);

    echo json_encode($res);
}


if ($operacion == "editarProfesor") {

    $codigo = @$_POST["codigo"];

    $nombres = @$_POST["nombres"];

    $res = $iregistro->editarProfesor($codigo, $nombres);

    echo json_encode($res);

}

if ($operacion == "crearProfesor") {


    $nombre = @$_POST["nombre"];

    $res = $iregistro->crearProfesor($nombre);

    echo json_encode($res);

}


if ($operacion == "traerProfesor") {


    $codCurso = @$_POST["codCurso"];


    $res = $iregistro->traerProfesor($codCurso);

    $html = "";
    $html .= ' <table class="table table-striped table-hover table-bordered" id="tablaHistorico">';
    $html .= '<thead>';
    $html .= '  <tr>';
    $html .= '    <th scope="col">#</th>';

    $html .= '    <th scope="col">Nombre Profesor</th>';
    $html .= '    <th scope="col">Asignación</th>';
    $html .= '    <th scope="col">Estado</th>';
    $html .= '    <th scope="col">Accion</th>';
    $html .= '  </tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    if ($res->RowCount() > 0) {
        $res->MoveFirst();

        $count = 0;
        while (!$res->EndOfSeek()) {

            $count++;
            $row = $res->Row();
            $nombreCompleto = $row->apellidos . " " . $row->nombres;
            //  $cantidadCompras  = 0;
            $html .= '<tr>';
            $html .= '    <td>' . $count . '</td>';
            $html .= '    <td>' . ucfirst(strtolower($row->nombre)) . '</td>';
            $html .= '    <td>' . ucfirst(strtolower($row->tipoUsuario)) . '</td>';
            if ($row->baja == 0) {
                $html .= '    <td> <span class="badge bg-success rounded-pill">Activo</span></td>';
            } else {
                $html .= '    <td> <span class="badge bg-danger rounded-pill">Eliminada</span></td>';
            }
            $html .= '<td> ';
            if ($row->baja == 0) {
                $html .= '&nbsp;<button class="btn btn-danger btn-sm"
                title="Eliminar Profesor"
                type="button"
                onclick=\'eliminarDato('
                    . $row->id . ','
                    . json_encode($row->nombre) . ' )\'>
                <i class="bi bi-trash"></i>
                </button>';
                $html .= '&nbsp;<button class="btn btn-warning btn-sm"
                title="Editar Profesor"
                type="button"
                onclick=\'editarDatos('
                    . json_encode($row->id) . ','
                    . json_encode($row->nombre) . ')\'>
                <i class="bi bi-pencil"></i>
                </button>';
                $html .= '&nbsp;<button class="btn btn-secondary btn-sm"
                    title="Agregar Materia"
                    type="button"
                    onclick=\'verMateria('
                    . json_encode($row->id) . ','
                    . json_encode($row->nombre) . ')\'>
                    <i class="bi bi-book"></i>
                </button>';

                if ($row->codTipoUsuario == 4) {
                    $html .= '&nbsp;<button class="btn btn-primary btn-sm"
                        title="Agregar Curso"
                        type="button"
                        onclick=\'verCurso('
                        . json_encode($row->id) . ','
                        . json_encode($row->nombre) . ')\'>
                        <i class="bi bi-people"></i>
                    </button>';
                }
            } else {
                $html .= '&nbsp;<button class="btn btn-primary btn-sm"
                title="Activar Profesor"
                type="button"
                onclick=\'ActivarDato('
                    . $row->id . ','
                    . json_encode($row->nombre) . ' )\'>
                <i class="bi bi-check"></i>
                </button>';
            }
            $html .= '</td></tr>';

        }

    }
    $html .= ' </tbody></table>';

    echo $html;


}


if ($operacion == "ActivarAlumno") {

    $codigo = @$_POST["codigo"];
    $res = $iregistro->ActivarAlumno($codigo);

    echo json_encode($res);
}

if ($operacion == "eliminarAlumno") {

    $codigo = @$_POST["codigo"];
    $res = $iregistro->eliminarAlumno($codigo);

    echo json_encode($res);
}


if ($operacion == "editarAlumno") {

    $codigo = @$_POST["codigo"];
    $codProfesor = @$_POST["codProfesor"];
    $codCurso = @$_POST["codCurso"];
    $nombres = @$_POST["nombres"];
    $apellidos = @$_POST["apellidos"];
    $rude = @$_POST["rude"];
    $gestion = @$_POST["gestion"];
    $res = $iregistro->editarAlumno($codigo, $codCurso, $nombres, $apellidos, $codProfesor, $rude, $gestion);

    echo json_encode($res);

}

if ($operacion == "crearAlumno") {

    $codGrado = @$_POST["codGrado"];
    $codProfesor = @$_POST["codProfesor"];
    $nombre = @$_POST["nombre"];
    $apellido = @$_POST["apellido"];
    $rude = @$_POST["rude"];
    $gestion = @$_POST["gestion"];
    $res = $iregistro->crearAlumno($codGrado, $nombre, $apellido, $codProfesor, $rude, $gestion);

    echo json_encode($res);

}


if ($operacion == "traerAlumnos") {


    $codCurso = @$_POST["codCurso"];
    $estado = @$_POST["estado"];
    $gestion = @$_POST["gestion"];

    $res = $iregistro->traerAlumnos($codCurso, $estado, $gestion);

    $html = "";
    $html .= ' <div class="table-responsive">';
    $html .= ' <table class="table datatable table-striped table-hover table-bordered" id="tablaHistorico">';
    $html .= '<thead>';
    $html .= '  <tr>';
    $html .= '    <th scope="col">#</th>';

    $html .= '    <th scope="col">Grado</th>';

    $html .= '    <th scope="col">Nombre Alumno</th>';
    $html .= '    <th scope="col">Promedio Anual</th>';
    $html .= '    <th scope="col">Código Rude</th>';
    $html .= '    <th scope="col">Gestión</th>';
    $html .= '    <th scope="col">Estado</th>';
    $html .= '    <th scope="col">Accion</th>';
    $html .= '  </tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    if ($res->RowCount() > 0) {
        $res->MoveFirst();

        $count = 0;
        while (!$res->EndOfSeek()) {

            $count++;
            $row = $res->Row();
            $nombreCompleto = $row->apellidos . " " . $row->nombres;
            //  $cantidadCompras  = 0;
            $notaAlumno = $iregistro->traerNotasXAlumnos($row->id, $row->gestion);

            $html .= '<tr>';
            $html .= '    <td>' . $count . '</td>';
            //   $html .='    <td>'.ucfirst(strtolower($row->profesor)).'</td>';
            $html .= '    <td>' . ucfirst(strtolower($row->curso)) . ' - ' . ucfirst(strtolower($row->nivel)) . '</td>';

            $html .= '    <td>' . ucfirst(strtolower($row->apellidos)) . ' ' . ucfirst(strtolower($row->nombres)) . '</td>';
            $html .= '    <td style="text-align:center;">' . number_format($notaAlumno, 0) . '</td>';
            $html .= '    <td>' . $row->rude . '</td>';
            $html .= '    <td>' . $row->gestion . '</td>';


            if ($row->baja == 0) {
                $html .= '    <td> <span class="badge bg-success rounded-pill">Activo</span></td>';
            } else {
                $html .= '    <td> <span class="badge bg-danger rounded-pill">Eliminada</span></td>';
            }
            $html .= '<td> ';
            if ($row->baja == 0) {
                $html .= '&nbsp;<button class="btn btn-warning btn-sm"
            title="Editar Alumno"
            type="button"
            onclick=\'editarDatos('
                    . json_encode($row->id) . ','
                    . json_encode($row->codCurso) . ','
                    . json_encode($row->codProfesor) . ','
                    . json_encode($row->nombres) . ','
                    . json_encode($row->apellidos) . ','
                    . json_encode($row->rude) . ','
                    . json_encode($row->gestion) . ' )\'>
            <i class="bi bi-pencil"></i>
          </button>';
                $html .= '&nbsp;<button class="btn btn-danger btn-sm"
            title="Eliminar Alumno"
            type="button"
            onclick=\'eliminarDato('
                    . $row->id . ','
                    . json_encode($nombreCompleto) . ' )\'>
            <i class="bi bi-trash"></i>
            </button>';

            } else {
                $html .= '&nbsp;<button class="btn btn-primary btn-sm"
                title="Activar Alumno"
                type="button"
                onclick=\'ActivarDato('
                    . $row->id . ','
                    . json_encode($nombreCompleto) . ' )\'>
                <i class="bi bi-check"></i>
                </button>';
            }
            $html .= '</td></tr>';

        }

    }
    $html .= ' </tbody></table>';

    echo $html;


}


if ($operacion == "traerMateria") {


    $nombre = @$_POST["nombre"];


    $res = $iregistro->traerMateria($nombre);

    $html = "";
    $html .= ' <div class="table-responsive">';
    $html .= ' <table class="table datatable table-striped table-hover table-bordered" id="tablaHistorico">';
    $html .= '<thead>';
    $html .= '  <tr>';
    $html .= '    <th scope="col">#</th>';
    $html .= '    <th scope="col">Nombre Materia</th>';
    $html .= '    <th scope="col">Areas Curriculares</th>';
    $html .= '    <th scope="col">Saberes y Conocimientos</th>';
    $html .= '    <th scope="col">Estado</th>';
    $html .= '    <th scope="col">Accion</th>';
    $html .= '  </tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    if ($res->RowCount() > 0) {
        $res->MoveFirst();

        $count = 0;
        while (!$res->EndOfSeek()) {

            $count++;
            $row = $res->Row();

            //  $cantidadCompras  = 0;
            $html .= '<tr>';
            $html .= '    <td>' . $count . '</td>';
            $html .= '    <td>' . ucfirst(strtolower($row->nombre)) . '</td>';
            $html .= '    <td>' . $row->areasCurriculares . '</td>';
            $html .= '    <td>' . $row->saberesConocimiento . '</td>';


            if ($row->baja == 0) {
                $html .= '    <td> <span class="badge bg-success rounded-pill">Activo</span></td>';
            } else {
                $html .= '    <td> <span class="badge bg-danger rounded-pill">Eliminada</span></td>';
            }
            $html .= '<td> ';
            if ($row->baja == 0) {
                $html .= '&nbsp;<button class="btn btn-danger btn-sm"
            title="Eliminar Materia"
            type="button"
            onclick=\'eliminarDato('
                    . $row->id . ','
                    . json_encode($row->nombre) . ' )\'>
            <i class="bi bi-trash"></i>
            </button>';
                $html .= '&nbsp;<button class="btn btn-warning btn-sm"
            title="Editar Materia"
            type="button"
            onclick=\'editarDatos('
                    . json_encode($row->id) . ','
                    . json_encode($row->nombre) . ','
                    . json_encode($row->areasCurriculares) . ','
                    . json_encode($row->saberesConocimiento) . ')\'>
            <i class="bi bi-pencil"></i>
          </button>';
                $html .= '&nbsp;<button class="btn btn-info btn-sm"
            title="Ver Asignaciones"
            type="button"
            onclick=\'verAsignaciones('
                    . $row->id . ','
                    . json_encode($row->nombre) . ')\'>
            <i class="bi bi-person-lines-fill"></i>
          </button>';
            } else {
                $html .= '&nbsp;<button class="btn btn-primary btn-sm"
                title="Activar Materia"
                type="button"
                onclick=\'ActivarDato('
                    . $row->id . ','
                    . json_encode($row->nombres) . ' )\'>
                <i class="bi bi-check"></i>
                </button>';
            }
            $html .= '</td></tr>';

        }

    }
    $html .= ' </tbody></table>';

    echo $html;


}

if ($operacion == "traerAsignacionesMateria") {
    $codMateria = @$_POST["codMateria"];
    $res = $iregistro->traerAsignacionesMateria($codMateria);

    $html = "";
    $html .= ' <div class="table-responsive">';
    $html .= ' <table class="table table-striped table-hover table-bordered">';
    $html .= '<thead>';
    $html .= '  <tr>';
    $html .= '    <th scope="col">#</th>';
    $html .= '    <th scope="col">Profesor</th>';
    $html .= '    <th scope="col">Curso</th>';
    $html .= '    <th scope="col">Gestión</th>';
    $html .= '  </tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    if ($res && $res->RowCount() > 0) {
        $res->MoveFirst();
        $count = 0;
        while (!$res->EndOfSeek()) {
            $count++;
            $row = $res->Row();
            $html .= '<tr>';
            $html .= '    <td>' . $count . '</td>';
            $html .= '    <td>' . $row->profesor . '</td>';
            $html .= '    <td>' . $row->grado . ' - ' . $row->nivel . '</td>';
            $html .= '    <td>' . $row->gestion . '</td>';
            $html .= '</tr>';
        }
    } else {
        $html .= '<tr><td colspan="4" class="text-center">No hay asignaciones registradas para esta materia.</td></tr>';
    }
    $html .= ' </tbody></table>';

    echo $html;
}

if ($operacion == "crearMateria") {

    $nombre = @$_POST["nombre"];
    $area = @$_POST["area"];
    $saberes = @$_POST["saberes"];

    $res = $iregistro->crearMateria($nombre, $area, $saberes);

    echo json_encode($res);

}

if ($operacion == "ActivarMateria") {

    $codMateria = @$_POST["codMateria"];
    $res = $iregistro->ActivarMateria($codMateria);

    echo json_encode($res);
}

if ($operacion == "eliminarMateria") {

    $codMateria = @$_POST["codMateria"];
    $res = $iregistro->eliminarMateria($codMateria);

    echo json_encode($res);
}

if ($operacion == "editarMateria") {

    $codigo = @$_POST["codigo"];
    $nombre = @$_POST["nombre"];
    $area = @$_POST["area"];
    $saberes = @$_POST["saberes"];

    $res = $iregistro->editarMateria($codigo, $nombre, $area, $saberes);

    echo json_encode($res);

}


if ($operacion == "traerCurso") {


    $nombre = @$_POST["nombre"];


    $res = $iregistro->traerCurso($nombre);

    $html = "";
    $html .= ' <div class="table-responsive">';
    $html .= ' <table class="table datatable table-striped table-hover table-bordered" id="tablaHistorico">';
    $html .= '<thead>';
    $html .= '  <tr>';
    $html .= '    <th scope="col">#</th>';
    $html .= '    <th scope="col">Grado</th>';
    $html .= '    <th scope="col">Nivel</th>';
    $html .= '    <th scope="col">Estado</th>';
    $html .= '    <th scope="col">Accion</th>';
    $html .= '  </tr>';
    $html .= '</thead>';
    $html .= '<tbody>';

    if ($res->RowCount() > 0) {
        $res->MoveFirst();

        $count = 0;
        while (!$res->EndOfSeek()) {

            $count++;
            $row = $res->Row();

            //  $cantidadCompras  = 0;
            $html .= '<tr>';
            $html .= '    <td>' . $count . '</td>';
            $html .= '    <td>' . ucfirst(strtolower($row->grado)) . '</td>';
            $html .= '    <td>' . ucfirst(strtolower($row->nivel)) . '</td>';

            if ($row->baja == 0) {
                $html .= '    <td> <span class="badge bg-success rounded-pill">Activo</span></td>';
            } else {
                $html .= '    <td> <span class="badge bg-danger rounded-pill">Eliminada</span></td>';
            }

            $html .= '<td>';
            if ($row->baja == 0) {
                $html .= '&nbsp;<button class="btn btn-danger btn-sm"
                    title="Eliminar Curso"
                    type="button"
                    onclick=\'eliminarDato('
                    . $row->id . ','
                    . json_encode($row->grado) . ','
                    . json_encode($row->nivel) . ')\'>
                    <i class="bi bi-trash"></i>
                    </button>';
                $html .= '&nbsp;<button class="btn btn-warning btn-sm"
                    title="Editar Curso"
                    type="button"
                    onclick=\'editarDatos('
                    . json_encode($row->id) . ','
                    . json_encode($row->grado) . ','
                    . json_encode($row->nivel) . ')\'>
                    <i class="bi bi-pencil"></i>
                </button>';
            } else {
                $html .= '&nbsp;<button class="btn btn-primary btn-sm"
                    title="Activar Curso"
                    type="button"
                    onclick=\'ActivarDato('
                    . $row->id . ','
                    . json_encode($row->grado) . ','
                    . json_encode($row->nivel) . ')\'>
                    <i class="bi bi-check"></i>
                    </button>';
            }


            // $html .='&nbsp; <button class="btn btn-primary btn-sm" title="Ver Historial Salidas" type="button" onclick="verDetalleSalidas('.$row->codProducto.')"><i class="bi bi-search"></i></button>';
            $html .= '</td></tr>';

        }

    }
    $html .= ' </tbody></table>';

    echo $html;


}

if ($operacion == "AcivarCurso") {

    $codCurso = @$_POST["codCurso"];
    $res = $iregistro->AcivarCurso($codCurso);

    echo json_encode($res);
}

if ($operacion == "eliminarCurso") {

    $codCurso = @$_POST["codCurso"];
    $res = $iregistro->eliminarCurso($codCurso);

    echo json_encode($res);
}

if ($operacion == "editarCurso") {

    $codigo = @$_POST["codigo"];
    $grado = @$_POST["grado"];
    $nivel = @$_POST["nivel"];

    $res = $iregistro->editarCurso($codigo, $grado, $nivel);

    echo json_encode($res);

}

if ($operacion == "crearCurso") {

    $grado = @$_POST["grado"];
    $nivel = @$_POST["nivel"];

    $res = $iregistro->crearCurso($grado, $nivel);

    echo json_encode($res);

}



if ($operacion == "cargarRespaldo") {

    if (isset($_FILES['uFile'])) {
        $archivo = $_FILES['uFile'];
        $codCompra = $_POST['codCompra'];
        // Carpeta destino
        $carpeta = "imagenes/respaldos/";
        $info = pathinfo($archivo["name"]);

        $nombreOriginal = $info['filename']; // sin extensión
        $extension = $info['extension']; // la extensión
        // Si no existe la carpeta la creamos
        if (!file_exists($carpeta)) {
            mkdir($carpeta, 0777, true);
        }

        // Nombre único para evitar sobreescribir
        $nombreUnico = uniqid() . "." . $extension;
        $rutaDestino = $carpeta . $nombreUnico;

        if (move_uploaded_file($archivo["tmp_name"], $rutaDestino)) {
            chmod($rutaDestino, 0777);
            // $iregistro->guardarRespaldoCompra($codCompra,$nombreUnico);
            echo 'ok';
        } else {
            echo "Error";
        }
    } else {
        echo "Error";
    }

}


if ($operacion == "iniciarSesion") {

    $user = @$_POST["user"];
    $contra = @$_POST["contra"];
    $res = $iregistro->iniciarSesion($user, $contra);

    echo $res;
}



if ($operacion == "modificarContrasenha") {


    $actual = @$_POST["actual"];
    $nueva = @$_POST["nueva"];
    $repeticion = @$_POST["repeticion"];
    $codUsuario = @$_POST["codUsuario"];

    $res = $iregistro->modificarContrasenha($actual, $nueva, $repeticion, $codUsuario);

    echo json_encode($res);

}

// ----------------- MODULO FINANZAS ----------------- //

if ($operacion == 'crearIngreso') {
    $codAlumno = $_POST['codAlumno'] ?? 0;
    $monto = $_POST['monto'];
    $fechaPago = $_POST['fechaPago'];
    $mes = $_POST['mes'];
    $gestion = $_POST['gestion'];
    $concepto = $_POST['concepto'];
    $res = $iregistro->crearIngreso($codAlumno, $monto, $fechaPago, $mes, $gestion, $concepto);
    echo json_encode($res);
}

if ($operacion == 'traerIngresos') {
    $gestion = $_POST['gestion'];
    $mes = $_POST['mes'] ?? 0; // 0 = Todos
    $res = $iregistro->traerIngresos($gestion, $mes);

    $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    $html = '<table class="table table-bordered table-striped" id="tablaHistorico">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>#</th><th>Alumno</th><th>Concepto</th><th>Fecha</th><th>Mes</th><th>Gestión</th><th>Monto</th><th>Acción</th>
                    </tr>
                </thead><tbody>';
    $total = 0;
    if ($res) {
        foreach ($res as $row) {
            $total += $row['monto'];
            $num_mes = $row['mes'];
            $mesStr = isset($meses[$num_mes]) ? $meses[$num_mes] : $num_mes;
            $html .= "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['nombreAlumno']}</td>
                        <td>{$row['concepto']}</td>
                        <td>{$row['fechaPago']}</td>
                        <td>{$mesStr}</td>
                        <td>{$row['gestion']}</td>
                        <td>Bs. " . number_format($row['monto'], 2) . "</td>
                        <td><button class='btn btn-danger btn-sm' onclick='eliminarIngreso({$row['id']})'><i class='bi bi-trash'></i></button></td>
                      </tr>";
        }
    }
    $html .= '</tbody><tfoot><tr><th colspan="6" style="text-align:right">TOTAL:</th><th>Bs. ' . number_format($total, 2) . '</th><th></th></tr></tfoot></table>';
    echo $html;
}

if ($operacion == 'eliminarIngreso') {
    $id = $_POST['id'];
    $res = $iregistro->eliminarIngreso($id);
    echo json_encode($res);
}

if ($operacion == 'crearEgreso') {
    $monto = $_POST['monto'];
    $fechaEgreso = $_POST['fechaEgreso'];
    $mes = $_POST['mes'];
    $gestion = $_POST['gestion'];
    $concepto = $_POST['concepto'];
    $res = $iregistro->crearEgreso($monto, $fechaEgreso, $mes, $gestion, $concepto);
    echo json_encode($res);
}

if ($operacion == 'traerEgresos') {
    $gestion = $_POST['gestion'];
    $mes = $_POST['mes'] ?? 0;
    $res = $iregistro->traerEgresos($gestion, $mes);

    $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    $html = '<table class="table table-bordered table-striped" id="tablaHistorico">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>ID</th><th>Concepto</th><th>Fecha Registro</th><th>Mes</th><th>Gestión</th><th>Monto</th><th>Acción</th>
                    </tr>
                </thead><tbody>';
    $total = 0;
    if ($res) {
        foreach ($res as $row) {
            $total += $row['monto'];
            $mes = $row['mes'];
            $html .= "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['concepto']}</td>
                        <td>{$row['fechaEgreso']}</td>
                        <td>{$meses[$mes]}</td>
                        <td>{$row['gestion']}</td>
                        <td>Bs. " . number_format($row['monto'], 2) . "</td>
                        <td><button class='btn btn-danger btn-sm' onclick='eliminarEgreso({$row['id']})'><i class='bi bi-trash'></i></button></td>
                      </tr>";
        }
    }
    $html .= '</tbody><tfoot><tr><th colspan="5" style="text-align:right">TOTAL:</th><th>Bs. ' . number_format($total, 2) . '</th><th></th></tr></tfoot></table>';
    echo $html;
}

if ($operacion == 'eliminarEgreso') {
    $id = $_POST['id'];
    $res = $iregistro->eliminarEgreso($id);
    echo json_encode($res);
}

if ($operacion == 'balanceGeneral') {
    $gestion = $_POST['gestion'] ?? date('Y');

    $ingresosMes = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
    $egresosMes = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

    $ing = $iregistro->traerIngresos($gestion, 0);
    if ($ing)
        foreach ($ing as $r) {
            $ingresosMes[$r['mes']] += $r['monto'];
        }

    $egr = $iregistro->traerEgresos($gestion, 0);
    if ($egr)
        foreach ($egr as $r) {
            $egresosMes[$r['mes']] += $r['monto'];
        }

    $html = '<table class="table table-bordered table-striped" id="tablaHistorico">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>Mes</th><th>Total Ingresos</th><th>Total Egresos</th><th>Ganancia Líquida (Ingresos - Egresos)</th>
                    </tr>
                </thead><tbody>';
    $meses = ['', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    $t_ing = 0;
    $t_egr = 0;
    $t_liq = 0;
    for ($i = 1; $i <= 12; $i++) {
        $liq = $ingresosMes[$i] - $egresosMes[$i];
        $t_ing += $ingresosMes[$i];
        $t_egr += $egresosMes[$i];
        $t_liq += $liq;

        $color = $liq >= 0 ? 'text-success' : 'text-danger';
        $html .= "<tr>
                    <td>{$meses[$i]}</td>
                    <td class='text-primary'>Bs. " . number_format($ingresosMes[$i], 2) . "</td>
                    <td class='text-danger'>Bs. " . number_format($egresosMes[$i], 2) . "</td>
                    <td class='{$color}'><b>Bs. " . number_format($liq, 2) . "</b></td>
                  </tr>";
    }
    $c_liq = $t_liq >= 0 ? 'text-success' : 'text-danger';
    $html .= "</tbody><tfoot><tr>
                <th style='text-align:right'>TOTAL ANUAL:</th>
                <th class='text-primary'>Bs. " . number_format($t_ing, 2) . "</th>
                <th class='text-danger'>Bs. " . number_format($t_egr, 2) . "</th>
                <th class='{$c_liq}' style='font-size:18px;'>Bs. " . number_format($t_liq, 2) . "</th>
              </tr></tfoot></table>";

    echo json_encode([
        'html' => $html,
        'ingresos' => array_values(array_slice($ingresosMes, 1)),
        'egresos' => array_values(array_slice($egresosMes, 1))
    ]);
}

if ($operacion == 'traerAlumnosFiltroFinanzas') {
    $codCurso = $_POST['codCurso'];
    $gestion = $_POST['gestion'];
    $db = new MySQL();

    $cond = "ca.baja = 0 AND ca.codCurso = '$codCurso'";
    if (!empty($gestion)) {
        // Wait, cursoAlumnos mostly is joined with historico or just has `gestion`.
        $cond .= " AND ca.gestion = '$gestion'";
    }

    $db->Query("SELECT ca.id, CONCAT(ca.apellidos, ' ', ca.nombres) as nombre FROM cursoalumnos ca WHERE $cond ORDER BY ca.apellidos ASC");
    $opts = "<option value='0'>Seleccione un Estudiante</option>";
    while (!$db->EndOfSeek()) {
        $row = $db->Row();
        $opts .= "<option value='{$row->id}'>{$row->nombre}</option>";
    }
    echo $opts;
}
