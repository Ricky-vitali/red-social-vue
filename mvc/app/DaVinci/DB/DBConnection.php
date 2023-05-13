<?php

namespace DaVinci\DB;
use PDO;

class DBConnection
{
    /** @var null|PDO Propiedad estática para almacenar la instancia de PDO que vamos a crear. */
    private static $db = null;
    private function __construct() {}

    /**
     * Retorna la instancia PDO de la conexión a la base de datos.
     *
     * @return PDO
     * @throws \PDOException
     */
    public static function getConnection()
    {
        // Si no tengo todavía la conexión creada, la creamos.
        if(self::$db === null) {
            $db_host = "localhost";
            $db_user = "root";
            $db_pass = "";
            $db_base = "social";
            $db_dsn = "mysql:host={$db_host};dbname={$db_base};charset=utf8mb4";
            self::$db = new PDO($db_dsn, $db_user, $db_pass);
        }

        return self::$db;
    }
}
