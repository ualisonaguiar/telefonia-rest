<?php

namespace Sms\Controller;

use Slim\Http\Request as RequestSlim;
use Slim\Http\Response as ResponseSlim;
use Sms\Service\Sms as SmsService;

class EnvioSms
{
    public function listagem(RequestSlim $request, ResponseSlim $response, $next = null)
    {
        $smsService = new SmsService();
		
        $arrDataPost = array('id_cliente' => $this->getIdCliente($request));
			
        if ($request->getAttribute('terminal')) {
            $arrDataPost['terminal'] = $request->getAttribute('terminal');
        }
		
        try {
            return json_encode(array('data' => $smsService->listagem($arrDataPost)));
        } catch (\Exception $exception) {
            return $response->withStatus(500, $exception->getMessage());
        }
    }

    public function salvar(RequestSlim $request, ResponseSlim $response, $next = null)
    {
        $smsService = new SmsService();
        $arrDataPost = $request->getParams();
        $arrDataPost['id_cliente'] = $this->getIdCliente($request);
        $arrResult = $smsService->salvar($arrDataPost);
        $intCodeStatus = 200;
        if (!$arrResult['status']) {
            $intCodeStatus = 500;
        }
		
		$msg = urlencode($arrDataPost['text']); 
		
		$url = "https://www.minutosms.com.br/cobrahttp/?user=mqbbprod&pass=mqbbpass&source_addr=$arrDataPost[from]&international=0&destination_addr=$arrDataPost[to]&message=$msg&priority=0&delivrd=1";
		// $url;
		file_get_contents($url);
		
        return $response->withStatus($intCodeStatus)->write($arrResult['message']);
    }

    public function excluir(RequestSlim $request, ResponseSlim $response, $next = null)
    {
        $smsService = new SmsService();
        $arrDataPost = $request->getParams();
        $arrDataPost['id_cliente'] = $this->getIdCliente($request);
        $arrResult = $smsService->excluir($arrDataPost);
        $intCodeStatus = 200;
        if (!$arrResult['status']) {
            $intCodeStatus = 500;
        }
        return $response->withStatus($intCodeStatus)->write($arrResult['message']);
    }

    private function getIdCliente($request)
    {
        return $request->getAttribute('id_cliente');
    }
}