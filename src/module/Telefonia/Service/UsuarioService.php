<?php

namespace Telefonia\Service;

use Telefonia\Entity\UsuarioEntity;
use Telefonia\Service\JWTManager;

class UsuarioService
{
    public function efetuarLogin($strLogin, $strSenha)
    {
        try {
            $usuarioEntity = new UsuarioEntity();
            $arrResult = $usuarioEntity->efetuarLogin($strLogin, md5($strSenha));
            if (!$arrResult) {
                throw new \Exception('Credenciais invalidas.');
            }
            $jwtManager = new JWTManager();
            return $jwtManager->gerarToken($arrResult);
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}

?>