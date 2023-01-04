<?php
session_start();

require '../../src/auxiliar.php';

$id = obtener_post('id', FILTER_VALIDATE_INT);


if(!ctype_digit($id) || !isset($id)){
    return volver_admin();
} else {
    $pdo = conectar();
    $sent = $pdo->prepare("DELETE FROM articulos WHERE id = :id");
    $sent->execute([':id' => $id]);
    $_SESSION['exito'] = 'El artículo se ha borrado correctamente.';
}

volver_admin();
