<?php

session_start();

require '../vendor/autoload.php';


$id = \App\Tablas\Usuario::logueado()->id;

$pdo = conectar();

$sent = $pdo->prepare("SELECT nombre, apellidos, email, telefono FROM usuarios WHERE id = $id");
$sent->execute();
$origen = $sent->fetch();

$nombre = obtener_post('nombre') ?? $origen['nombre'];
$apellidos = obtener_post('apellidos') ?? $origen['apellidos'];
$email = obtener_post('email') ?? $origen['email'];
$telefono = obtener_post('telefono') ?? $origen['telefono'];

if (preg_match("/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/", $email)) {
    if (preg_match("(\+34|0034|34)?[ -]*(6|7|8|9)[ -]*([0-9][ -]*){9}", $telefono)) {
        $sent = $pdo->prepare("UPDATE usuarios SET nombre = :nombre, apellidos = :apellidos, email = :email, telefono = :telefono WHERE id = $id");
        $sent->execute([':nombre' => $nombre, ':apellidos' => $apellidos, ':email' => $email, ':telefono' => $telefono]);
        $_SESSION['exito'] = 'El perfil del usuario se ha añadido correctamente.';
        return(volver());
    } else {
        $_SESSION['error'] = "El teléfono debe contener 9 dígitos y sólo puede contener números";
        return(volver());
    }
} else {
    $_SESSION['error'] = "El email es inválido";
    return(volver());
}
