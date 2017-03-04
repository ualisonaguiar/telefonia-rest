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

    public function adicionar()
    {
        $arrDataUserLogado = $this->validarToken();
        $arrUser = json_decode(file_get_contents('php://input'), true);
        $arrUser['idUsuarioLogado'] = $arrDataUserLogado['id_usuario'];
        $usuario = new UsuarioService();
        $usuario->salvar($arrUser);
        return ['message' => 'Usuário cadastrado com sucesso.'];
    }
}