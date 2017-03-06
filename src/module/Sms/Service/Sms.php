<?php

namespace Sms\Service;

use Sms\Entity\Sms as SmEntity;

class Sms
{
    public function listagem($arrDataPost)
    {	
        try {
            $smsEntity = new SmEntity();
            $arrResult = $smsEntity->listagem($arrDataPost);
            return $arrResult;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }

    public function salvar($arrDataPost)
    {
        try {
            $smsEntity = new SmEntity();
            $smsEntity->getConection()->beginTransaction();
            if (!$arrDataPost) {
                throw new \Exception('Não veio preenchidos as informações do SMS.');
            }
			
            $this->validaRegistro($arrDataPost);
           
            $arrInfoSms = array(
                'id_cliente' => $arrDataPost['id_cliente'],
                'nu_telefone' => $arrDataPost['to'],
                'ds_mensagem' => $arrDataPost['text'],
                'tp_situacao' => $smsEntity::CO_SITUACAO_AGUARANDO_ENVIO,
                'ds_destinatario' => $arrDataPost['from'],
				'dat_cadastro' => date('Y-m-d H:i:s')
            );
			
			$smsEntity->insert($arrInfoSms);
            
            $smsEntity->getConection()->commit();
            return array(
                'status' => true,
                'message' => 'SMS salvo com sucesso.'
            );
        } catch (\Exception $exception) {
            $smsEntity->getConection()->rollBack();
            return array(
                'status' => false,
                'message' => $exception->getMessage()
            );
        }
    }

    public function excluir($arrDataPost)
    {
        try {
            $smsEntity = new SmEntity();
            $smsEntity->getConection()->beginTransaction();
            $arrResultado = $arrSms = $this->listagem($arrDataPost);
            if (!$arrResultado) {
                throw new \Exception('Registro não encontrado');
            }
            $smsEntity->excluir($arrDataPost);
            $smsEntity->getConection()->commit();
            return array(
                'status' => true,
                'message' => 'SMS excluído com sucesso.'
            );
        } catch (\Exception $exception) {
            $smsEntity->getConection()->rollBack();
            return array(
                'status' => false,
                'message' => $exception->getMessage()
            );
        }
    }

    protected function validaRegistro($arrData)
    {
        $arrError = array();
        unset($arrData['id_cliente']);
        if (!$arrData) {
            throw new \Exception('Não foram encontrados informações sobre dados do sms.');
        }
		
        foreach ($arrData as $strIndice => $strValue) {
            if (!trim($strValue) && strlen($strValue) < 2) {
                $arrError[$strIndice];
            }
        }
        if ($arrError) {
            throw new \Exception('O(s) seguinte(s) campo(s) são inválido: ' . implode($arrError));
        }
    }
}