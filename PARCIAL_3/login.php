<?php 
session_start(); 
$datos_predefinidos = array(
'user' => 'demo1',
'pass' => 'demo1'
);
$user = isset($_POST['user']) ? trim(strip_tags($_POST['user'])) : '';
$pass = isset($_POST['password']) ? trim(strip_tags($_POST['password'])) : '';

if($user == '' || $pass == ''){
    header('Location: ./index.php?error=0');
    exit;
}

$datos_invalidos = false;
if($datos_predefinidos['user'] !== $user){
$datos_invalidos = true;
}
if($datos_predefinidos['pass'] !== $pass){
$datos_invalidos = true;
}

if($datos_invalidos !== false){
    header('Location: ./index.php?error=1');
    exit;
}

#$_SESSION['user'] = $user;
#$_SESSION['inicio_sesion'] = time();

setcookie("session[user]", $user);
setcookie("session[inicio_sesion]", time());
setcookie("session[tareas]", '');

$_SESSION['tareas'] = [];
header('Location: ./index.php?success=1');
exit;
?>