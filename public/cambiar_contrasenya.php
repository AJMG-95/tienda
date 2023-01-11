<?php
session_start();

require '../vendor/autoload.php';


// Recive los datos mediante POST
$password = obtener_post('password');
$newpassword = obtener_post('newpassword');
$passwordrepeat = obtener_post('passwordrepeat');

// Conecta con la base de datos
$pdo = conectar();

$usuario = \App\Tablas\Usuario::logueado();
$id = $usuario->obtenerId();

// Recoge la contraseña actual
$sent = $pdo->prepare("SELECT password
                        FROM usuarios
                        WHERE id = :id");
$sent->execute([':id' => $id]);
$origin = $sent->fetchColumn();


//Actualiza la contraseña del usuario
$error = ['password' => [], 'new_password' => []];

if (!empty($password)){
    if (password_verify($password, $origin)) {
        $error['password'][] = 'La contraseña no coincide con la actual';
    }
}

if (!empty($newpassword)) {
    if (preg_match('/[a-z]/', $newpassword) !== 1) {
        $error['new_password'][] = 'Debe contener al menos una minúscula.';
    }
    if (preg_match('/[A-Z]/', $newpassword) !== 1) {
        $error['new_password'][] = 'Debe contener al menos una mayúscula.';
    }
    if (preg_match('/[[:digit:]]/', $newpassword) !== 1) {
        $error['new_password'][] = 'Debe contener al menos un dígito.';
    }
    if (preg_match('/[[:punct:]]/', $newpassword) !== 1) {
        $error['new_password'][] = 'Debe contener al menos un signo de puntuación.';
    }
    if (mb_strlen($newpassword) < 8) {
        $error['new_password'][] = 'Debe tener al menos 8 caracteres.';
    }
    if($newpassword != $passwordrepeat) {
        $error['new_password'][] = 'La contraseña no coincide';
    }
}

$vacio = true;

foreach($error as $err){
    if(!empty($err)){
        $vacio = false;
        break;
    }
}

if($vacio) {
    $usuario->cambiar_contrasenya($usuario, $newpassword, $pdo);
    $_SESSION['exito'] = 'La contraseña se ha modificado correctamente.';

    return volver_a("/perfil.php");
}


//Establecer un mensaje de éxito y vuelve a la página de perfil
