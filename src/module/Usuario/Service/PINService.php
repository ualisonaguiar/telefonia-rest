<?php
/**
 * Created by PhpStorm.
 * User: ualison
 * Date: 06/03/17
 * Time: 11:09
 */

namespace Usuario\Service;

use Usuario\Entity\PinEntity;

class PINService
{
    public function salvar($arrData)
    {
        try {
            $pinEntity = new PinEntity();
            $arrResult = $this->getAllPinToken($arrData['prefixo']);
            $strMethod = 'adicionar';
            $strReturn = 'adicionado';
            if ($arrResult) {
                $strMethod = 'atualizar';
                $arrData['id'] = $arrResult[$arrData['prefixo']]['id'];
                $strReturn = 'atualizado';
            }
            $pinEntity->$strMethod($arrData);
            return $strReturn;
        } catch(\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function salvarLote($arrData)
    {
        try {
            $pinEntity = new PinEntity();
            $arrData = array_map(
                "unserialize",
                array_unique(array_map("serialize", $arrData['pin']))
            );
            if ($arrData) {
                $arrAllPinToken = $this->preparFetchPairsPrefixo($pinEntity->getListagem());
                foreach ($arrData as $intPosicao => $arrInfoData) {
                    if (array_key_exists($arrInfoData['prefixo'], $arrAllPinToken)) {
                        $arrInfoData['id'] = $arrAllPinToken[$arrInfoData['prefixo']]['id'];
                        $pinEntity->atualizar($arrInfoData);
                        unset($arrData[$intPosicao]);
                    }
                }
                $pinEntity->adicionarLote($arrData);
            }
            return true;
        } catch(\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    protected function getAllPinToken($intPrefixo)
    {
        $pinEntity = new PinEntity();
        $arrResult = $pinEntity->getListagem([
            'prefixo' => $intPrefixo
        ]);
        if (!$arrResult) {
            return $arrResult;
        }
        return $this->preparFetchPairsPrefixo($arrResult);
    }

    protected function preparFetchPairsPrefixo($arrResultPin) {
        $arrFetchPairPrefixo = [];
        foreach ($arrResultPin as $arrInfo) {
            $arrFetchPairPrefixo[$arrInfo['prefixo']] = $arrInfo;
        }
        return $arrFetchPairPrefixo;
    }
}