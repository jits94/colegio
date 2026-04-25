<?php
require_once "mysql.class.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class registro
{

 //$codProjecto = $db->GetLastInsertID();
      function crearUsuario($Nombre, $apellido, $usuario, $tipoUsuario, $clave = '') {
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }

        $Nombre = trim($Nombre);
        $apellido = trim($apellido);
        $usuario = trim($usuario);
        
        if (empty($clave)) {
            $clave = 'colegio' . date('Y');
        }
        $hashedClave = password_hash($clave, PASSWORD_DEFAULT);
        $consulta = "SELECT * from usuario where usuario = " . $db->GetSQLValue($usuario);
        $db->Query($consulta);
        if ($db->RowCount() > 0) {
            return array('request' => 'error', 'mensaje' => 'ya existe un usuario registrado con ese nombre de usuario');
        }

        $consulta = "INSERT INTO `persona`(`nombre`, `apellidos`, `baja`) VALUES(" . $db->GetSQLValue($Nombre) . ", " . $db->GetSQLValue($apellido) . ", 0)";
        if (!$db->Query($consulta)) {
            return array('request' => 'error', 'mensaje' => 'Error al crear persona');
        }

        $codPersona = $db->GetLastInsertID();

        $consulta = "INSERT INTO `usuario`(`usuario`, `clave`, `codTipoUsuario`, `codPersona`, `baja`) 
        VALUES(" . $db->GetSQLValue($usuario) . ", " . $db->GetSQLValue($hashedClave) . ", " . $db->GetSQLValue($tipoUsuario, MySQL::SQLVALUE_NUMBER) . ", " . $db->GetSQLValue($codPersona, MySQL::SQLVALUE_NUMBER) . ", 0)";
         
        if (!$db->Query($consulta)) {
            return array('request' => 'error', 'mensaje' => 'Error al crear usuario');
        }

        $codUsuario = $db->GetLastInsertID();

        if ($tipoUsuario == 4 || $tipoUsuario == 2) {
            $nombreCompleto = $Nombre . ' ' . $apellido;
            $consulta = "INSERT INTO `profesor`(`codUsuario`,`nombre`, `baja`) VALUES(" . $db->GetSQLValue($codUsuario, MySQL::SQLVALUE_NUMBER) . ", " . $db->GetSQLValue($nombreCompleto) . ", 0)";
            if (!$db->Query($consulta)) {
                return array('request' => 'error', 'mensaje' => 'Error al crear profesor');
            }   
        }
        
        return array('request' => 'ok', 'mensaje' => "");
    } 

      function ActivarUsuario($codigo){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }      

        $consulta = "UPDATE usuario SET baja = '0' where codUsuario = $codigo";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 
     function eliminarUsuario($codigo){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }      

        $consulta = "UPDATE usuario SET baja = '1' where codUsuario = $codigo";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 

      function editarUsuario($codigo, $nombres, $apellido, $usuario, $tipoUsuario, $clave = '') {
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }

        $nombres = trim($nombres);
        $apellido = trim($apellido);
        $usuario = trim($usuario);

        $consulta = "UPDATE `persona` set `nombre` = " . $db->GetSQLValue($nombres) . ", `apellidos` = " . $db->GetSQLValue($apellido) . " where id in (select codPersona from usuario where codUsuario = " . $db->GetSQLValue($codigo, MySQL::SQLVALUE_NUMBER) . " and baja = 0)";
        if (!$db->Query($consulta)) {
            return array('request' => 'error', 'mensaje' => 'Error al actualizar persona');
        }

        $extraUpdate = "";
        if (!empty($clave)) {
            $hashedClave = password_hash($clave, PASSWORD_DEFAULT);
            $extraUpdate = ", `clave` = " . $db->GetSQLValue($hashedClave);
        }

        $consulta = "UPDATE `usuario` SET `usuario`=" . $db->GetSQLValue($usuario) . ", `codTipoUsuario`=" . $db->GetSQLValue($tipoUsuario, MySQL::SQLVALUE_NUMBER) . " $extraUpdate where codUsuario = " . $db->GetSQLValue($codigo, MySQL::SQLVALUE_NUMBER);
        if (!$db->Query($consulta)) {
            return array('request' => 'error', 'mensaje' => 'Error al actualizar usuario');
        }

        return array('request' => 'ok', 'mensaje' => "");
    } 

    function traerUsuario(){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
            return 0;
          //  return array('request' => 'error', 'mensaje' => 'Error interno');
        }

        $condicion ='';
        // if($codCurso != ''){
        //     $condicion .= " and nombre = '$codCurso'";
        // }
       

        $consulta = "SELECT u.*,per.nombre,per.apellidos,concat(per.nombre,' ',per.apellidos) as nombreUsuario ,ti.nombre as tipoUsuario
        FROM usuario u 
        LEFT join persona per on per.id = u.codPersona 
        LEFT join tipoUsuario ti on ti.codTipoUsuario = u.codTipoUsuario
        order by per.nombre asc";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
            return 0;
           // return array('request' => 'error', 'mensaje' => $consulta);
        }
       
        return $db;               
    }


    function crearDatosColegio($codigoUnidad,$UnidadEducativa,$Distrito,$CodDepartamento,$Dependencia,$Turno){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }

         $codigoUnidad = trim($codigoUnidad);
        $UnidadEducativa = trim($UnidadEducativa);
        $Distrito = trim($Distrito);
        $Dependencia = trim($Dependencia);
        $Turno = trim($Turno);
     
        $consulta = "SELECT * from datosColegio ";
        $db->Query($consulta);
        if($db->RowCount() > 0){
            $consulta = "UPDATE `datosColegio` SET  `codigoUnidad`=" . $db->GetSQLValue($codigoUnidad) . ",`unidadEducativa`=" . $db->GetSQLValue($UnidadEducativa) . ",`distritoEducativo`=" . $db->GetSQLValue($Distrito) . ",`codDepartamento`=" . $db->GetSQLValue($CodDepartamento, MySQL::SQLVALUE_NUMBER) . ",`dependencia`=" . $db->GetSQLValue($Dependencia) . ",`turno`=" . $db->GetSQLValue($Turno) . " WHERE 1";
        }
        else{
            $consulta = "INSERT INTO `datosColegio`( `codigoUnidad`, `unidadEducativa`, `distritoEducativo`, `codDepartamento`, `dependencia`, `turno`) VALUES(" . $db->GetSQLValue($codigoUnidad) . "," . $db->GetSQLValue($UnidadEducativa) . "," . $db->GetSQLValue($Distrito) . "," . $db->GetSQLValue($CodDepartamento, MySQL::SQLVALUE_NUMBER) . "," . $db->GetSQLValue($Dependencia) . "," . $db->GetSQLValue($Turno) . ")";
        }
        
         
        if (!$db->Query($consulta)) {
            // if (!$db->TransactionRollback()) {
            //     $db->Kill();
            // }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 
    public function DatosColegio()
	{              

        $db = new MySQL();
		if ($db->Error()) $db->Kill();


        $consultar = "SELECT dc.*,de.nombre as departamento FROM datosColegio dc
        LEFT join departamento de on de.id = dc.codDepartamento";     
     
       if (!$db->Query($consultar)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
            return 0;
           // return array('request' => 'error', 'mensaje' => $consulta);
        }

        $row = $db->Row();
        return $row;
      
    }

      public function traerCursoAlumno($codCurso)
	{              

        $db = new MySQL();
		if ($db->Error()) $db->Kill();


        $consultar = "SELECT * FROM `cursoAlumnos` where baja = '0' and codCurso=" . $db->GetSQLValue($codCurso, MySQL::SQLVALUE_NUMBER) . " order by apellidos asc";     
     
       if (!$db->Query($consultar)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
            return 0;
           // return array('request' => 'error', 'mensaje' => $consulta);
        }

        return $db;
      
    }

    function obtenerAlumno( $codAlumno){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
            return 0;
            
        }

        
        
        $consultar = "SELECT ca.*,cu.grado,cu.nivel FROM `cursoAlumnos` ca 
        LEFT join curso cu on cu.id = ca.codCurso
        where ca.baja = '0' and ca.id=$codAlumno order by ca.apellidos asc";     

          
        if (!$db->Query($consultar)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
            return 0;
           // return array('request' => 'error', 'mensaje' => $consulta);
        }

        $row = $db->Row();
        return $row;
        
    } 

    function traerBoletin( $CodGrado,$gestion,$codAlumno){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
            return 0;
            
        }

        
        
        $consulta= "SELECT cm.id as codCursoMateria,cm.codCurso,cm.codMateria,cm.codProfesor,ca.id as codCursoAlumno,cm.gestion,pro.nombre as profesor,
        cu.grado ,cu.nivel,ma.nombre as materia,concat(ca.apellidos,' ',ca.nombres) as nombreAlumno,ma.areasCurriculares,ma.saberesConocimiento
        FROM cursoMateria cm 
        LEFT join cursoAlumnos ca on ca.codCurso = cm.codCurso
        LEFT join curso cu on cu.id = ca.codCurso
        LEFT join materia ma on ma.id = cm.codMateria
        LEFT join profesor pro on pro.id = cm.codProfesor
        where cm.codCurso = $CodGrado and cm.gestion = '$gestion' and cm.baja = 0 and ca.id= $codAlumno
        order by ma.saberesConocimiento asc, ma.areasCurriculares asc";

          
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
            return 0;
           // return array('request' => 'error', 'mensaje' => $consulta);
        }

        return $db;
        
    } 

    
    function calcularPromedio($notas){
        if (!$notas) {
            return 0;
        }


          /////////// inicio promedio SER ////////////////
            $promedioSer = 0;
            $totalNotasSer = 0;
            if($notas->calificacion1Ser != '' && $notas->calificacion1Ser != 0){
                $totalNotasSer++;
            }
            if($notas->calificacion2Ser != '' && $notas->calificacion2Ser != 0){
                $totalNotasSer++;
            }
            if($notas->calificacion3Ser != '' && $notas->calificacion3Ser != 0){
                $totalNotasSer++;
            }
             
            $promedioSer = $notas->calificacion3Ser + $notas->calificacion2Ser + $notas->calificacion1Ser;
            if ($totalNotasSer > 0) {
                $promedioSer = number_format($promedioSer / $totalNotasSer,0);
            } else {
                $promedioSer = 0; // o null
            }


             /////////// inicio promedio SABER ////////////////
            $promedioSaber = 0;
            $totalNotasSaber = 0;

            if($notas->calificacion1Saber != '' && $notas->calificacion1Saber != 0){
                $totalNotasSaber++;
            }
            if($notas->calificacion2Saber != '' && $notas->calificacion2Saber != 0){
                $totalNotasSaber++;
            }
            if($notas->calificacion3Saber != '' && $notas->calificacion3Saber != 0){
                $totalNotasSaber++;
            }
            if($notas->calificacion4Saber != '' && $notas->calificacion4Saber != 0){
                $totalNotasSaber++;
            }
            if($notas->calificacion5Saber != '' && $notas->calificacion5Saber != 0){
                $totalNotasSaber++;
            }
            if($notas->calificacion6Saber != '' && $notas->calificacion6Saber != 0){
                $totalNotasSaber++;
            }

            $promedioSaber = $notas->calificacion6Saber + $notas->calificacion5Saber + $notas->calificacion4Saber + $notas->calificacion3Saber + $notas->calificacion2Saber + $notas->calificacion1Saber;
            if ($totalNotasSaber > 0) {
                $promedioSaber = number_format($promedioSaber / $totalNotasSaber,0);
            } else {
                $promedioSaber = 0; // o null
            }



            /////////// inicio promedio HACER ////////////////
            $promedioHacer = 0;
            $totalNotasHacer = 0;
            if($notas->calificacion1Hacer != '' && $notas->calificacion1Hacer != 0){
                $totalNotasHacer++;
            }
            if($notas->calificacion2Hacer != '' && $notas->calificacion2Hacer != 0){
                $totalNotasHacer++;
            }
            if($notas->calificacion3Hacer != '' && $notas->calificacion3Hacer != 0){
                $totalNotasHacer++;
            }
            if($notas->calificacion4Hacer != '' && $notas->calificacion4Hacer != 0){
                $totalNotasHacer++;
            }
            if($notas->calificacion5Hacer != '' && $notas->calificacion5Hacer != 0){
                $totalNotasHacer++;
            }
            if($notas->calificacion6Hacer != '' && $notas->calificacion6Hacer != 0){
                $totalNotasHacer++;
            }

            $promedioHacer = $notas->calificacion6Hacer + $notas->calificacion5Hacer + $notas->calificacion4Hacer + $notas->calificacion3Hacer + $notas->calificacion2Hacer + $notas->calificacion1Hacer;
            if ($totalNotasHacer > 0) {
                $promedioHacer = number_format($promedioHacer / $totalNotasHacer,0);
            } else {
                $promedioHacer = 0; // o null
            }


              /////////// inicio promedio DECIDIR ////////////////
            $promedioDecidir = 0;
            $totalNotasDecidir = 0;
            if($notas->calificacion1Decidir != '' && $notas->calificacion1Decidir != 0){
                $totalNotasDecidir++;
            }
            if($notas->calificacion2Decidir != '' && $notas->calificacion2Decidir != 0){
                $totalNotasDecidir++;
            }
            if($notas->calificacion3Decidir != '' && $notas->calificacion3Decidir != 0){
                $totalNotasDecidir++;
            }
             
            $promedioDecidir = $notas->calificacion3Decidir + $notas->calificacion2Decidir + $notas->calificacion1Decidir;
            if ($totalNotasDecidir > 0) {
                $promedioDecidir = number_format($promedioDecidir / $totalNotasDecidir,0);
            } else {
                $promedioDecidir = 0; // o null
            }

            $promedioTrimestre = $promedioSer + $promedioSaber + $promedioHacer + $promedioDecidir + $notas->autoevaluacion;

            return $promedioTrimestre;

    }
     
      
    function traerNotasXAlumnos($codAlumnoCurso, $gestion) {
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
            return 0;
        }

        // Paso 1: obtener el codCurso del alumno
        if (!$db->Query("SELECT codCurso FROM cursoAlumnos WHERE id = $codAlumnoCurso AND baja = '0'")) {
            return 0;
        }
        $alumnoRow = $db->Row();
        if (!$alumnoRow) return 0;
        $codCurso = $alumnoRow->codCurso;

        // Paso 2: obtener TODAS las materias del curso en esa gestion (igual que traerBoletin)
        $db2 = new MySQL();
        if (!$db2->Query("SELECT cm.codMateria FROM cursoMateria cm WHERE cm.codCurso = $codCurso AND cm.gestion = '$gestion' AND cm.baja = 0 ORDER BY cm.id ASC")) {
            return 0;
        }
        if ($db2->RowCount() == 0) return 0;

        $materias = [];
        $db2->MoveFirst();
        while (!$db2->EndOfSeek()) {
            $materias[] = $db2->Row()->codMateria;
        }

        $totalMaterias = count($materias);
        if ($totalMaterias == 0) return 0;

        $sumaPromediosMaterias = 0;

        // Paso 3: calcular promedio anual por materia igual que generarBoletin.php
        foreach ($materias as $codMateria) {
            $notas1 = $this->traerNotasAlumnos($codMateria, $codAlumnoCurso, 1, $gestion);
            $prom1  = $this->calcularPromedio($notas1);

            $notas2 = $this->traerNotasAlumnos($codMateria, $codAlumnoCurso, 2, $gestion);
            $prom2  = $this->calcularPromedio($notas2);

            $notas3 = $this->traerNotasAlumnos($codMateria, $codAlumnoCurso, 3, $gestion);
            $prom3  = $this->calcularPromedio($notas3);

            // Promedio anual materia = (T1 + T2 + T3) / 3  (igual que boletin linea 338)
            $sumaPromediosMaterias += ($prom1 + $prom2 + $prom3) / 3;
        }

        // Paso 4: promedio general = suma / total materias (materias con 0 cuentan)
        return $sumaPromediosMaterias / $totalMaterias;
    }

    function traerNotasAlumnos($codMateria,$codCursoAlumno,$trimestre="",$gestion=''){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
            return 0;
            
        }

        $condicion = "";
        if($trimestre != ''){
            $condicion .= " and trimestre = " . $db->GetSQLValue($trimestre, MySQL::SQLVALUE_NUMBER);
        }
        if($gestion != ''){
            $condicion .= " and gestion = " . $db->GetSQLValue($gestion);
        }
        
        $consulta= "SELECT * FROM `notas` where codMateria = " . $db->GetSQLValue($codMateria, MySQL::SQLVALUE_NUMBER) . " and codCursoAlumnos=" . $db->GetSQLValue($codCursoAlumno, MySQL::SQLVALUE_NUMBER) . " $condicion ";

          
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
            return 0;
           // return array('request' => 'error', 'mensaje' => $consulta);
        }
        $row = $db->Row();   
        return $row;
        
    } 


     function registrarNota($codCursoAlumno,$codMateria,$valor,$tipo,$posicion,$trimestre,$gestion=''){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }      

        $consulta = "SELECT * from notas where `codCursoAlumnos` = " . $db->GetSQLValue($codCursoAlumno, MySQL::SQLVALUE_NUMBER) . " and `codMateria` = " . $db->GetSQLValue($codMateria, MySQL::SQLVALUE_NUMBER) . " and trimestre = " . $db->GetSQLValue($trimestre, MySQL::SQLVALUE_NUMBER) . " and gestion = " . $db->GetSQLValue($gestion);
        $db->Query($consulta);

        if($db->RowCount() > 0){
            $row = $db->Row();            
            $codNotas= $row->id;

            $campo = "";
            if($tipo=='Ser'){
                if($posicion == 1){
                    $campo=" calificacion1Ser = $valor";
                }
                 if($posicion == 2){
                    $campo=" calificacion2Ser = $valor";
                }
                 if($posicion == 3){
                    $campo=" calificacion3Ser = $valor";
                }
            }
            if($tipo=='Saber'){
                if($posicion == 1){
                    $campo=" calificacion1Saber = $valor";
                }
                 if($posicion == 2){
                    $campo=" calificacion2Saber = $valor";
                }
                 if($posicion == 3){
                    $campo=" calificacion3Saber = $valor";
                }
                  if($posicion == 4){
                    $campo=" calificacion4Saber = $valor";
                }
                  if($posicion == 5){
                    $campo=" calificacion5Saber = $valor";
                }
                  if($posicion == 6){
                    $campo=" calificacion6Saber = $valor";
                }
            }
            if($tipo=='Hacer'){
                if($posicion == 1){
                    $campo=" calificacion1Hacer = $valor";
                }
                 if($posicion == 2){
                    $campo=" calificacion2Hacer = $valor";
                }
                 if($posicion == 3){
                    $campo=" calificacion3Hacer = $valor";
                }
                  if($posicion == 4){
                    $campo=" calificacion4Hacer = $valor";
                }
                  if($posicion == 5){
                    $campo=" calificacion5Hacer = $valor";
                }
                  if($posicion == 6){
                    $campo=" calificacion6Hacer = $valor";
                }
            }

             if($tipo=='Decidir'){
                if($posicion == 1){
                    $campo=" calificacion1Decidir = $valor";
                }
                 if($posicion == 2){
                    $campo=" calificacion2Decidir = $valor";
                }
                 if($posicion == 3){
                    $campo=" calificacion3Decidir = $valor";
                }
            }

            if($tipo=='AutoEvaliacion'){        
                $campo=" autoevaluacion = $valor";                
            }

            $consulta = "UPDATE `notas` SET `$campo` = " . $db->GetSQLValue($valor, MySQL::SQLVALUE_NUMBER) . " WHERE id = " . $db->GetSQLValue($codNotas, MySQL::SQLVALUE_NUMBER);
        }
        else{

             $campo = "";
            
            if($tipo=='Ser'){
                if($posicion == 1){
                    $campo=" calificacion1Ser";
                   
                }
                 if($posicion == 2){
                    $campo=" calificacion2Ser";
                  
                }
                 if($posicion == 3){
                    $campo=" calificacion3Ser";                   
                }
            }
             if($tipo=='Saber'){
                if($posicion == 1){
                    $campo=" calificacion1Saber";
                   
                }
                 if($posicion == 2){
                    $campo=" calificacion2Saber";
                  
                }
                 if($posicion == 3){
                    $campo=" calificacion3Saber";                   
                }
                 if($posicion == 4){
                    $campo=" calificacion4Saber ";
                   
                }
                 if($posicion == 5){
                    $campo=" calificacion5Saber";
                  
                }
                 if($posicion == 6){
                    $campo=" calificacion6Saber";                   
                }
            }

              if($tipo=='Hacer'){
                if($posicion == 1){
                    $campo=" calificacion1Hacer";
                   
                }
                 if($posicion == 2){
                    $campo=" calificacion2Hacer";
                  
                }
                 if($posicion == 3){
                    $campo=" calificacion3Hacer";                   
                }
                 if($posicion == 4){
                    $campo=" calificacion4Hacer ";
                   
                }
                 if($posicion == 5){
                    $campo=" calificacion5Hacer";
                  
                }
                 if($posicion == 6){
                    $campo=" calificacion6Hacer";                   
                }
            }

              if($tipo=='Decidir'){
                if($posicion == 1){
                    $campo=" calificacion1Decidir";
                   
                }
                 if($posicion == 2){
                    $campo=" calificacion2Decidir";
                  
                }
                 if($posicion == 3){
                    $campo=" calificacion3Decidir";                   
                }
            }

             if($tipo=='AutoEvaliacion'){        
                $campo=" autoevaluacion";                
            }

            $consulta = "INSERT INTO `notas`( `codCursoAlumnos`, `codMateria`, `trimestre`, `gestion`, `$campo`) values(" . $db->GetSQLValue($codCursoAlumno, MySQL::SQLVALUE_NUMBER) . "," . $db->GetSQLValue($codMateria, MySQL::SQLVALUE_NUMBER) . "," . $db->GetSQLValue($trimestre, MySQL::SQLVALUE_NUMBER) . "," . $db->GetSQLValue($gestion) . "," . $db->GetSQLValue($valor, MySQL::SQLVALUE_NUMBER) . ")";
        }
      
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 

    function traerNotas($codProfesor,$CodGrado,$gestion,$CodMateria){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
            return 0;
            
        }

        //$condicion = "";
        // $group = "";
        // if($CodMateria == "" && $codProfesor == "0"){
        //     $group = " group by ca.id";
        // }
        
        // if($CodMateria != ''){
        //     $condicion .= " and cm.codMateria = $CodMateria";
        // }
        //  if($codProfesor != '0'){
        //     $condicion .= " and cm.codProfesor = $codProfesor";
        // }
        
        $consulta= "SELECT cm.id as codCursoMateria,cm.codCurso,cm.codMateria,cm.codProfesor,ca.id as codCursoAlumno,cm.gestion,pro.nombre as profesor,
        cu.grado ,cu.nivel,ma.nombre as materia,concat(ca.apellidos,' ',ca.nombres) as nombreAlumno 
        FROM cursoMateria cm 
        LEFT join cursoAlumnos ca on ca.codCurso = cm.codCurso
        LEFT join curso cu on cu.id = ca.codCurso
        LEFT join materia ma on ma.id = cm.codMateria
        LEFT join profesor pro on pro.id = cm.codProfesor
         LEFT join tutor t on t.codCurso = cm.codCurso
        where cm.codCurso = $CodGrado  and cm.codMateria = $CodMateria  and (cm.codProfesor = $codProfesor  or t.codProfesor = $codProfesor ) and cm.gestion = '$gestion' and cm.baja = 0
       
        order by ca.apellidos asc";

        //echo $consulta;
          
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
            return 0;
           // return array('request' => 'error', 'mensaje' => $consulta);
        }

        return $db;
        
    } 


    function ActivarCursoMateria($codigo){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }      

         $consulta = "SELECT * from cursoMateria  where id = '$codigo'";
        $db->Query($consulta);
       
            $row = $db->Row();
            $CodGrado= $row->codCurso;
            $CodMateria= $row->codMateria;
            $gestion= $row->gestion;
          

             $consulta = "SELECT cm.*,p.nombre as profesor FROM cursoMateria cm
                            LEFT join profesor p on p.id = cm.codProfesor
                            where codCurso = '$CodGrado' and codMateria = '$CodMateria'   and gestion = '$gestion' and cm.baja='0'  ";
           //   return array('request' => 'error', 'mensaje' =>  $consulta );
            $db->Query($consulta);
            if($db->RowCount() > 0){

                 $row = $db->Row();
                   $profesor= $row->profesor;
                return array('request' => 'error', 'mensaje' =>  $profesor.' ya registro esa materia con ese curso');
            }


        $consulta = "UPDATE cursoMateria SET baja = '0' where id = $codigo";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 
    function eliminarCursoMateria($codigo){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }      

        $consulta = "UPDATE cursoMateria SET baja = '1' where id = $codigo";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 



    function ActivarCursoTutor($codigo){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }      

        

        $consulta = "UPDATE tutor SET baja = '0' where id = $codigo";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 
    function eliminarCursoTutor($codigo){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }      

        $consulta = "UPDATE tutor SET baja = '1' where id = $codigo";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 


     function crearCursoTutor($codProfesor,$CodGrado){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }

       
        $consulta = "SELECT * from tutor  where codCurso = '$CodGrado' ";
        $db->Query($consulta);
        if($db->RowCount() > 0){
            return array('request' => 'error', 'mensaje' => 'Ya tiene agregado el mismo curso');
        }

        $consulta = "INSERT INTO `tutor`( `codCurso`, `codProfesor`, `baja`)  VALUES( '$CodGrado' , '$codProfesor' ,0)";
         
        if (!$db->Query($consulta)) {
            // if (!$db->TransactionRollback()) {
            //     $db->Kill();
            // }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 


     function traerCursoTutor($codProfesor){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
            return 0;
          //  return array('request' => 'error', 'mensaje' => 'Error interno');
        }

        $condicion ='';
        if($codProfesor != ''){
            $condicion .= " and t.codProfesor = '$codProfesor'";
        }
       

        $consulta = "SELECT t.*,cu.grado,cu.nivel,p.nombre as profesor FROM tutor t
        LEFT join curso cu on cu.id = t.codCurso
        LEFT join profesor p on p.id =  t.codProfesor
        where 1=1 $condicion  ";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
            return 0;
           // return array('request' => 'error', 'mensaje' => $consulta);
        }
       
        return $db;               
    }


    function crearCursoMateria($codProfesor,$CodGrado,$CodMateria,$gestion){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }

       
        $consulta = "SELECT * from cursoMateria  where codCurso = '$CodGrado' and codMateria = '$CodMateria'   and gestion = '$gestion' and baja='0'  ";
        $db->Query($consulta);
        if($db->RowCount() > 0){
            return array('request' => 'error', 'mensaje' => 'Un profesor(a) ya registro esa materia con ese curso');
        }

        $consulta = "INSERT INTO `cursoMateria`( `codCurso`, `codMateria`, `codProfesor`, `gestion`, `baja`) VALUES( '$CodGrado' ,'$CodMateria' ,'$codProfesor' ,'$gestion' ,0)";
         
        if (!$db->Query($consulta)) {
            // if (!$db->TransactionRollback()) {
            //     $db->Kill();
            // }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 

    function traerMateriasProfesor($codProfesor){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
            return 0;
          //  return array('request' => 'error', 'mensaje' => 'Error interno');
        }

        $condicion ='';
        if($codProfesor != ''){
            $condicion .= " and cm.codProfesor = '$codProfesor'";
        }
       

        $consulta = "SELECT cm.*,cu.grado,cu.nivel,ma.nombre as materia FROM cursoMateria cm 
        LEFT join curso cu on cu.id = cm.codCurso
        LEFT join materia ma on ma.id = cm.codMateria
        where 1=1 $condicion  ";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
            return 0;
           // return array('request' => 'error', 'mensaje' => $consulta);
        }
       
        return $db;               
    }


     function crearProfesor($Nombre){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }

        $Nombre = trim($Nombre);
      

        $consulta = "SELECT * from profesor where nombre = '$Nombre'  ";
        $db->Query($consulta);
        if($db->RowCount() > 0){
            return array('request' => 'error', 'mensaje' => 'ya existe un profesor registrado con ese nombre');
        }

        $consulta = "INSERT INTO `profesor`(`nombre`,`baja`) VALUES( '$Nombre' ,0)";
         
        if (!$db->Query($consulta)) {
            // if (!$db->TransactionRollback()) {
            //     $db->Kill();
            // }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 

      function ActivarProfesor($codigo){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }      

        $consulta = "UPDATE profesor SET baja = '0' where id = $codigo";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 
     function eliminarProfesor($codigo){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }      

        $consulta = "UPDATE profesor SET baja = '1' where id = $codigo";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 

     function editarProfesor($codigo,$nombres){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }

        $nombres = trim($nombres);
       

         $consulta = "SELECT * from profesor where nombre = '$nombres'  ";
        $db->Query($consulta);
        if($db->RowCount() > 0){
            return array('request' => 'error', 'mensaje' => 'ya existe un progesor registrado con ese nombre');
        }
        
        $consulta = "UPDATE `profesor` SET `nombre` = '$nombres'  where id = $codigo";
         
        if (!$db->Query($consulta)) {
            // if (!$db->TransactionRollback()) {
            //     $db->Kill();
            // }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 

    function traerProfesor($codCurso){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
            return 0;
          //  return array('request' => 'error', 'mensaje' => 'Error interno');
        }

        $condicion ='';
        if($codCurso != ''){
            $condicion .= " and nombre = '$codCurso'";
        }
       

        $consulta = "SELECT p.*,t.nombre as tipoUsuario,u.codTipoUsuario from profesor p 
        left join usuario u on u.codUsuario = p.codUsuario
        left join tipoUsuario t on t.codTipoUsuario = u.codTipoUsuario
        where 1=1  order by nombre asc";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
            return 0;
           // return array('request' => 'error', 'mensaje' => $consulta);
        }
       
        return $db;               
    }


    function crearAlumnoCSV($filas,$CodGrado){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }

        $filas = $_POST['filas'];
        $insertados = 0;
        $duplicados = 0;
        $filasDuplicadas = "";

          foreach ($filas as $f) {
 
            $Nombre = trim($f['nombre']);
            $Apellidos = trim($f['apellido']);
            $rude = trim($f['rude']);

              $consulta = "SELECT * from cursoAlumnos where codCurso = " . $db->GetSQLValue($CodGrado, MySQL::SQLVALUE_NUMBER) . " and ((nombres = " . $db->GetSQLValue($Nombre) . " and apellidos = " . $db->GetSQLValue($Apellidos) . ") or rude = " . $db->GetSQLValue($rude) . ")";
                $db->Query($consulta);
                if($db->RowCount() > 0){
                    $duplicados++;
                    $filasDuplicadas .= "<li>".$Apellidos." ".$Nombre ."</li>";
                   // $filasDuplicadas  .= $Apellidos ." " . $Nombre . " - " .$rude . "\n";
                }              
        }

        if($duplicados > 0){
              return array('request' => 'duplicado', 'mensaje' => $filasDuplicadas);
        }

        foreach ($filas as $f) {

            if ($f['apellido'] == '' || $f['nombre'] == '' || $f['rude'] == '') {
                continue; // seguridad extra
            }

            $Nombre = trim($f['nombre']);
            $Apellidos = trim($f['apellido']);
            $rude = trim($f['rude']);
 
                $consulta = "INSERT INTO `cursoAlumnos`( `codCurso`, `codProfesor`, `nombres`, `apellidos`,  `rude`, `baja`) VALUES(" . $db->GetSQLValue($CodGrado, MySQL::SQLVALUE_NUMBER) . ", 0," . $db->GetSQLValue($Nombre) . "," . $db->GetSQLValue($Apellidos) . "," . $db->GetSQLValue($rude) . ",0)";
                
                if (!$db->Query($consulta)) {                
                    return array('request' => 'error', 'mensaje' => $consulta);
                }
        }
 
       return array('request' => 'ok', 'mensaje' => "");
        
    } 

    function crearAlumno($CodGrado,$Nombre,$Apellidos,$codProfesor,$rude,$gestion){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }

        $Nombre = trim($Nombre);
        $Apellidos = trim($Apellidos);
        $rude = trim($rude);
        $gestion = trim($gestion);

        $consulta = "SELECT * from cursoAlumnos where codCurso = $CodGrado and nombres = '$Nombre' and apellidos = '$Apellidos' and rude = '$rude' and gestion = '$gestion' ";
        $db->Query($consulta);
        if($db->RowCount() > 0){
            return array('request' => 'error', 'mensaje' => 'ya existe un alumno registrado con ese nombre en ese curso');
        }

        $consulta = "INSERT INTO `cursoAlumnos`( `codCurso`, `codProfesor`, `nombres`, `apellidos`, `rude`,`gestion`, `baja`) VALUES('$CodGrado', $codProfesor,'$Nombre','$Apellidos','$rude',$gestion,0)";
         
        if (!$db->Query($consulta)) {
            // if (!$db->TransactionRollback()) {
            //     $db->Kill();
            // }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 

      function ActivarAlumno($codigo){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }      

        $consulta = "UPDATE cursoAlumnos SET baja = '0' where id = $codigo";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 
     function eliminarAlumno($codigo){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }      

        $consulta = "UPDATE cursoAlumnos SET baja = '1' where id = $codigo";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 

     function editarAlumno($codigo,$codCurso,$nombres,$apellidos,$codProfesor,$rude,$gestion){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }

        $nombres = trim($nombres);
        $apellidos = trim($apellidos);
        $rude = trim($rude);
        $gestion = trim($gestion);
        //  $consulta = "SELECT * from cursoAlumnos where codCurso = $codCurso and nombres = '$nombres' and apellidos = '$apellidos' ";
        // $db->Query($consulta);
        // if($db->RowCount() > 0){
        //     return array('request' => 'error', 'mensaje' => 'ya existe un alumno registrado con ese nombre en ese curso');
        // }
        
        $consulta = "UPDATE `cursoAlumnos` SET `codProfesor` = '$codProfesor',`nombres` = '$nombres',`apellidos` = '$apellidos',`codCurso` = '$codCurso',`rude` = '$rude',`gestion` = '$gestion'  where id = $codigo";
         
        if (!$db->Query($consulta)) {
            // if (!$db->TransactionRollback()) {
            //     $db->Kill();
            // }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 

    function traerAlumnos($codCurso,$estado,$gestion=''){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
            return 0;
          //  return array('request' => 'error', 'mensaje' => 'Error interno');
        }

        $condicion ='';
        if($codCurso != ''){
            $condicion .= " and ca.codCurso = " . $db->GetSQLValue($codCurso, MySQL::SQLVALUE_NUMBER);
        }
        if($estado != ''){
            $condicion .= " and ca.baja = " . $db->GetSQLValue($estado, MySQL::SQLVALUE_NUMBER);
        }
         if($gestion != ''){
            $condicion .= " and ca.gestion = " . $db->GetSQLValue($gestion);
        }

        $consulta = "SELECT ca.id ,ca.codCurso,cu.grado as curso,cu.nivel as nivel,ca.codProfesor,pro.nombre as profesor,ca.nombres,ca.apellidos,ca.baja ,ca.rude,ca.gestion
        FROM cursoAlumnos ca 
        LEFT JOIN curso cu on cu.id = ca.codCurso
        left join profesor pro on pro.id = ca.codProfesor
        where 1=1  $condicion order by cu.grado asc, ca.apellidos asc, ca.nombres asc";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
            return 0;
           // return array('request' => 'error', 'mensaje' => $consulta);
        }
       
      
        return $db;               
    }

    function traerMateria($nombre){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
            return 0;
          //  return array('request' => 'error', 'mensaje' => 'Error interno');
        }

        $condicion ='';
        if($nombre != ''){
            $condicion .= " and nombre like '%$nombre%'";
        }
     

        $consulta = "SELECT * from materia  where 1=1  $condicion order by nombre asc";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
            return 0;
           // return array('request' => 'error', 'mensaje' => $consulta);
        }
       
        return $db;               
    }

    function crearMateria($nombre,$area,$saberes){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }

        $nombre = trim($nombre);
         $area = trim(mb_strtoupper($area, 'UTF-8'));
       $saberes = trim($saberes);

        $consulta = "SELECT * from materia where nombre = '$nombre' ";
        $db->Query($consulta);
        if($db->RowCount() > 0){
            return array('request' => 'error', 'mensaje' => 'ya existe esa materia registrada');
        }
        $consulta = "INSERT INTO `materia`( `nombre`,`areasCurriculares`,`saberesConocimiento`, `baja`) values('$nombre','$area','$saberes', 0)";
         
        if (!$db->Query($consulta)) {
            // if (!$db->TransactionRollback()) {
            //     $db->Kill();
            // }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 

    function traerAsignacionesMateria($codMateria) {
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
            return 0;
        }

        $consulta = "SELECT cm.*, cu.grado, cu.nivel, pro.nombre as profesor 
                     FROM cursoMateria cm 
                     LEFT JOIN curso cu ON cu.id = cm.codCurso 
                     LEFT JOIN profesor pro ON pro.id = cm.codProfesor 
                     WHERE cm.codMateria = $codMateria AND cm.baja = 0 
                     ORDER BY cm.gestion DESC, cu.grado ASC";
        
        if (!$db->Query($consulta)) {
            return 0;
        }
       
        return $db;
    }

    function ActivarMateria($codMateria){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }      

        $consulta = "UPDATE materia SET baja = '0' where id = $codMateria";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 
     function eliminarMateria($codMateria){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }      

        $consulta = "UPDATE materia SET baja = '1' where id = $codMateria";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 

     function editarMateria($codigo,$nombre,$area,$saberes){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }

        $nombre = trim($nombre);
        $area = trim(mb_strtoupper($area, 'UTF-8'));
        $saberes = trim($saberes);

        //  $consulta = "SELECT * from materia where nombre = '$nombre'   and baja=0 ";
        // $db->Query($consulta);
        // if($db->RowCount() > 0){
        //     return array('request' => 'error', 'mensaje' => 'ya existe esa materia registrada');
        // }
        
        $consulta = "UPDATE `materia` SET `nombre` = '$nombre',`areasCurriculares` = '$area', `saberesConocimiento` = '$saberes'  where id = $codigo";
         
        if (!$db->Query($consulta)) {
            // if (!$db->TransactionRollback()) {
            //     $db->Kill();
            // }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 



    function traerCurso($nombre){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
            return 0;
          //  return array('request' => 'error', 'mensaje' => 'Error interno');
        }

        $condicion ='';
        if($nombre != ''){
            $condicion .= " and grado like '%$nombre%'";
        }
     

        $consulta = "SELECT * from curso  where 1=1 $condicion order by grado asc";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
            return 0;
           // return array('request' => 'error', 'mensaje' => $consulta);
        }
       
        return $db;
       
        
    }

    function eliminarCurso($codCurso){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }      

        $consulta = "UPDATE curso SET baja = '1' where id = $codCurso";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 

      function AcivarCurso($codCurso){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }      

        $consulta = "UPDATE curso SET baja = '0' where id = $codCurso";
        
        if (!$db->Query($consulta)) {
            if (!$db->TransactionRollback()) {
                $db->Kill();
            }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 

     function editarCurso($codigo,$grado,$nivel){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }

         $consulta = "SELECT * from curso where grado = '$grado' and nivel = '$nivel' ";
        $db->Query($consulta);
        if($db->RowCount() > 0){
            return array('request' => 'error', 'mensaje' => 'ya existe ese curso registrado');
        }
        
        $consulta = "UPDATE `curso` SET `grado` = '$grado', `nivel` = '$nivel' where id = $codigo";
         
        if (!$db->Query($consulta)) {
            // if (!$db->TransactionRollback()) {
            //     $db->Kill();
            // }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 

    function crearCurso($grado,$nivel){
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
          //  return 0;
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }

        $grado = trim($grado);
        $nivel = trim($nivel);

        $consulta = "SELECT * from curso where grado = '$grado' and nivel = '$nivel' and baja=0 ";
        $db->Query($consulta);
        if($db->RowCount() > 0){
            return array('request' => 'error', 'mensaje' => 'ya existe ese curso registrado');
        }
        $consulta = "INSERT INTO `curso`( `grado`, `nivel`, `baja`) values('$grado', '$nivel', 0)";
         
        if (!$db->Query($consulta)) {
            // if (!$db->TransactionRollback()) {
            //     $db->Kill();
            // }
           // return 0;
            return array('request' => 'error', 'mensaje' => $consulta);
        }

        
       return array('request' => 'ok', 'mensaje' => "");
        
    } 

    function iniciarSesion($user, $contra) {
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
            return 0;
        }

        $consulta = "SELECT u.*, concat(per.nombre,' ',per.apellidos) as nombreUsuario, ti.nombre as tipoUsuario 
        FROM usuario u 
        LEFT join persona per on per.id = u.codPersona 
        LEFT join tipoUsuario ti on ti.codTipoUsuario = u.codTipoUsuario
        where u.usuario ='$user' and u.baja = 0";

        if (!$db->Query($consulta)) {
            return 0;         
        }

        if ($db->RowCount() > 0) {
            $db->MoveFirst();
            $row = $db->Row();

            if (password_verify($contra, $row->clave)) {
                $_SESSION['codTipoUsuario'] = $row->codTipoUsuario;
                $_SESSION['tipoUsuario'] = $row->tipoUsuario;
                $_SESSION['codPersona'] = $row->codPersona;
                $_SESSION['nombre'] = $row->nombreUsuario;
                $_SESSION['codigousuario'] = $row->codUsuario;
                if (!isset($_SESSION['last_activity'])) {
                    $_SESSION['last_activity'] = time();
                }
                return 'ok';
            }
        }
        return 'error';
    }
     

    function modificarContrasenha($actual, $nueva, $repeticion, $codUsuario) {
        $db = new MySQL();
        if ($db->Error()) {
            $db->Kill();
            return array('request' => 'error', 'mensaje' => 'Error interno');
        }

        $consulta = "SELECT * from usuario where codUsuario = '$codUsuario'";
        if (!$db->Query($consulta)) {
            return array('request' => 'error', 'mensaje' => 'Error al buscar usuario');
        }

        if ($db->RowCount() > 0) {
            $row = $db->Row();
            if (!password_verify($actual, $row->clave)) {
                return array('request' => 'error', 'mensaje' => 'La contraseña actual ingresada no es correcta');
            }
        } else {
            return array('request' => 'error', 'mensaje' => 'Usuario no encontrado');
        }

        $hashedNueva = password_hash($nueva, PASSWORD_DEFAULT);
        $consulta = "UPDATE usuario set clave = '$hashedNueva' where codUsuario = '$codUsuario'";
         
        if (!$db->Query($consulta)) {
            return array('request' => 'error', 'mensaje' => 'Error al actualizar contraseña');
        }

        return array('request' => 'ok', 'mensaje' => "");
    } 



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

    public function crearAnuncio($titulo, $descripcion, $fechaVencimiento, $codUsuario) {
        $db = new MySQL();
        $consulta = "INSERT INTO anuncio (titulo, descripcion, fecha_vencimiento, codUsuario) 
                     VALUES (" . $db->GetSQLValue($titulo) . ", " . $db->GetSQLValue($descripcion) . ", " . $db->GetSQLValue($fechaVencimiento) . ", " . $db->GetSQLValue($codUsuario, MySQL::SQLVALUE_NUMBER) . ")";
        if (!$db->Query($consulta)) { return array('request' => 'error', 'mensaje' => 'Error al registrar anuncio'); }
        return array('request' => 'ok', 'mensaje' => 'Anuncio registrado exitosamente');
    }

    public function traerAnuncios($soloActivos = true) {
        $db = new MySQL();
        $condicion = "";
        if ($soloActivos) {
            $condicion = " WHERE a.baja = 0 AND a.fecha_vencimiento >= CURDATE() ";
        }
        $c = "SELECT a.*, p.nombre as autorNombre, p.apellidos as autorApellidos 
              FROM anuncio a 
              LEFT JOIN usuario u ON a.codUsuario = u.codUsuario 
              LEFT JOIN persona p ON u.codPersona = p.id 
              $condicion 
              ORDER BY a.fecha_creacion DESC";
        if (!$db->Query($c)) return [];
        $res = [];
        while (!$db->EndOfSeek()) { $res[] = (array)$db->Row(); }
        return $res;
    }

    public function eliminarAnuncio($id) {
        $db = new MySQL();
        $consulta = "UPDATE anuncio SET baja = 1 WHERE id = " . $db->GetSQLValue($id, MySQL::SQLVALUE_NUMBER);
        if (!$db->Query($consulta)) { return array('request' => 'error', 'mensaje' => 'Error al eliminar'); }
        return array('request' => 'ok', 'mensaje' => 'Anuncio eliminado');
    }

}