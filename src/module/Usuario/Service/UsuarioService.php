<?php

namespace Usuario\Service;

use Usuario\Entity\UsuarioEntity;
use Usuario\Service\JWTManager;

class UsuarioService
{
    public function efetuarLogin($strLogin, $strSenha)
    {
        try {
            $usuarioEntity = new UsuarioEntity();
            $arrResult = $usuarioEntity->efetuarLogin($strLogin, md5($strSenha));
            if (!$arrResult) {
                throw new \Exception('Usuário/Senha informado incorreto.');
            }
            $jwtManager = new JWTManager();
            return $jwtManager->gerarToken($arrResult);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}