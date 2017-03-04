<?php

namespace Usuario\Controller;

use Usuario\Service\Usuario as UsuarioService;
use Usuario\Auth\MiddlewareAuth;

class UsuarioController
{
    use MiddlewareAuth;

    public function index()
    {
        $this->validarToken();
        $usuario = new UsuarioService();
        $arrResult = $usuario->getListagem();
        return ['data' => $arrResult];
    }
}