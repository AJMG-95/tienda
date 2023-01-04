<?php
session_start();

require '../../src/auxiliar.php';

$id = obtener_post('id', FILTER_VALIDATE_INT);

if (empty($id) || $id === false) {
    header('Location: volver_categorias.php');
    exit;
}

$pdo = conectar();

$pdo->beginTransaction();

$sent = $pdo->prepare("SELECT COUNT(categoria)
                        FROM categorias
                        WHERE id = :id
                        AND id NOT in (SELECT categoria_id FROM articulos);");
$sent->execute([':id' => $id]);

if ($sent->fetchColumn() == 0) {
    $_SESSION['error'] = 'La categoria está vinculada a un artículo.';
    $pdo->rollback();
} else {
    $sent = $pdo->prepare("DELETE FROM categorias WHERE id = :id");
    $sent->execute([':id' => $id]);
    $_SESSION['exito'] = 'La categoria se ha borrado correctamente.';
    $pdo->commit();
}

volver_categorias();
