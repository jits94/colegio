<?php
require_once "mysql.class.php";

class parametros
{
    private function asegurarTipoContabilidad()
    {
        $db = new MySQL();
        if ($db->Error())
            $db->Kill();

        $consultar = "SELECT codTipoUsuario FROM `tipoUsuario` WHERE codTipoUsuario = 6 LIMIT 1";
        if (!$db->Query($consultar))
            $db->Kill();

        if ($db->RowCount() == 0) {
            $insertar = "INSERT INTO `tipoUsuario`(`codTipoUsuario`, `nombre`, `baja`) VALUES (6, 'Contabilidad', 0)";
            $db->Query($insertar);
        }
    }

    public function DropDownTipoUsuario($cod = '')
    {
        $this->asegurarTipoContabilidad();

        $db = new MySQL();
        if ($db->Error())
            $db->Kill();


        $consultar = "SELECT * FROM `tipoUsuario` where baja = '0' and codTipoUsuario != 1 order by nombre asc";

        echo "<option value='0' >Seleccionar</option>";
        if (!$db->Query($consultar))
            $db->Kill();
        $db->MoveFirst();

        while (!$db->EndOfSeek()) {
            $selected = '';
            $row = $db->Row();
            if ($cod == $row->codTipoUsuario) {
                $selected = "selected";
            }

            echo "<option value='" . $row->codTipoUsuario . "' $selected>" . ucfirst(strtolower($row->nombre)) . "</option>";
        }

    }

    public function DropDownDepartamento($cod)
    {

        $db = new MySQL();
        if ($db->Error())
            $db->Kill();


        $consultar = "SELECT * FROM `departamento` where baja = '0'  order by nombre asc";

        echo "<option value='0' >Seleccionar</option>";
        if (!$db->Query($consultar))
            $db->Kill();
        $db->MoveFirst();

        while (!$db->EndOfSeek()) {
            $selected = '';
            $row = $db->Row();
            if ($cod == $row->id) {
                $selected = "selected";
            }

            echo "<option value='" . $row->id . "' $selected>" . ucfirst(strtolower($row->nombre)) . "</option>";
        }

    }

    public function DropDownCursoAlumno($codCurso)
    {

        $db = new MySQL();
        if ($db->Error())
            $db->Kill();


        $consultar = "SELECT * FROM `cursoAlumnos` where baja = '0' and codCurso=" . $db->GetSQLValue($codCurso, MySQL::SQLVALUE_NUMBER) . " order by apellidos asc";

        echo "<option value='0' >Seleccionar</option>";
        if (!$db->Query($consultar))
            $db->Kill();
        $db->MoveFirst();

        while (!$db->EndOfSeek()) {
            $selected = '';
            $row = $db->Row();


            echo "<option value='" . $row->id . "' $selected>" . ucfirst(strtolower($row->apellidos)) . "  " . ucfirst(strtolower($row->nombres)) . "</option>";
        }

    }

    public function DropDownCursos($codTipoUsuario = '', $codigousuario = '')
    {

        $db = new MySQL();
        if ($db->Error())
            $db->Kill();


        if ($codTipoUsuario == 4) { // tutor
            $condicion = " and id in (SELECT codCurso FROM `tutor` where codProfesor in (select id from profesor where codUsuario = " . $db->GetSQLValue($codigousuario, MySQL::SQLVALUE_NUMBER) . "))";
        } else {
            if ($codTipoUsuario == 2) { // profesor
                $condicion = " and id in (SELECT codCurso FROM `cursoMateria` where codProfesor in (select id from profesor where codUsuario = " . $db->GetSQLValue($codigousuario, MySQL::SQLVALUE_NUMBER) . "))";
            } else {
                echo "<option value='0' >Seleccionar</option>";
            }
        }

        $consultar = "SELECT * from curso where baja = '0' $condicion order by grado asc";


        if (!$db->Query($consultar))
            $db->Kill();
        $db->MoveFirst();

        while (!$db->EndOfSeek()) {
            $selected = '';
            $row = $db->Row();


            echo "<option value='" . $row->id . "' $selected>" . ucfirst(strtolower($row->grado)) . " - " . ucfirst(strtolower($row->nivel)) . "</option>";
        }

    }

