<?php
session_start();

require '../../src/auxiliar.php';

// Recive los datos mediante POST
$id = obtener_post('id');
$codigo = obtener_post('codigo');
$descripcion = obtener_post('descripcion');
$precio = obtener_post('precio');
$stock = obtener_post('stock');

// Conecta con la base de datos
$pdo = conectar();

// Comprueba si existe el id
if (!isset($id)) {
    // Si no existe, regresa a la pagina admin
    return volver_admin();
}

// Recoge los valores actuales del registro
$sent = $pdo->prepare("SELECT codigo, descripcion, precio, stock
                        FROM articulos
                        WHERE id = :id");
$sent->execute([':id' => $id]);
$origin = $sent->fetch(PDO::FETCH_ASSOC);

//Actualizar el registro con los datos POST o los valores actuales
$sent = $pdo->prepare("UPDATE articulos
                        SET codigo = :codigo, descripcion = :descripcion, precio = :precio, stock = :stock
                        WHERE id = :id");
$sent->execute([
    ':id' => $id,
    ':codigo' => $codigo ?: $origin['codigo'],
    ':descripcion' => $descripcion ?: $origin['descripcion'],
    ':precio' => $precio ?: $origin['precio'],
    ':stock' => $stock ?: $origin['stock']
]);

//Establecer un mensaje de éxito y vuelve a la página de administración
$_SESSION['exito'] = 'El artículo se ha modificado correctamente.';
return volver_admin();
