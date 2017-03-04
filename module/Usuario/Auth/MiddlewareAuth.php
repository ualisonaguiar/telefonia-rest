<?php

namespace Usuario\Auth;

use Firebase\JWT\JWT;

trait MiddlewareAuth
{
    private $strSecret = 'usuario-sistema-rest';

    /**
     * Metodo responsavel por validar o token e o seu tempo
     *
     * @return mixed
     * @throws \Exception
     */
    protected function validarToken()
    {
        $arrHeader = getallheaders();
        if (!array_key_exists('Authorization', $arrHeader)) {
            throw new \Exception('Token não localizado');
        }
        $strToken = trim(str_replace('Bearer', '', $arrHeader['Authorization']));
        $token = JWT::decode($strToken, $this->strSecret, ['HS256']);
        $arrDataToken = unserialize(base64_decode($token));
        $this->validarTempToken($arrDataToken['exp']);
        return $arrDataToken['usuario'];
    }

    /**
     * Metodo responsavel por gerar o token
     *
     * @param $arrData
     * @return string
     */
    protected function getToken($arrData)
    {
        $arrDataToken = [
            'usuario' => $arrData,
            'exp' => (round(microtime(true) * 1000)) + (1000 * 60 * 30)
        ];
        return JWT::encode(base64_encode(serialize($arrDataToken)), $this->strSecret);
    }

    /**
     * Metodo responsavel por validar o tempo do token
     *
     * @param $intTemp
     * @throws \Exception
     */
    private function validarTempToken($intTemp)
    {
        $intTempCurrent = round(microtime(true) * 1000);
        if ($intTempCurrent > $intTemp) {
            throw new \Exception('Token expirado');
        }
    }
}