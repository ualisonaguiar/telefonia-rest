<?php

namespace Telefonia\Service;

use Telefonia\Entity\PinEntity;

class PINService
{
    public function salvar($arrData)
    {
        try {
            $pinEntity = new PinEntity();
            $arrResult = $this->getAllPinToken($arrData['chave']);
            $strMethod = 'adicionar';
            $strReturn = 'casdastrado';
            if ($arrResult) {
                $strMethod = 'atualizar';
                $arrData['id'] = $arrResult[$arrData['chave']]['id'];
                $strReturn = 'atualizado';
            }

            $pinEntity->$strMethod($arrData); //salva os registros chave, senha, codigo e timeout

            $arr = array();
            $arr[0]['chave'] = $arrData['chave'];
            $arr[0]['senha'] = $arrData['senha'];
            $arr[0]['codigo'] = $arrData['codigo'];
            $arr[0]['timeout'] = $arrData['timeout'];
            $arr[0]['prefixo'] = $arrData['prefixo'];
            $arr[0]['central'] = $arrData['central'];

            $this->salvarPrefixoCentral($arr); //salva os registros chave, prefixo e central

            return $strReturn;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function salvarLote($arrDataPost)
    {
        try {
            $pinEntity = new PinEntity();
            if ($arrDataPost) {
                $arrData = [];
                foreach ($arrDataPost['pin'] as $arrInfoPin) {
                    $arrData[$arrInfoPin['chave']] = $arrInfoPin;
                }
                $arrPrefixoCentral = $arrData;
                $arrAllPinToken = $this->preparFetchPairsChave($pinEntity->getListagem());

                foreach ($arrData as $intPosicao => $arrInfoData) {
                    if (array_key_exists($arrInfoData['chave'], $arrAllPinToken)) {
                        $arrInfoData['id'] = $arrAllPinToken[$arrInfoData['chave']]['id'];
                        $pinEntity->atualizar($arrInfoData);
                        unset($arrData[$intPosicao]);
                    }
                }
                $pinEntity->adicionarLote($arrData);
                $this->salvarPrefixoCentral($arrPrefixoCentral); //salva os registros chave, prefixo e central
            }
            return true;
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function salvarPrefixoCentral($arrData)
    {
        try {
            $pinEntity = new PinEntity();
            if ($arrData) {
                $arrAllPinToken = $this->preparFetchPairsChave($pinEntity->getListagem());
                foreach ($arrData as $intPosicao => $arrInfoData) {
                    if (array_key_exists($arrInfoData['chave'], $arrAllPinToken)) {
                        $arrResult = $this->getPrefixoCentral($arrInfoData['prefixo'], $arrInfoData['central']);
                        if (empty($arrResult)) {
                            $arrData[$intPosicao]['id_pin'] = $arrAllPinToken[$arrInfoData['chave']]['id'];
                        } else {
                            unset($arrData[$intPosicao]);
                        }
                    }
                }
                $pinEntity->adicionarPrefixoCentralLote($arrData);
                return true;
            }
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    protected function getPrefixoCentral($strPrefixo, $strCentral)
    {
        $pinEntity = new PinEntity();
        $arrResult = $pinEntity->getPrefixoCentral([
            'prefixo' => $strPrefixo,
            'nm_central' => $strCentral
        ]);

        if (!$arrResult) {
            return $arrResult;
        }

        return $this->preparFetchPairsPrefixoCentral($arrResult);
    }

    protected function preparFetchPairsPrefixoCentral($arrResultPin)
    {
        $arrFetchPairPrefixoCentral = [];
        foreach ($arrResultPin as $arrInfo) {
            $arrFetchPairPrefixoCentral[$arrInfo['id_pin']] = $arrInfo;
        }

        return $arrFetchPairPrefixoCentral;
    }

    protected function getAllPinToken($strChave)
    {
        $pinEntity = new PinEntity();
        $arrResult = $pinEntity->getListagem([
            'chave' => $strChave
        ]);
        if (!$arrResult) {
            return $arrResult;
        }

        return $this->preparFetchPairsChave($arrResult);
    }

    protected function preparFetchPairsChave($arrResultPin)
    {
        $arrFetchPairChave = [];
        foreach ($arrResultPin as $arrInfo) {
            $arrFetchPairChave[$arrInfo['chave']] = $arrInfo;
        }
        return $arrFetchPairChave;
    }
}

?>
