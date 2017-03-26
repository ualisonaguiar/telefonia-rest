<?php

namespace Telefonia\Entity;

use Telefonia\Entity\Conexao;

class PinEntity
{
    use Conexao;

    public function adicionar($arrData)
    {
        $strSQL = 'insert into poc_sms.tb_pin (chave, senha, codigo, timeout) values ';
        $strSQL .= '(:chave, :senha, :codigo, :timeout)';
        $connection = self::getConection();
        $query = $connection->prepare($strSQL);
        $this->setBind($query, $arrData);
        return $query->execute();
    }

    public function adicionarLote($arrData)
    {
        try {
            $connection = self::getConection();
            $connection->beginTransaction();
            foreach ($arrData as $arrInfo) {
                $this->adicionar($arrInfo);
            }
            $connection->commit();
        } catch (\Exception $exception) {
            $connection->rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    public function adicionarPrefixoCentral($arrData)
    {
        $strSQL = 'insert into poc_sms.tb_pin_prefixo (id_pin, prefixo, nm_central) values ';
        $strSQL .= '(:id_pin, :prefixo, :nm_central)';
        $connection = self::getConection();
        $query = $connection->prepare($strSQL);
        $this->setBindPrefixoCentral($query, $arrData);
        return $query->execute();
    }

    public function adicionarPrefixoCentralLote($arrData)
    {
        try {
            $connection = self::getConection();
            $connection->beginTransaction();

            foreach ($arrData as $arrInfo) {
                $this->adicionarPrefixoCentral($arrInfo);
            }
            $connection->commit();
        } catch (\Exception $exception) {
            $connection->rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    public function getListagem($arrCriteria = array())
    {
        $strSQL = 'select id, chave, senha, codigo, timeout from poc_sms.tb_pin';
        if ($arrCriteria) {
            $arrField = [];
            foreach (array_keys($arrCriteria) as $strField) {
                $arrField[] = $strField . ' = :' . $strField;
            }
            $strSQL .= ' where ' . implode(' and ', $arrField);
        }
        $connection = self::getConection();
        $query = $connection->prepare($strSQL);
        $query->execute($arrCriteria);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPrefixoCentral($arrCriteria = array())
    {
        $strSQL = 'select id, id_pin, prefixo, nm_central, status from poc_sms.tb_pin_prefixo';
        if ($arrCriteria) {
            $arrField = [];
            foreach (array_keys($arrCriteria) as $strField) {
                $arrField[] = $strField . ' = :' . $strField;
            }
            $strSQL .= ' where ' . implode(' and ', $arrField);
        }

        $connection = self::getConection();
        $query = $connection->prepare($strSQL);
        $query->execute($arrCriteria);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function atualizar($arrData)
    {
        $strSQL = 'update poc_sms.tb_pin set chave = :chave, senha = :senha, codigo = :codigo, timeout = :timeout';
        $strSQL .= ' where id = :id';
        $connection = self::getConection();
        $query = $connection->prepare($strSQL);
        $this->setBind($query, $arrData);
        $query->bindParam('id', $arrData['id']);
        return $query->execute();
    }

    protected function setBind(&$query, $arrData)
    {
        $query->bindParam('chave', $arrData['chave'], \PDO::PARAM_STR);
        $query->bindParam('senha', $arrData['senha'], \PDO::PARAM_STR);
        $query->bindParam('codigo', $arrData['codigo'], \PDO::PARAM_STR);
        $query->bindParam('timeout', $arrData['timeout'], \PDO::PARAM_STR);
    }

    protected function setBindPrefixoCentral(&$query, $arrData)
    {
        $query->bindParam('id_pin', $arrData['id_pin'], \PDO::PARAM_INT);
        $query->bindParam('prefixo', $arrData['prefixo'], \PDO::PARAM_STR);
        $query->bindParam('nm_central', $arrData['central'], \PDO::PARAM_STR);
    }
}

?>
