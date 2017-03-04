<?php

namespace Usuario\Service;

use Usuario\DAO\UsuarioDAO;
use Usuario\Auth\MiddlewareAuth;

class Usuario
{
    use MiddlewareAuth;

    public function getLogin($strUsuario, $strSenha)
    {
        $usuarioDAO = new UsuarioDAO();
        $arrInfoUsuario = $usuarioDAO->getAutenticacao(
            $strUsuario,
            md5($strSenha)
        );
        if (empty($arrInfoUsuario)) {
            throw new \Exception('Usuário/Senha está incorreta.');
        }
        return $this->getToken($arrInfoUsuario[0]);
    }

    public function getListagem()
    {
        $this->validarToken();
        $usuarioDAO = new UsuarioDAO();
        return $usuarioDAO->getListagem();
    }
}