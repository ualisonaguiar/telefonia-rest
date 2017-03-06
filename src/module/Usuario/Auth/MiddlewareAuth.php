<?php

namespace Usuario\Auth;

use Slim\Http\Request as RequestSlim;
use Slim\Http\Response as ResponseSlim;
use Firebase\JWT\JWT;
use Usuario\Service\JWTManager;

class MiddlewareAuth
{
    public function __invoke(RequestSlim $request, ResponseSlim $response, $next)
    {
        try {
            $strRoute = substr($request->getUri()->getPath(), 1);
            if ($strRoute == 'solicitar-token' || $strRoute == '') {
                return $next($request->withAttribute(), $response);
            }
            $arrHeader = $request->getHeaders();;
            $strToken = $arrHeader['HTTP_AUTHORIZATION'][0];
            if (!$strToken) {
                throw new \Exception('Token não localizado');
            }
            $arrDataToken = (new JWTManager())->getInformacaoToken($strToken);
            $this->validarTempToken($arrDataToken['exp']);
            $response = $next($request->withAttribute('usuario_logado', $arrDataToken), $response);
        } catch(\Exception $exception) {
            $response = $response->withStatus(406)
                ->write(json_encode([
                    'status' => false,
                    'message' => $exception->getMessage()
                ]))
                ->withAddedHeader('Content-Type', 'application/json');
        }
        return $response;
    }


    /**
     * Metodo responsavel por validar o tempo do token
     *
     * @param $intTemp
     * @throws \Exception
     */
    private function validarTempToken($intTemp)
    {
        $intTempCurrent = round(microtime(true) * 1000);
        if ($intTempCurrent > $intTemp) {
            throw new \Exception('Token expirado');
        }
    }
}