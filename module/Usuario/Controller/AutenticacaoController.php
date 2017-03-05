<?php
/**
 * Created by PhpStorm.
 * User: ualison
 * Date: 03/03/17
 * Time: 22:14
 */

namespace Usuario\Controller;

use Usuario\Service\Usuario as UsuarioService;
use Usuario\Controller\UtilController;

class AutenticacaoController
{
    use UtilController;

    public function login()
    {
        $dataLogin = $this->getDataPost();
        $usuarioService = new UsuarioService();
        $strToken = $usuarioService->getLogin(
            $dataLogin['usuario'],
            $dataLogin['senha']
        );
        return ['token' => $strToken];
    }
}