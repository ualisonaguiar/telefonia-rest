<?php

namespace Telefonia\Controller;

use Slim\Http\Request as RequestSlim;
use Slim\Http\Response as ResponseSlim;
use Telefonia\Service\PINService;

class PabxController
{
    public function salvar(RequestSlim $request, ResponseSlim $response, $args = null)
    {
        try {
            $arrDataPost = $request->getParams();
            $pinService = new PINService();
            $strReturn = $pinService->salvar($arrDataPost);
            $response->write(json_encode([
                'status' => true,
                'message' => 'Registro ' . $strReturn . ' com sucesso'
            ]))
                ->withAddedHeader('Content-Type', 'application/json');
        } catch (\Exception $exception) {
            $response = $response->withStatus(500, $exception->getMessage());
        }
        $response = $response->withAddedHeader('Content-Type', 'application/json');
        return $response;
    }

    public function salvarLote(RequestSlim $request, ResponseSlim $response, $args = null)
    {
        try {
            $arrDataPost = $request->getParams();
            $pinService = new PINService();
            $pinService->salvarLote($arrDataPost);
            $response->write(json_encode([
                'status' => true,
                'message' => 'Registro persistido com sucesso'
            		
            ]))
                ->withAddedHeader('Content-Type', 'application/json');
        } catch (\Exception $exception) {
            $response = $response->withStatus(500, $exception->getMessage());
        }
        $response = $response->withAddedHeader('Content-Type', 'application/json');
        return $response;
    }
}

?>
