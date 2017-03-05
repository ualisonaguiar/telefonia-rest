<?php
/**
 * Created by PhpStorm.
 * User: ualison
 * Date: 03/03/17
 * Time: 22:14
 */

namespace Usuario\Controller;

use Usuario\Service\Usuario as UsuarioService;

class AutenticacaoController
{
    public function login()
    {
        $dataLogin = json_decode(file_get_contents('php://input'), true);
        var_dump($dataLogin);
        die;
        $usuarioService = new UsuarioService();
        $strToken = $usuarioService->getLogin(
            $dataLogin['usuario'],
            $dataLogin['senha']
        );
        return ['token' => $strToken];
    }
}