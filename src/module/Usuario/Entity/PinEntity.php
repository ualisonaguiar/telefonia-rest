<?php
/**
 * Created by PhpStorm.
 * User: ualison
 * Date: 06/03/17
 * Time: 11:52
 */

namespace Usuario\Entity;

use Usuario\Entity\Conexao;

class PinEntity
{
    use Conexao;

    public function adicionar($arrData)
    {
        $strSQL = 'insert into tb_pin (prefixo, chave, senha, codigo) values ';
        $strSQL .= '(:prefixo, :chave, :senha, :codigo)';
        $connection = self::getConection();
        $query = $connection->prepare($strSQL);
        return $query->execute([
            'prefixo' => $arrData['prefixo'],
            'chave' => $arrData['chave'],
            'senha' => $arrData['senha'],
            'codigo' => $arrData['codigo'],
        ]);
    }

    public function adicionarLote($arrData)
    {
        try {
            $connection = self::getConection();
            $connection->beginTransaction();
            $this->adicionar($arrData);
            $connection->commit();
        } catch(\Exception $exception) {
            $connection->rollBack();
        }
    }
}