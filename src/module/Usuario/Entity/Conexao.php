<?php

namespace Usuario\Entity;

use Symfony\Component\Yaml\Yaml;

trait Conexao
{
    private static $conection;

    public function getConection()
    {
        if (!self::$conection) {
            $arrParameters = Yaml::parse(file_get_contents(realpath(__DIR__) . '/../../../config.yml'))['config']['db'];
            self::$conection = new \PDO(
                $arrParameters['type'] . ':dbname=' . $arrParameters['dbname'] . ';host=' . $arrParameters['host'],
                $arrParameters['user'],
                $arrParameters['password']
            );
            //$pdoConnection = $this->getConnectionPgSQL();
            self::$conection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$conection;
    }
}