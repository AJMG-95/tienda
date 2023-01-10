<?php

session_start();

require '../vendor/autoload.php';



$id = \App\Tablas\Usuario::logueado()->id;

$pdo = conectar();

$sent = $pdo->prepare("SELECT nombre, apellidos, email, telefono
                        FROM usuarios
                        WHERE id = $id");

$sent->execute();
$origen = $sent->fetch();

$nombre = obtener_post('nombre');
$apellidos = obtener_post('apellidos');

$email = obtener_post('email');
$telefono = obtener_post('telefono');

if (isset($email) && $email != '') {
    if (!preg_match("/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/", $email)) {
        $_SESSION['error'] = "El email es inválido";
        return (volver_a("/perfil.php"));
    }
}

if (isset($telefono) && $telefono != '') {
    if (!preg_match("/^\d{9}$/", $telefono)) {
        $_SESSION['error'] = "El teléfono debe contener 9 dígitos y sólo puede contener números";
        return (volver_a("/perfil.php"));
    }
}

$sent = $pdo->prepare("UPDATE usuarios
                        SET nombre = :nombre, apellidos = :apellidos, email = :email, telefono = :telefono
                        WHERE id = $id");

$sent->execute([
    ':nombre' => $nombre ?: $origen['nombre'],
    ':apellidos' => $apellidos  ?: $origen['apellidos'],
    ':email' => $email ?: $origen['email'],
    ':telefono' => $telefono ?: $origen['telefono'],
]);

$_SESSION['exito'] = 'El perfil del usuario se ha actualizado correctamente.';


volver_a("/perfil.php");
