<?php
session_start();

require '../../src/auxiliar.php';

// Recive los datos mediante POST
$id = obtener_post('id');
$codigo= obtener_post('codigo');
$descripcion = obtener_post('descripcion');
$precio = obtener_post('precio');
$descuento = obtener_post('descuento');
$stock = obtener_post('stock');
$categoria_id= obtener_post('categoria_id');
$visible= obtener_post('visible');

// Conecta con la base de datos
$pdo = conectar();

// Comprueba si existe el id
if (!isset($id)) {
    // Si no existe, regresa a la pagina admin
    return volver_admin();
}

// Recoge los valores actuales del registro
$sent = $pdo->prepare("SELECT codigo, descripcion, precio,
                            descuento,
                            stock, visible, categoria_id
                        FROM articulos
                        WHERE id = :id");
$sent->execute([':id' => $id]);
$origin = $sent->fetch(PDO::FETCH_ASSOC);

// Calculate the cantidad_descuento based on the descuento and precio

$cantidad_descuento = $precio ?  $precio * ($descuento / 100) : $origin['precio'] * ($descuento / 100);

//Actualizar el registro con los datos POST o los valores actuales
$sent = $pdo->prepare("UPDATE articulos
                        SET codigo = :codigo,
                            descripcion = :descripcion,
                            precio = :precio,
                            descuento = :descuento,
                            cantidad_descuento = :cantidad_descuento,
                            stock = :stock,
                            visible = :visible,
                            categoria_id = :categoria_id
                        WHERE id = :id");
$sent->execute([
    ':id' => $id,
    ':codigo' => $codigo ?: $origin['codigo'],
    ':descripcion' => $descripcion ?: $origin['descripcion'],
    ':precio' => $precio ?: $origin['precio'],
    ':descuento' => $descuento ?: $origin['descuento'],
    ':cantidad_descuento' => $cantidad_descuento ?: $origin['cantidad_descuento'],
    ':stock' => $stock ?: $origin['stock'],
    ':visible' => $visible ?: $origin['visible'],
    ':categoria_id' => $categoria_id ?: $origin['categoria_id']
]);

//Establecer un mensaje de éxito y vuelve a la página de administración
$_SESSION['exito'] = 'El artículo se ha modificado correctamente.';
return volver_admin();
