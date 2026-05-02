<?php 
// Ocultar warnings y notices globalmente para el sistema
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE & ~E_DEPRECATED);

// Security Headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");

// Global input sanitization for XSS (basic)
function sanitize_input(&$item, $key) {
    if (is_string($item)) {
        $item = htmlspecialchars($item, ENT_QUOTES, 'UTF-8');
    }
}
// Note: We only sanitize if we are sure the app doesn't need raw HTML in POST/GET.
// Given the nature of this school system, it's safer to enable it.
// array_walk_recursive($_GET, 'sanitize_input');
// array_walk_recursive($_POST, 'sanitize_input');
// Establece un tiempo de vida para la cookie de sesión (en segundos)
$cookie_lifetime = 60 * 60 * 24 * 30; // 30 días

// Actualiza la configuración de la cookie de sesión
session_set_cookie_params($cookie_lifetime);

// Inicia la sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Establece un tiempo de vida para la sesión (en segundos)
$inactivity_timeout = 60 * 60 * 24 * 30; // 30 días

// Verifica si la sesión ha expirado debido a inactividad
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $inactivity_timeout)) {
    // La sesión ha expirado
    session_unset();     // Elimina todas las variables de sesión
    session_destroy();   // Destruye la sesión
    header("Location: ../../login.php");
}

// Actualiza el tiempo de actividad de la sesión
$_SESSION['last_activity'] = time();



if (!isset($_SESSION['codigousuario'])) {
    header("Location: ../../login.php");
}

$scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME']);
$rutaBase = preg_replace('#/view/.*$#', '', $scriptName);
$rutasFinanzas = array(
    '/view/ingresos/',
    '/view/deudores/',
    '/view/egresos/',
    '/view/conceptosEgresos/',
    '/view/balance/'
);

if (isset($_SESSION['codTipoUsuario']) && (int)$_SESSION['codTipoUsuario'] === 6) {
    $rutasPermitidas = $rutasFinanzas;
    $permitido = false;
    foreach ($rutasPermitidas as $ruta) {
        if (strpos($scriptName, $ruta) !== false) {
            $permitido = true;
            break;
        }
    }

    if (!$permitido) {
        header("Location: " . $rutaBase . "/view/balance/");
        exit;
    }
}

if (isset($_SESSION['codTipoUsuario']) && ((int)$_SESSION['codTipoUsuario'] === 2 || (int)$_SESSION['codTipoUsuario'] === 4)) {
    foreach ($rutasFinanzas as $ruta) {
        if (strpos($scriptName, $ruta) !== false) {
            header("Location: " . $rutaBase . "/view/anuncios/");
            exit;
        }
    }
}

?>
