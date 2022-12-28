<?php

namespace App\Generico;

use App\Tablas\Articulo;

/**
 * Extiende los Métodos de la clase Modelo desde ../Tablas/Modelo.php
 * Importa la clase Articulo desde ../Tablas/Articulo.php en el espacio de nombre App\Tablas\Articulo
 */
class Linea extends Modelo
{
    private Articulo $articulo;
    private int $cantidad;

    /**
     * @param Articulo $articulo
     * @param int $cantidad
     *
     */
    public function __construct(Articulo $articulo, int $cantidad = 1)
    {
        $this->setArticulo($articulo);
        $this->setCantidad($cantidad);
    }


    /**
     * @return Articulo Object
     *
     */
    public function getArticulo(): Articulo
    {
        return $this->articulo;
    }


    /**
     * Asigna el valor de la variable $articulo a la propiedas $this->articulo
     *
     * @param Articulo $articulo
     *
     */
    public function setArticulo(Articulo $articulo)
    {
        $this->articulo = $articulo;
    }


    /**
     *
     * @return int
     *
     */
    public function getCantidad(): int
    {
        return $this->cantidad;
    }


    /**
     * Asigna el valor de la variable $cantidad a la propiedas $this->cantidad
     *
     * @param int $cantidad
     *
     */
    public function setCantidad(int $cantidad)
    {
        $this->cantidad = $cantidad;
    }


    /**
     * Incrementa el valor de la propiedad $this->cantidad en 1
     *
     */
    public function incrCantidad()
    {
        $this->cantidad++;
    }


    /**
     * Decrementa el valor de la propiedad $this->cantidad en 1
     *
     */
    public function decrCantidad()
    {
        $this->cantidad--;
    }
}
