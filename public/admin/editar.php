<?php
session_start()
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <script>
        function cambiar(el, id) {
            el.preventDefault();
            const oculto = document.getElementById('oculto');
            oculto.setAttribute('value', id);
        }
    </script>
    <title>Listado de artículos</title>
</head>

<body>
    <?php
    require '../../src/auxiliar.php';

    $id = obtener_post('id');
    $codigo = obtener_get('codigo');
    $descripcion = obtener_get('descripcion');
    $precio = obtener_get('precio');
    $error = ['descripcion' => [], 'precio' => []];
    $clases_label = [];
    $clases_input = [];

    ?>
    <div class="container mx-auto">
        <form action="" method="get">
            <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
                <label>
                    descripcion:
                    <input type="text" name="descripcion">
                </label>
            </div>
            <div id="popup-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 md:inset-0 h-modal md:h-full">
                <label>
                    precio:
                    <input type="text" name="precio">
                </label>
            </div>
            <div>
                <a href="index.php" target="_blank">
                    <button type="submit" class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">Usuarios</button>
                </a>
            </div>
        </form>
    </div>
    <?php

    $pdo = conectar();


    if (isset($precio)) {
        if (mb_strlen($precio) > 7 || mb_strlen($precio) < 1) {
            $error['precio'][] = 'Debe ser un digito de entre 1 y 7 caracteres';
        }
    } else {
        $sent = $pdo->prepare("SELECT precio FROM articulos WHERE id = :id");
        $sent->execute([':id' => $id]);
        $precio = $sent->fetch();
    }

    if (isset($descripcion)) {
        if (mb_strlen($descripcion) > 255 || mb_strlen($descripcion) < 1) {
            $error['descripcion'][] = 'Debe ser una cadena entre 1 y 255 caracteres';
        }
    } else {
        $sent = $pdo->prepare("SELECT descripcion FROM articulos WHERE id = :id");
        $sent->execute([':id' => $id]);
        $descripcion = $sent->fetch();
    }

    $vacio = true;

    foreach ($error as $err) {
        if (!empty($err)) {
            $vacio = false;
            break;
        }
    }

    if ($vacio) {
        $sent = $pdo->prepare("UPDATE articulos
                                SET descripcion = :descripcion,
                                    precio = :precio
                                WHERE id = :id");
        $sent->execute([
            ':id' => $id,
            ':descripcion' => $descripcion,
            ':precio' => implode('.', $precio)
        ]);

        $_SESSION['exito'] = 'El artículo se ha modificado correctamente.';
    } else {
        foreach (['descripcion', 'precio'] as $e) {
            if (isset($error[$e])) {
                $clases_input[$e] = $clases_input_error;
                $clases_label[$e] = $clases_label_error;
            }
        }
    }
    ?>


</body>

</html>

<script src="/js/flowbite/flowbite.js"></script>
</body>

</html>
