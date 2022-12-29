<?php
session_start();

require "../../src/auxiliar.php";

// Sanitize user input
$code = hh($_POST['codigo'], ENT_QUOTES, 'UTF-8');
$description = hh($_POST['descripcion'], ENT_QUOTES, 'UTF-8');
$price = filter_input(INPUT_POST, 'precio', FILTER_SANITIZE_NUMBER_FLOAT);
$stock = filter_input(INPUT_POST, 'stock', FILTER_SANITIZE_NUMBER_INT);

// Validate user input
if (!$code || !$description || !$price || !$stock) {
    $_SESSION['error'] = 'Invalid input. Please try again.';
    return volver_admin();
}

try {
    // Connect to database
    $pdo = conectar();

    // Prepare and execute INSERT statement
    $stmt = $pdo->prepare("INSERT INTO articulos (codigo, descripcion, precio, stock) VALUES (:code, :description, :price, :stock)");
    $stmt->execute([
        ':code' => $code,
        ':description' => $description,
        ':price' => $price,
        ':stock'  => $stock
    ]);

    // Set success message
    $_SESSION['success'] = 'The article was added successfully.';

} catch (PDOException $e) {
    // Set error message
    $_SESSION['error'] = 'An error occurred while adding the article. Please try again.';
}

return volver_admin();
