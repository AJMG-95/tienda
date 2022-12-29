<?php
session_start();

require '../../src/auxiliar.php';

$id = obtener_post('id');
$codigo = obtener_post('codigo');
$descripcion = obtener_post('descripcion');
$precio = obtener_post('precio');
$precio = obtener_post('stock');

$pdo = conectar();
$set = [];
$execute = [];
$where = [];

$sent = $pdo->prepare("SELECT codigo, descripcion, precio, stock FROM articulos WHERE id = :id");
$sent->execute([':id' => $id]);
$origin = $sent->fetch(PDO::FETCH_ASSOC);
var_dump($origin);
print_r($origin);

if (!isset($id)) {
    return volver_admin();
} else {
    $where[] = 'id = :id';
    $execute[':id'] = $id;
}

if (isset($codigo) && $codigo != '') {
    $set[] = 'codigo = :codigo';
    $execute[':codigo'] = $codigo;
} else {
    $set[] = 'codigo = :codigo';
    $execute[':codigo'] = $origin['codigo'];
}

if (isset($descripcion) && $descripcion != '' && mb_strlen($descripcion) < 255) {
    $set[] = 'descripcion = :descripcion';
    $execute[':descripcion'] = $descripcion;
} else {
    $set[] = 'descripcion = :descripcion';
    $execute[':descripcion'] = $origin['descripcion'];
}

if (isset($precio) && $precio != '' && mb_strlen($precio) < 7) {
    $set[] = 'precio = :precio';
    $execute[':precio'] = $precio;
} else {
    $set[] = 'precio = :precio';
    $execute[':precio'] = $origin['precio'];
}

if (isset($stock) && $stock != '') {
    $set[] = 'stock = :stock';
    $execute[':stock'] = $stock;
} else {
    $set[] = 'stock = :stock';
    $execute[':stock'] = $origin['stock'];
}


$set = !empty($set) ? 'SET ' . implode(' , ', $set) : '';
$where = !empty($where) ? 'WHERE ' . implode('', $where) : '';

$sent = $pdo->prepare("UPDATE articulos
                            $set
                            $where");

$sent->execute($execute);



$_SESSION['exito'] = 'El artículo se ha modificado correctamente.';

return volver_admin();
