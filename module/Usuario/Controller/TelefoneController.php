<?php

namespace Usuario\Controller;

use Usuario\Auth\MiddlewareAuth;
use Usuario\Controller\UtilController;
use Usuario\Service\Telefone;

class TelefoneController
{
    use MiddlewareAuth,
        UtilController;

    protected $arrDataUser;

    public function __construct()
    {
        $this->arrDataUser = $this->validarToken();
    }

    public function adicionar()
    {
        try {
            $arrDataPost = $this->getDataPost();
            $arrDataPost['id_usuario'] = $this->arrDataUser['id_usuario'];
            $telefoneService = new Telefone();
            $telefoneService->cadastrar($arrDataPost);
            return ['message' => 'Registro cadastrado com sucesso.'];
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function adicionarEmLote()
    {
        try {
            $arrDataPost = $this->getDataPost();
            $telefoneService = new Telefone();
            $telefoneService->cadastrarLote($arrDataPost, $this->arrDataUser['id_usuario']);
            return ['message' => 'Registro cadastrado com sucesso.'];
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}