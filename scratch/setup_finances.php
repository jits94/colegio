<?php
$base_path = 'c:\\xampp\\htdocs\\colegio\\';

// 1. UPDATE respuestaParcial.php
$rp = file_get_contents($base_path . 'respuestaParcial.php');

$endpoints = <<<'EOD'

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
    
    $html = '<table class="table table-bordered table-striped" id="tablaHistorico">
                <thead class="bg-primary text-white">
                    <tr>
                        <th>ID</th><th>Alumno</th><th>Concepto</th><th>Fecha</th><th>Mes</th><th>Gestión</th><th>Monto</th><th>Acción</th>
                    </tr>
                </thead><tbody>';
    $total = 0;
    if ($res) {
        foreach ($res as $row) {
            $total += $row['monto'];
            $mesStr = $row['mes'];
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
    $html .= '</tbody><tfoot><tr><th colspan="6" style="text-align:right">TOTAL:</th><th>Bs. '.number_format($total,2).'</th><th></th></tr></tfoot></table>';
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
    
    $html = '<table class="table table-bordered table-striped" id="tablaHistorico">
                <thead class="bg-danger text-white">
                    <tr>
                        <th>ID</th><th>Concepto</th><th>Fecha</th><th>Mes</th><th>Gestión</th><th>Monto</th><th>Acción</th>
                    </tr>
                </thead><tbody>';
    $total = 0;
    if ($res) {
        foreach ($res as $row) {
             $total += $row['monto'];
            $html .= "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['concepto']}</td>
                        <td>{$row['fechaEgreso']}</td>
                        <td>{$row['mes']}</td>
                        <td>{$row['gestion']}</td>
                        <td>Bs. " . number_format($row['monto'], 2) . "</td>
                        <td><button class='btn btn-danger btn-sm' onclick='eliminarEgreso({$row['id']})'><i class='bi bi-trash'></i></button></td>
                      </tr>";
        }
    }
    $html .= '</tbody><tfoot><tr><th colspan="5" style="text-align:right">TOTAL:</th><th>Bs. '.number_format($total,2).'</th><th></th></tr></tfoot></table>';
    echo $html;
}

if ($operacion == 'eliminarEgreso') {
    $id = $_POST['id'];
    $res = $iregistro->eliminarEgreso($id);
    echo json_encode($res);
}

if ($operacion == 'balanceGeneral') {
    $gestion = $_POST['gestion'] ?? date('Y');
    
    $ingresosMes = [0,0,0,0,0,0,0,0,0,0,0,0,0];
    $egresosMes = [0,0,0,0,0,0,0,0,0,0,0,0,0];
    
    $ing = $iregistro->traerIngresos($gestion, 0);
    if($ing) foreach($ing as $r) { $ingresosMes[$r['mes']] += $r['monto']; }
    
    $egr = $iregistro->traerEgresos($gestion, 0);
    if($egr) foreach($egr as $r) { $egresosMes[$r['mes']] += $r['monto']; }
    
    $html = '<table class="table table-bordered table-striped" id="tablaHistorico">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>Mes</th><th>Total Ingresos</th><th>Total Egresos</th><th>Ganancia Líquida (Ingresos - Egresos)</th>
                    </tr>
                </thead><tbody>';
    $meses = ['', 'Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
    
    $t_ing = 0; $t_egr = 0; $t_liq = 0;
    for ($i=1; $i<=12; $i++) {
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
                <th class='text-primary'>Bs. ".number_format($t_ing,2)."</th>
                <th class='text-danger'>Bs. ".number_format($t_egr,2)."</th>
                <th class='{$c_liq}' style='font-size:18px;'>Bs. ".number_format($t_liq,2)."</th>
              </tr></tfoot></table>";
              
    echo $html;
}

// --------------------------------------------------- //
EOD;

if (strpos($rp, 'crearIngreso') === false) {
    $rp = str_replace('?>', $endpoints . "\n?>", $rp);
    file_put_contents($base_path . 'respuestaParcial.php', $rp);
}


// 2. UPDATE clases/registro.php
$reg = file_get_contents($base_path . 'clases/registro.php');

$funcs = <<<'EOD'

    // FINANZAS
    public function crearIngreso($codAlumno, $monto, $fechaPago, $mes, $gestion, $concepto) {
        $db = new MySQL();
        $consulta = "INSERT INTO ingresos (codAlumno, monto, fechaPago, mes, gestion, concepto) VALUES ($codAlumno, $monto, '$fechaPago', $mes, $gestion, '$concepto')";
        if (!$db->Query($consulta)) { return array('request' => 'error', 'mensaje' => 'Error al registrar ingreso'); }
        return array('request' => 'ok', 'mensaje' => 'Ingreso registrado exitosamente');
    }

    public function traerIngresos($gestion, $mes) {
        $db = new MySQL();
        $cond = "";
        if ($mes > 0) $cond = " AND i.mes = $mes ";
        $c = "SELECT i.*, CONCAT(a.apellidos, ' ', a.nombres) as nombreAlumno FROM ingresos i LEFT JOIN cursoAlumnos a ON i.codAlumno = a.id WHERE i.gestion = $gestion $cond AND i.baja = 0 ORDER BY i.id DESC";
        if (!$db->Query($c)) return false;
        $res = [];
        while (!$db->EndOfSeek()) { $res[] = (array)$db->Row(); }
        return $res;
    }

    public function eliminarIngreso($id) {
        $db = new MySQL();
        if (!$db->Query("UPDATE ingresos SET baja = 1 WHERE id = $id")) { return array('request' => 'error', 'mensaje' => 'Error al eliminar'); }
        return array('request' => 'ok', 'mensaje' => 'Eliminado exitosamente');
    }

    public function crearEgreso($monto, $fechaEgreso, $mes, $gestion, $concepto) {
        $db = new MySQL();
        $consulta = "INSERT INTO egresos (monto, fechaEgreso, mes, gestion, concepto) VALUES ($monto, '$fechaEgreso', $mes, $gestion, '$concepto')";
        if (!$db->Query($consulta)) { return array('request' => 'error', 'mensaje' => 'Error al registrar egreso'); }
        return array('request' => 'ok', 'mensaje' => 'Egreso registrado exitosamente');
    }

    public function traerEgresos($gestion, $mes) {
        $db = new MySQL();
        $cond = "";
        if ($mes > 0) $cond = " AND mes = $mes ";
        $c = "SELECT * FROM egresos WHERE gestion = $gestion $cond AND baja = 0 ORDER BY id DESC";
        if (!$db->Query($c)) return false;
        $res = [];
        while (!$db->EndOfSeek()) { $res[] = (array)$db->Row(); }
        return $res;
    }

    public function eliminarEgreso($id) {
        $db = new MySQL();
        if (!$db->Query("UPDATE egresos SET baja = 1 WHERE id = $id")) { return array('request' => 'error', 'mensaje' => 'Error al eliminar'); }
        return array('request' => 'ok', 'mensaje' => 'Eliminado exitosamente');
    }

EOD;

if (strpos($reg, 'crearIngreso') === false) {
    // Insert before the last }
    $pos = strrpos($reg, '}');
    if ($pos !== false) {
        $reg = substr_replace($reg, $funcs . "\n}", $pos, 1);
        file_put_contents($base_path . 'clases/registro.php', $reg);
    }
}


// 3. PARAMETROS.PHP DROPDOWN ALUMNOS
$param = file_get_contents($base_path . 'clases/parametros.php');
$drp = <<<'EOD'
    public function DropDownAlumnos(){
        $db = new MySQL();
        $salida = '<option value="0">Seleccione un Estudiante</option>';
        $db->Query("SELECT id, CONCAT(apellidos, ' ', nombres) as nombre FROM cursoalumnos WHERE baja=0 ORDER BY apellidos ASC");
        while (!$db->EndOfSeek()) {
            $row = $db->Row();
            $salida .= '<option value="'.$row->id.'">'.$row->nombre.'</option>';
        }
        return $salida;
    }
EOD;

if (strpos($param, 'DropDownAlumnos') === false) {
    $pos = strrpos($param, '}');
    if ($pos !== false) {
        $param = substr_replace($param, $drp . "\n}", $pos, 1);
        file_put_contents($base_path . 'clases/parametros.php', $param);
    }
}

// Ensure directories exist
@mkdir($base_path . 'view/ingresos', 0777, true);
@mkdir($base_path . 'view/egresos', 0777, true);
@mkdir($base_path . 'view/balance', 0777, true);

echo "Backend Patched.\n";
