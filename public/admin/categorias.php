<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="/css/output.css" rel="stylesheet">
    <script>
        function cambiar_categoria(el, id) {
            el.preventDefault();
            const oculto_categoria = document.getElementById('oculto_categoria');
            oculto_categoria.setAttribute('value', id);
        }

        function cambiarModificar_categoria(el, id) {
            el.preventDefault();
            const ocultoModificar_categoria = document.getElementById('ocultoModificar_categoria');
            ocultoModificar_categoria.setAttribute('value', id);
        }
    </script>
    <title>Listado de categorias</title>
</head>

<body>
    <?php
    require '../../vendor/autoload.php';

    if ($usuario = \App\Tablas\Usuario::logueado()) {
        if (!$usuario->es_admin()) {
            $_SESSION['error'] = 'Acceso no autorizado.';
            return volver();
        }
    } else {
        return redirigir_login();
    }

    $pdo = conectar();


    $sent = $pdo->query("SELECT * FROM categorias");
    ?>
    <div class="container mx-auto">
        <?php require '../../src/_menu.php' ?>
        <?php require '../../src/_alerts.php' ?>
        <?php require_once '../../src/_models.php' ?>
        <div class="overflow-x-auto relative mt-4">
            <a href="index.php" target="_blank">
                <button class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 mr-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900">Artículos</button>
            </a>
            <button data-modal-toggle="insertar_categoria" href="/admin/insertar_categoria.php" class="focus:outline-none text-white bg-green-700 hover:bg-green-800 focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-4 py-2 mr-2 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-900">
                <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-green dark:bg-gray-900 rounded-md group-hover:bg-opacity-0">
                    Insertar categoria
                </span>
            </button>
            <table class="mx-auto text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <th scope="col" class="py-3 px-6">Categorias</th>
                    <th scope="col" class="py-3 px-6 text-center">Acciones</th>
                </thead>
                <tbody>
                    <?php foreach ($sent as $fila) : ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                            <td class="py-4 px-6"><?= hh($fila['categoria']) ?></td>
                            <td class="px-6 text-center">
                                <?php $fila_id = hh($fila['id']) ?>
                                <form action="/admin/modificar_categoria.php" method="POST" class="inline">
                                    <input type="hidden" name="id" value="<?= $fila_id ?>">
                                    <button type="submit" onclick="cambiarModificar_categoria(event, <?= $fila_id ?>)" class="focus:outline-none text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-900" data-modal-toggle="modificar_categoria">
                                        Editar
                                    </button>
                                </form>
                                <form action="/admin/borrar_categoria.php" method="POST" class="inline">
                                    <input type="hidden" name="id" value="<?= $fila_id ?>">
                                    <button type="submit" onclick="cambiar_categoria(event, <?= $fila_id ?>)" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900" data-modal-toggle="borrar">Borrar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="/js/flowbite/flowbite.js"></script>
</body>

</html>
