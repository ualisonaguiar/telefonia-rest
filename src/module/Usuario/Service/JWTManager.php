<?php
/**
 * Created by PhpStorm.
 * User: ualison
 * Date: 06/03/17
 * Time: 11:37
 */

namespace Usuario\Service;

use Firebase\JWT\JWT;

class JWTManager
{
    protected $secret = 'usuario-pin';

    public function gerarToken($arrData)
    {
        $arrDataToken = [
            'iat' => time(),
            'exp' => (round(microtime(true) * 1000)) + (1000 * 60 * 30),
            'context' => [
                'user' => $arrData
            ],
        ];
        return JWT::encode(base64_encode(serialize($arrDataToken)), $this->secret);
    }

    public function getInformacaoToken($strToken)
    {
        $strToken = str_replace('Bearer ', '', $strToken);
        $token = JWT::decode($strToken, $this->secret, ['HS256']);
        $arrDataToken = unserialize(base64_decode($token));
        return $arrDataToken;
    }
}