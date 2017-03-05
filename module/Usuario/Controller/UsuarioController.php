<?php

namespace Usuario\Controller;

use Usuario\Service\Usuario as UsuarioService;
use Usuario\Auth\MiddlewareAuth;
use Usuario\Controller\UtilController;

class UsuarioController
{
    use MiddlewareAuth,
        UtilController;

    protected $arrDataUser;

    public function __construct()
    {
        $this->arrDataUser = $this->validarToken();
    }

    public function index()
    {
        $usuario = new UsuarioService();
        $arrResult = $usuario->getListagem();
        return ['data' => $arrResult];
    }

    public function adicionar()
    {
        $arrUser = $this->getDataPost();
        $arrUser['id_usuario_cadastrado'] = $this->arrDataUser['id_usuario'];
        $usuario = new UsuarioService();
        $usuario->salvar($arrUser);
        return ['message' => 'Usuário cadastrado com sucesso.'];
    }

    public function alterar()
    {
        $arrUser = $this->getDataPost();
        $arrUser['id_usuario_cadastrado'] = $this->arrDataUser['id_usuario'];
        $usuario = new UsuarioService();
        $usuario->salvar($arrUser);
        return ['message' => 'Usuário alterado com sucesso.'];
    }

    public function excluir()
    {
        $arrUser = $this->getDataPost();
        $usuario = new UsuarioService();
        $usuario->excluir($arrUser['id_usuario']);
        return ['message' => 'Usuário excluído com sucesso.'];
    }
}