    public function DropDownMateriaAlumno($codCurso, $gestion)
    {

        $db = new MySQL();
        if ($db->Error())
            $db->Kill();

        $consultar = "SELECT cm.codMateria,ma.nombre as materia FROM cursoMateria cm 
        LEFT join materia ma on ma.id = cm.codMateria
        where cm.codCurso = $codCurso and cm.gestion = '$gestion' and cm.baja = 0
         GROUP by cm.codMateria
         order by materia asc";

        if (!$db->Query($consultar))
            $db->Kill();

        if ($db->RowCount() > 1 || $db->RowCount() == 0) {
            echo "<option value='0' >Seleccionar</option>";
        }
        $db->MoveFirst();

        while (!$db->EndOfSeek()) {
            $selected = '';
            $row = $db->Row();


            echo "<option value='" . $row->codMateria . "' $selected>" . ucfirst(strtolower($row->materia)) . "</option>";
        }

    }

    public function DropDownMateriasHabilitados($codProfesor, $codCurso, $origen, $codTipoUsuario)
    {

        $db = new MySQL();
        if ($db->Error())
            $db->Kill();

        $condicion = ' and cm.codProfesor =' . $codProfesor;

        if ($origen == 'centralizador' && $codTipoUsuario == 4) {
            $condicion = "";
        }

        $consultar = "SELECT cm.codCurso,cu.grado,cu.nivel,cm.codMateria,ma.nombre as materia  FROM cursoMateria cm 
         LEFT join curso cu on cu.id = cm.codCurso
        LEFT join materia ma on ma.id = cm.codMateria
        where cm.codCurso=$codCurso and cm.baja =0 $condicion
         GROUP by cm.codMateria
        ";


        if (!$db->Query($consultar))
            $db->Kill();

        if ($db->RowCount() > 1 || $db->RowCount() == 0) {
            echo "<option value='0' >Seleccionar</option>";
        }
        $db->MoveFirst();

        while (!$db->EndOfSeek()) {
            $selected = '';
            $row = $db->Row();


            echo "<option value='" . $row->codMateria . "' $selected>" . ucfirst(strtolower($row->materia)) . "</option>";
        }

    }

    public function DropDownCursosHabilitadosNotas($codProfesor)
    {

        $db = new MySQL();
        if ($db->Error())
            $db->Kill();

        $consultar = "SELECT cm.codCurso,cu.grado,cu.nivel FROM cursoMateria cm 
            LEFT join curso cu on cu.id = cm.codCurso
            where cm.codProfesor = $codProfesor and cm.baja = 0
           ";

        echo "<option value='0' >Seleccionar</option>";
        if (!$db->Query($consultar))
            $db->Kill();
        $db->MoveFirst();

        while (!$db->EndOfSeek()) {
            $selected = '';
            $row = $db->Row();


            echo "<option value='" . $row->codCurso . "' $selected>" . ucfirst(strtolower($row->grado)) . " - " . ucfirst(strtolower($row->nivel)) . "</option>";
        }

    }

    public function DropDownCursosHabilitados($codProfesor)
    {

        $db = new MySQL();
        if ($db->Error())
            $db->Kill();

        $consultar = "SELECT codCurso,grado,nivel FROM (
            SELECT cm.codCurso,cu.grado,cu.nivel FROM cursoMateria cm 
            LEFT join curso cu on cu.id = cm.codCurso
            where cm.codProfesor = $codProfesor and cm.baja = 0
            UNION 
            SELECT t.codCurso,cu.grado,cu.nivel FROM tutor t
            LEFT join curso cu on cu.id = t.codCurso
            where t.codProfesor = $codProfesor and t.baja = 0
        ) as tabla
        GROUP by codCurso
        order by grado asc";

        echo "<option value='0' >Seleccionar</option>";
        if (!$db->Query($consultar))
            $db->Kill();
        $db->MoveFirst();

