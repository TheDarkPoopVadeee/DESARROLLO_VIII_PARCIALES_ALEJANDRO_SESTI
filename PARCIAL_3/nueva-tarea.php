<?php 
session_start();
date_default_timezone_set('America/Panama');

$tareas = isset($_SESSION['tareas']) ? $_SESSION['tareas'] : [];

$sesion_cookie = isset($_COOKIE['session']) ? $_COOKIE['session'] : [];
$usuario = isset($sesion_cookie['user']) ? $sesion_cookie['user'] : '';
$usuario_inicio_sesion = $usuario !== '' ? true : false;

if($usuario_inicio_sesion !== true){
    header('Location: ./index.php?pagina=nueva-tarea&error=1');
    exit;
}

$tarea = isset($_POST['tarea']) ? trim(strip_tags($_POST['tarea'])) : '';
$fecha_limite = isset($_POST['fecha_limite']) ? trim($_POST['fecha_limite']) : '';
$fecha_actual_timestamp = strtotime("now");

if($tarea == '' || $fecha_limite == ''){
    header('Location: ./index.php?pagina=nueva-tarea&error=2');
    exit;
}

function fecha_valida($date) {
    $tempDate = explode('-', $date);
    $yyyy = isset($tempDate[0]) ? $tempDate[0] : '';
    $mm = isset($tempDate[1]) ? $tempDate[1] : '';
    $dd = isset($tempDate[2]) ? $tempDate[2] : '';
    return checkdate($mm, $dd, $yyyy);
}

if( !fecha_valida($fecha_limite) ){
    header('Location: ./index.php?pagina=nueva-tarea&error=3');
    exit;
}

$fecha_limite_timestamp = strtotime($fecha_limite);

if($fecha_limite_timestamp <= $fecha_actual_timestamp){
    header('Location: ./index.php?pagina=nueva-tarea&error=4');
    exit;
}

$tareas = is_array($tareas) ? $tareas : [];

$nueva_tarea = array(
'user' => $usuario,
'tareas' => $tarea,
'fecha_limite' => $fecha_limite,
);

$tareas[] = $nueva_tarea;

$_SESSION['tareas'] = $tareas;

if(is_array($_SESSION['tareas']) && count($_SESSION['tareas']) > 0){
    header('Location: ./index.php?pagina=nueva-tarea&success=1');
    exit;
}