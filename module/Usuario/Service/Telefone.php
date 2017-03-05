<?php

namespace Usuario\Service;

use Usuario\DAO\TelefoneDAO;

class Telefone
{
    public function cadastrar($arrData)
    {
        try {
            $telefoneDao = new TelefoneDAO();
            $arrResult = $this->checkPrefixoCategoria($arrData);
            if ($arrResult) {
                throw new \Exception('Já encontra-se cadastrado estes dados.');
            }
            $telefoneDao->inserirTelefone($arrData);
        } catch (\Exception $exception) {
            throw new \Exception('Não foi possível cadastrar.' . $exception->getMessage());
        }
    }

    public function cadastrarLote($arrData, $intIdUsusario)
    {
        try {
            $telefoneDao = new TelefoneDAO();
            $arrData = array_map("unserialize", array_unique(array_map("serialize", $arrData['telefones'])));
            $arrResult = $telefoneDao->getListagem([
                'id_usuario' => $intIdUsusario
            ]);
            if ($arrResult) {
                foreach ($arrResult as $arrInfo) {
                    foreach ($arrData as $arrInfoData) {
                        if (
                            $arrInfo['ds_prefixo'] == $arrInfoData['ds_prefixo'] &&
                            $arrInfo['co_categoria'] == $arrInfoData['co_categoria']
                        ) {
                            $strMessage = 'Já encontra-se cadastrado os dados. Prefixo: %s e categoria %s';
                            throw new \Exception(sprintf($strMessage, $arrInfoData['ds_prefixo'], $arrInfoData['co_categoria']));
                        }
                    }
                }
            }
            $telefoneDao->inserirLoteTelefone($arrData, $intIdUsusario);
        } catch (\Exception $exception) {
            throw new \Exception('Não foi possível cadastrar.' . $exception->getMessage());
        }
    }

    /**
     * Metodo responsavel por evitar a duplicidade de registros referente ao prefixo e categoria
     *
     * @param $arrData
     */
    public function checkPrefixoCategoria($arrData)
    {
        $telefoneDao = new TelefoneDAO();
        $arrResult = $telefoneDao->getListagem([
            'ds_prefixo' => $arrData['ds_prefixo'],
            'co_categoria' => $arrData['co_categoria'],
            'id_usuario' => $arrData['id_usuario'],
        ]);
        return $arrResult;
    }
}