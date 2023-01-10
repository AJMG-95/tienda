<?php

/**
 * @return [type]
 */
function conectar()
{
    return new \PDO('pgsql:host=localhost,dbname=tienda', 'tienda', 'tienda');
}


/**
 * @param mixed $x
 *
 * @return [string]
 */
function hh($x)
{
    return htmlspecialchars($x ?? '', ENT_QUOTES | ENT_SUBSTITUTE);
}


/**
 * @param mixed $s
 *
 * @return [string]
 */
function dinero($s)
{
    return number_format($s, 2, ',', ' ') . ' €';
}


/**
 * @param mixed $par
 *
 * @return [string|null]
 */
function obtener_get($par)
{
    return obtener_parametro($par, $_GET);
}


/**
 * @param mixed $par
 *
 * @return [string|null]
 */
function obtener_post($par)
{
    return obtener_parametro($par, $_POST);
}


/**
 * @param mixed $par
 * @param mixed $array
 *
 * @return [string|null]
 */
function obtener_parametro($par, $array)
{
    return isset($array[$par]) ? trim($array[$par]) : null;
}


/**
 * @return [type]
 */
function volver()
{
    header('Location: /index.php');
}


/**
 * @return [string]
 */
function carrito()
{
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = serialize(new \App\Generico\Carrito());
    }

    return $_SESSION['carrito'];
}


/**
 * @return [object]
 */
function carrito_vacio()
{
    $carrito = unserialize(carrito());

    return $carrito->vacio();
}


/**
 * @return [type]
 */
function volver_admin()
{
    header("Location: /admin/");
}


/**
 * @return [type]
 */
function redirigir_login()
{
    header('Location: /login.php');
}

function volver_categorias()
{
    header("Location: /admin/categorias.php");
}


function volver_a($location)
{
    header("Location: " . $location);
}
