<?php
/**
 * Created by PhpStorm.
 * User: ualison
 * Date: 17/08/16
 * Time: 23:40
 */

namespace Usuario\Entity;

trait Conexao
{
    private static $conection;

    public function getConection()
    {
        if (!self::$conection) {
            self::$conection = new \PDO("pgsql:dbname=poc_sms;host=localhost", 'postgres', 'abcd1234');
            //$pdoConnection = $this->getConnectionPgSQL();
            self::$conection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$conection;
    }
}