        while (!$db->EndOfSeek()) {
            $selected = '';
            $row = $db->Row();


            echo "<option value='" . $row->codCurso . "' $selected>" . ucfirst(strtolower($row->grado)) . " - " . ucfirst(strtolower($row->nivel)) . "</option>";
        }

    }

    public function DropDownProfesor($codTipoUsuario = '', $codUsuario = '')
    {

        $db = new MySQL();
        if ($db->Error())
            $db->Kill();

        $condicion = '';

        if ($codTipoUsuario == 4 || $codTipoUsuario == 2) {
            $condicion = " and codUsuario=$codUsuario";
        } else {
            echo "<option value='0' >Seleccionar</option>";
        }

        $consultar = "SELECT * from profesor where baja = '0' $condicion order by nombre asc";


        if (!$db->Query($consultar))
            $db->Kill();
        $db->MoveFirst();

        while (!$db->EndOfSeek()) {
            $selected = '';
            $row = $db->Row();


            echo "<option value='" . $row->id . "' $selected>" . ucfirst(strtolower($row->nombre)) . "</option>";
        }

    }

    public function DropDownMateria()
    {

        $db = new MySQL();
        if ($db->Error())
            $db->Kill();


        $consultar = "SELECT * from materia order by nombre asc";

        echo "<option value='0'>Seleccionar</option>";
        if (!$db->Query($consultar))
            $db->Kill();

        $db->MoveFirst();

        while (!$db->EndOfSeek()) {
            $selected = '';
            $row = $db->Row();


            echo "<option value='" . $row->id . "' $selected>" . $row->nombre . "</option>";
        }

    }

    public function DropDownProducto($nombre = '')
    {

        $db = new MySQL();
        if ($db->Error())
            $db->Kill();

        $condicion = "";

        if ($nombre != '') {
            $condicion = " and nombre = '$nombre'";
        }

        $consultar = "SELECT * from productos where baja= '0' $condicion order by nombre asc";

        echo "<option value='' >Seleccionar</option>";
        if (!$db->Query($consultar))
            $db->Kill();
        $db->MoveFirst();

        while (!$db->EndOfSeek()) {
            $selected = '';
            $row = $db->Row();


            echo "<option value='" . $row->nombre . "' $selected>" . $row->nombre . "</option>";
        }

    }

    public function DropDownTraerAnho()
    {

        $db = new MySQL();
        if ($db->Error())
            $db->Kill();


        $consultar = "SELECT DISTINCT year(fecha) as anho from historico  order by fecha desc";


        if (!$db->Query($consultar))
            $db->Kill();
        $db->MoveFirst();
        $anho = date('Y');
        while (!$db->EndOfSeek()) {
            $selected = '';
            $row = $db->Row();
            if ($anho == $row->anho) {
                $selected = 'selected';
            }

            echo "<option value='" . $row->anho . "' $selected>" . $row->anho . "</option>";
        }

    }


    public function DropDownTraerOrganizacion($codOrganizacion = '')
    {

        $db = new MySQL();
        if ($db->Error())
            $db->Kill();

        $condicion = '';
        // if($codOrganizacion != "" || $codOrganizacion != 0){
        //   $condicion = " and codOrganizacion = $codOrganizacion";
        //    // return;
        // }


        $consultar = "SELECT * from organizacion where 1=1 $condicion";


        if (!$db->Query($consultar))
            $db->Kill();
        $db->MoveFirst();
        //if($codOrganizacion == "" ){
        echo "<option value='0'>Seleccionar</option>";
        // return;
        //}

        while (!$db->EndOfSeek()) {
            $selected = '';
            $row = $db->Row();
            if ($codOrganizacion == $row->codOrganizacion) {
                $selected = 'selected';
            }

            echo "<option value='" . $row->codOrganizacion . "' $selected>" . $row->nombre . "</option>";
        }

    }


    public function DropDownTraerMetas($codMeta = '')
    {

        $db = new MySQL();
        if ($db->Error())
            $db->Kill();



        $consultar = "SELECT * from metas where baja = 0";


        if (!$db->Query($consultar))
            $db->Kill();
        $db->MoveFirst();
        // if($codOrganizacion == "" ){
        echo "<option value='0' selected>Seleccionar</option>";
        // return;
        //}
        // echo "<option value='0'>Seleccionar</option>";
        while (!$db->EndOfSeek()) {
            $selected = '';
            $row = $db->Row();
            if ($codMeta == $row->codMetas) {
                $selected = 'selected';
            }

            echo "<option value='" . $row->codMetas . "' $selected>" . $row->nombreMeta . "</option>";
        }

    }
    public function DropDownAlumnos()
    {
        $db = new MySQL();
        $salida = '<option value="0">Seleccione un Estudiante</option>';
        $db->Query("SELECT id, CONCAT(apellidos, ' ', nombres) as nombre FROM cursoalumnos WHERE baja=0 ORDER BY apellidos ASC");
        while (!$db->EndOfSeek()) {
            $row = $db->Row();
            $salida .= '<option value="' . $row->id . '">' . $row->nombre . '</option>';
        }
        return $salida;
    }
}
