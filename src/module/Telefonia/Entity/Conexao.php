<?php

namespace Telefonia\Entity;

use Symfony\Component\Yaml\Yaml;

trait Conexao
{
    private static $conection;

    public function getConection()
    {
        if (!self::$conection) {
            $strFile = realpath(__DIR__) . '/../../../../config.yml';
            $arrParameters = Yaml::parse(file_get_contents($strFile))['config']['db'];
            self::$conection = new \PDO(
                $arrParameters['type'] . ':dbname=' . $arrParameters['dbname'] . ';host=' . $arrParameters['host'],
                $arrParameters['user'],
                $arrParameters['password']
            );
            self::$conection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        return self::$conection;
    }
}