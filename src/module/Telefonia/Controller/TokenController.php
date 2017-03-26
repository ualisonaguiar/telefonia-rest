<?php

namespace Telefonia\Controller;

use Slim\Http\Request as RequestSlim;
use Slim\Http\Response as ResponseSlim;
use Telefonia\Service\UsuarioService;

class TokenController
{
    public function index(RequestSlim $request, ResponseSlim $response, $args = null)
    {
        try {
            $arrPost = $request->getParams();
            $usuarioService = new UsuarioService();
            $strToken = $usuarioService->efetuarLogin($arrPost['login'], $arrPost['senha']);
            return $response->withJson(['token' => $strToken, 'status' => true], 200);
        } catch(\Exception $exception) {
            return $response->withJson(['message' => $exception->getMessage(), 'status' => false], 500);
        }
    }
}

?>
