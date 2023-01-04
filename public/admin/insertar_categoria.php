<?php
session_start();

require "../../src/auxiliar.php";

$categoria = hh($_POST['categoria'], ENT_QUOTES, 'UTF-8');

if (!$categoria) {
    $_SESSION['error'] = 'Entrada no válida. Por favor, inténtelo de nuevo.';
    return volver_categorias();
}

try {
    $pdo = conectar();
    $sent = $pdo->prepare("INSERT INTO categorias(categoria) VALUES (:categoria)");
    $sent->execute([
        ':categoria' => $categoria
    ]);

    $_SESSION['exito'] = 'La categoria se ha añadido correctamente.';

} catch (PDOException $e) {
    $_SESSION['error'] = 'Se ha producido un error al añadir la categoría. Por favor, inténtelo de nuevo.';
}

return volver_categorias();
