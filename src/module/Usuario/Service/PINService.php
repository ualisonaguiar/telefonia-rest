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
    public function adicionar($arrData)
    {
        try {
            $pinEntity = new PinEntity();
            return $pinEntity->adicionar($arrData);
        } catch(\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function adicionarLote($arrData)
    {
        try {
            $pinEntity = new PinEntity();
            $arrData = array_map("unserialize", array_unique(array_map("serialize", $arrData['pin'])));

        } catch(\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }
}