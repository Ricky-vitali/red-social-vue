<?php
namespace DaVinci\Models;

use DaVinci\DB\DBConnection;
use JsonSerializable;
use PDO;

class Modelo
{
    /** @var string */
    protected $table;
    /** @var string La primary key*/
    protected $pk;
    /** @var array  */
    protected $atributosPermitidos = [];

    /**
     * Retorna todos los registros de la clase.
     *
     * @return array|static[]
     */
    public function todos(){
        $db = DBConnection::getConnection();
        $query = "SELECT * FROM " . $this->table;

        $stmt = $db->prepare($query);
        $stmt->execute();
       
        return  $stmt->fetchAll(PDO::FETCH_CLASS, self::class);

    }

    /**
     * Obtiene un registro en base a la pk provista.
     *
     * @param $pk
     * @return null|static
     */
    public function getByPk($pk){
        $db = DBConnection::getConnection();

        $query = "SELECT * FROM " . $this->table . "
                  WHERE " . $this->pk . " = ?";
        $stmt = $db->prepare($query);
        $stmt->execute([$pk]);

        if($obj = $stmt->fetchObject(static::class)) {
            return $obj;
        }
        return null;
    }

    /**
     * Elimina el registro de la base de datos.
     *
     * @param int $pk
     * @return bool
     * @throws \Exception
     */
    public function eliminar($pk){
        $db = DBConnection::getConnection();
        $query = "DELETE FROM " . $this->table . "
                    WHERE " . $this->pk . " = ?";

        $stmt = $db->prepare($query);
        $exito = $stmt->execute([$pk]);

        if(!$exito) {
            throw new \Exception('El registro no pudo ser eliminado.');
        }

        return true;
    }
}
