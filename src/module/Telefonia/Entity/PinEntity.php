<?php
/**
 * Created by PhpStorm.
 * User: ualison
 * Date: 06/03/17
 * Time: 11:52
 */

namespace Telefonia\Entity;

use Telefonia\Entity\Conexao;

class PinEntity
{
    use Conexao;

    public function adicionar($arrData)
    {
        $strSQL = 'insert into tb_pin (prefixo, chave, senha, codigo, timeout) values ';
        $strSQL .= '(:prefixo, :chave, :senha, :codigo, :timeout)';
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
        } catch(\Exception $exception) {
            $connection->rollBack();
            throw new \Exception($exception->getMessage());
        }
    }

    public function getListagem($arrCriteria = array())
    {
        $strSQL = 'select id,prefixo, chave, senha, codigo, timeout from tb_pin';
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
        $strSQL = 'update tb_pin set prefixo = :prefixo, chave = :chave, senha = :senha, codigo = :codigo, timeout = :timeout';
        $strSQL .= ' where id = :id';
        $connection = self::getConection();
        $query = $connection->prepare($strSQL);
        $this->setBind($query, $arrData);
        $query->bindParam('id', $arrData['id']);
        return $query->execute();
    }

    protected function setBind(&$query, $arrData)
    {
        $query->bindParam('prefixo', $arrData['prefixo'], \PDO::PARAM_STR);
        $query->bindParam('chave', $arrData['chave'], \PDO::PARAM_STR);
        $query->bindParam('senha', $arrData['senha'], \PDO::PARAM_STR);
        $query->bindParam('codigo', $arrData['codigo'], \PDO::PARAM_INT);
        $query->bindParam('timeout', $arrData['timeout'], \PDO::PARAM_STR);
    }
}