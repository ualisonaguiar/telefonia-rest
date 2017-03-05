<?php

namespace Usuario\DAO;

use Usuario\DAO\AbstractConexao;

class TelefoneDAO extends AbstractConexao
{
    public function inserirTelefone($arrData)
    {
        $strSQL = 'insert into tb_telefone (id_usuario, ds_prefixo, ds_senha, co_categoria, ds_chave) values ';
        $strSQL .= '(:id_usuario, :ds_prefixo, :ds_senha, :co_categoria, :ds_chave)';
        $connection = self::getConection();
        $query = $connection->prepare($strSQL);
        return $query->execute([
            'id_usuario' => $arrData['id_usuario'],
            'ds_prefixo' => $arrData['ds_prefixo'],
            'ds_senha' => $arrData['ds_senha'],
            'co_categoria' => $arrData['co_categoria'],
            'ds_chave' => $arrData['ds_chave'],
        ]);
    }

    public function inserirLoteTelefone($arrData, $intIdUsuario)
    {
        try {
            $connection = self::getConection();
            $connection->beginTransaction();
            foreach ($arrData as $arrDataInfo) {
                $strSQL = 'insert into tb_telefone (id_usuario, ds_prefixo, ds_senha, co_categoria, ds_chave) values ';
                $strSQL .= '(:id_usuario, :ds_prefixo, :ds_senha, :co_categoria, :ds_chave)';
                $arrDataInfo['id_usuario'] = $intIdUsuario;
                $query = $connection->prepare($strSQL);
                $query->execute($arrDataInfo);
            }
            $connection->commit();
        } catch(\Exception $exception) {
            $connection->rollBack();
        }
    }

    public function getListagem($arrData = null)
    {
        $strSQL = 'select * from tb_telefone';
        if ($arrData) {
            $strSQL .= ' where ';
            $arrCriteria = [];
            foreach (array_keys($arrData) as $intField) {
                $strSQL .= $intField . ' = :' . $intField .' and ';
            }
            $strSQL = trim(substr($strSQL, 0, strlen($strSQL) -4));
        }
        $connection = self::getConection();
        $query = $connection->prepare($strSQL);
        $query->execute($arrData);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }
}