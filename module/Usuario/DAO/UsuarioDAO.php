<?php

namespace Usuario\DAO;

use Usuario\DAO\AbstractConexao;

class UsuarioDAO extends AbstractConexao
{
    public function getListagem()
    {
        $strSQL = 'select * from tb_usuario';
        $connection = self::getConection();
        $query = $connection->prepare($strSQL);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getAutenticacao($strUsuario, $strSenha)
    {
        $strSQL = 'select * from tb_usuario where ds_login = :dsLogin and ds_senha = :dsSenha';
        $connection = self::getConection();
        $query = $connection->prepare($strSQL);
        $query->execute([
            'dsLogin' => $strUsuario,
            'dsSenha' => $strSenha,
        ]);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}