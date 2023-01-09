<?php

session_start();

require '../../src/auxiliar.php';

$pdo = conectar();

// Obtener el id del producto y el porcentaje de descuento del usuario
$id = obtener_post('id');
$rebaja = obtener_post('rebaja');

// Calcular el nuevo precio del producto
$sent = $pdo->prepare("SELECT precio FROM articulos WHERE id = :product_id");
$sent->execute(['product_id' => $product_id]);
$linea = $sent->fetch(PDO::FETCH_ASSOC);
$precio_inicial = $linea['precio'];
$cantidad_descuento = $precio_inicial * ($porcentaje_descuento / 100);
$nuevo_precio = $precio_inicial - $cantidad_descuento;

// Actualizar el precio del producto en la base de datos
$sent = $pdo->prepare("UPDATE articulos SET precio = :nuevo_precio WHERE id = :product_id");
$resultado = $sent->execute(['nuevo_precio' => $nuevo_precio, 'product_id' => $product_id]);
if ($resultado) {
    $_SESSION['exito'] = 'Se ha aplicado correctamente el descuento al producto.';
} else {
    $_SESSION['exito'] = 'Error al aplicar el descuento al producto.';
}

return volver_admin();