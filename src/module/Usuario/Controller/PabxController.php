<?php

namespace Usuario\Controller;

use Slim\Http\Request as RequestSlim;
use Slim\Http\Response as ResponseSlim;
use Usuario\Service\PINService;

class PabxController
{
    public function adicionar(RequestSlim $request, ResponseSlim $response, $args = null)
    {
        try {
            $arrDataPost = $request->getParams();
            $pinService = new PINService();
            $pinService->adicionar($arrDataPost);
            $response->write(json_encode([
                'status' => true,
                'message' => 'Registro inserido com sucesso'
            ]))
                ->withAddedHeader('Content-Type', 'application/json');
        } catch(\Exception $exception) {
            $response = $response->withStatus(500, $exception->getMessage());
        }
        $response = $response->withAddedHeader('Content-Type', 'application/json');
        return $response;
    }

    public function adicionarLote(RequestSlim $request, ResponseSlim $response, $args = null)
    {
        try {
            $arrDataPost = $request->getParams();
            $pinService = new PINService();
            $pinService->adicionarLote($arrDataPost);
            $response->write(json_encode([
                'status' => true,
                'message' => 'Registro inserido com sucesso'
            ]))
                ->withAddedHeader('Content-Type', 'application/json');
        } catch(\Exception $exception) {
            $response = $response->withStatus(500, $exception->getMessage());
        }
        $response = $response->withAddedHeader('Content-Type', 'application/json');
        return $response;
    }
}