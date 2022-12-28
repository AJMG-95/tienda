<?php

namespace App\Generico;

use App\Tablas\Articulo;
use ValueError;

/**
 * Extiende los Métodos de la clase Modelo desde ../Tablas/Modelo.php
 * Importa la clase Articulo desde ../Tablas/Articulo.php en el espacio de nombre App\Tablas\Articulo
 * Importa la clase ValueError que a su vez extiende la clase Error que es una clase base de php
 */
class Carrito extends Modelo
{
    private array $lineas;

    public function __construct()
    {
        $this->lineas = [];
    }

    /**
     * @param mixed $id
     *
     * @return [type]
     */
    public function insertar($id)
    {
        if (!($articulo = Articulo::obtener($id))) {
            throw new ValueError('El artículo no existe.');
        }

        if (isset($this->lineas[$id])) {
            $this->lineas[$id]->incrCantidad();
        } else {
            $this->lineas[$id] = new Linea($articulo);
        }
    }

    /**
     * Decrementa la cantidad de un producto en el carrito y lo eliina si la cantidad de
     * de este es == 0
     *
     * @param mixed $id
     *
     */
    public function eliminar($id)
    {
        if (isset($this->lineas[$id])) {
            $this->lineas[$id]->decrCantidad();
            if ($this->lineas[$id]->getCantidad() == 0) {
                unset($this->lineas[$id]);
            }
        } else {
            throw new ValueError('Artículo inexistente en el carrito');
        }
    }

    /**
     * [Description for vacio]
     *
     * @return bool
     *
     */
    public function vacio(): bool
    {
        return empty($this->lineas);
    }


    /**
     * [Description for getLineas]
     *
     * @return array
     *
     */
    public function getLineas(): array
    {
        return $this->lineas;
    }


    /**
     * [Description for getIds]
     *
     * @return array
     *
     */
    public function getIds(): array
    {
        return array_keys($this->lineas);
    }

    /**
     * [Description]
     *
     * [Description for getLinea]
     *
     * @param mixed $id
     *
     * @return Linea Object
     *
     */
    public function getLinea($id): Linea
    {
        return $this->lineas[$id];
    }
}
