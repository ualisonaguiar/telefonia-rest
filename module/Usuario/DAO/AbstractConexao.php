<?php

namespace Usuario\DAO;

abstract class AbstractConexao
{
    private static $conection;

    public static function getConection()
    {
        if (!isset(self::$conection)) {
            //self::$conection = new \PDO("pgsql:dbname=poc_sms;host=127.0.0.1:5433", 'postgres', 'abcd1234');
            self::$conection = new \PDO(
                'mysql:host=192.168.0.105;dbname=poc_usuario',
                'root',
                'abcd1234',
                [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
            );
            self::$conection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);;
        }
        return self::$conection;
    }
}