<?php

namespace App\Tablas;

use PDO;

/**
 * Se accede a los campos de la tabla articulos, que son las propidades del objeto Articulo
 * Extiende los Métodos de la clase Modelo desde ../Tablas/Modelo.php
 */
class Articulo extends Modelo
{
    protected static string $tabla = 'articulos';

    public $id;
    private $codigo;
    private $descripcion;
    private $precio;
    private $stock;


    /**
     *
     * @param array $campos
     *
     */
    public function __construct(array $campos)
    {
        $this->id = $campos['id'];
        $this->codigo = $campos['codigo'];
        $this->descripcion = $campos['descripcion'];
        $this->precio = $campos['precio'];
        $this->stock = $campos['stock'];
    }


    /**
     *
     * @param int $id
     * @param PDO|null $pdo
     *
     * @return static|null
     *
     * devuevle una llamada a la función obtener o null
     * función obtener en ../Tablas/Modelo.php
     *
     */
    public static function existe(int $id, ?PDO $pdo = null): bool
    {
        return static::obtener($id, $pdo) !== null;
    }


    /**
     * [Description for getCodigo]
     *
     * @return string
     *
     */
    public function getCodigo()
    {
        return $this->codigo;
    }


    /**
     * [Description for getDescripcion]
     *
     * @return string
     *
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }


    /**
     * [Description for getPrecio]
     *
     * @return float
     *
     */
    public function getPrecio()
    {
        return $this->precio;
    }


    /**
     * [Description for getStock]
     *
     * @return int
     *
     */
    public function getStock()
    {
        return $this->stock;
    }
}
