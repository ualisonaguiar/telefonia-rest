<?php

namespace Usuario\Entity;

use Usuario\Entity\Conexao;

class UsuarioEntity
{
    use Conexao;

    public function efetuarLogin($strLogin, $strSenha)
    {
        $strQuery = 'select * from tb_usuario where login = :ds_login and senha = :ds_password';
        $connection = self::getConection();
        $query = $connection->prepare($strQuery);
        $query->execute([
            'ds_login' => $strLogin,
            'ds_password' => $strSenha
        ]);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}