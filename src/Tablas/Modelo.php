<?php

namespace App\Tablas;

use PDO;

class Modelo
{
    protected static string $tabla;

    /**
     * Recibe un id y una conexion a la base de datos opcional,
     * si no recibe la conexion a la base de datos la crea.
     * Toma una variable estatica $tabla y ejecuta una consulta sobre la tabla
     * usando como condición WHERE el id proporcionado.
     * Devuelve la fila de la tabla cuyo id sea igual al proporcionado (array asociativo) o null
     *
     * @param int $id
     * @param PDO|null $pdo
     *
     * @return static|null $fila|null
     *
     * static es una variable estática
     *
     */
    public static function obtener(int $id, ?PDO $pdo = null): ?static
    {
        $pdo = $pdo ?? conectar();
        $tabla = static::$tabla;
        $sent = $pdo->prepare("SELECT *
                                 FROM $tabla
                                WHERE id = :id");
        $sent->execute([':id' => $id]);
        $fila = $sent->fetch(PDO::FETCH_ASSOC);

        return $fila ? new static($fila) : null;
    }


    /**
     * Devuelve todas las filas que cumplan las condiciones especificadas en el arrary $where
     * que se le ha pasado como argumento. (array de arrays asociativos)
     * Con el execute asocia las variables a los nombres de los campos de la tabla.
     *
     * @param array $where
     * @param array $execute
     * @param PDO|null $pdo
     *
     * @return array
     *
     */
    public static function todos(
        array $where = [],
        array $execute = [],
        ?PDO $pdo = null
    ): array
    {
        $pdo = $pdo ?? conectar();
        $tabla = static::$tabla;
        $where = !empty($where)
            ? 'WHERE ' . implode(' AND ', $where)
            : '';
        $sent = $pdo->prepare("SELECT * FROM $tabla $where");
        $sent->execute($execute);
        $filas = $sent->fetchAll(PDO::FETCH_ASSOC);
        $res = [];
        foreach ($filas as $fila) {
            $res[] = new static($fila);
        }
        return $res;
    }
}
