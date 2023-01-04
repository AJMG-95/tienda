<?php
session_start();

require "../../src/auxiliar.php";

// Sanear la entrada del usuario.
$codigo = hh($_POST['codigo'], ENT_QUOTES, 'UTF-8');
$descripcion = hh($_POST['descripcion'], ENT_QUOTES, 'UTF-8');
$precio = filter_input(INPUT_POST, 'precio', FILTER_SANITIZE_NUMBER_FLOAT);
$stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_NUMBER_INT);
$categoria_id = filter_input(INPUT_POST, 'categoria_id', FILTER_SANITIZE_NUMBER_INT);

// Validar la entrada del usuario.
if (!$codigo || !$descripcion || !$precio || !$stock || !$categoria_id) {
    $_SESSION['error'] = 'Entrada no válida. Por favor, inténtelo de nuevo.';
    return volver_admin();
}

try {
    // Conectar a la base de datos.
    $pdo = conectar();

    // Preparar y ejecutar la sentencia INSERT.
    $stmt = $pdo->prepare("INSERT INTO articulos (codigo, descripcion, precio, stock, categoria_id) VALUES (:codigo, :descripcion, :precio, :stock, :categoria_id)");
    $stmt->execute([
        ':codigo' => $codigo,
        ':descripcion' => $descripcion,
        ':precio' => $precio,
        ':stock'  => $stock,
        ':categoria_id' => $categoria_id
    ]);

    // Establecer mensaje de éxito.
    $_SESSION['exito'] = 'El artículo se ha modificado correctamente.';

} catch (PDOException $e) {
    // Mensaje de error.
    $_SESSION['error'] = 'Se ha producido un error al añadir el artículo. Por favor, inténtelo de nuevo.';
}

return volver_admin();
