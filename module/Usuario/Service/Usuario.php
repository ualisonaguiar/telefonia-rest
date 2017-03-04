<?php

namespace Usuario\Service;

use Usuario\DAO\UsuarioDAO;
use Usuario\Auth\MiddlewareAuth;

class Usuario
{
    use MiddlewareAuth;

    /**
     * Metodo responsavel por fazer autenticacao
     *
     * @param $strUsuario
     * @param $strSenha
     * @return string
     * @throws \Exception
     */
    public function getLogin($strUsuario, $strSenha)
    {
        $usuarioDAO = new UsuarioDAO();
        $arrInfoUsuario = $usuarioDAO->getAutenticacao(
            $strUsuario,
            md5($strSenha)
        );
        if (empty($arrInfoUsuario)) {
            throw new \Exception('Usuário/Senha está incorreta.');
        }
        return $this->getToken($arrInfoUsuario[0]);
    }

    /**
     * metodo responsavel por retornar a listagem
     *
     * @return array
     * @throws \Exception
     */
    public function getListagem()
    {
        $this->validarToken();
        $usuarioDAO = new UsuarioDAO();
        return $usuarioDAO->getListagem();
    }

    /**
     * metodo responsavel por salvar os dados do usuario
     *
     * @param $arrDataUsuario
     * @throws \Exception
     */
    public function salvar($arrDataUsuario)
    {
        $usuarioDAO = new UsuarioDAO();
        if (array_key_exists('id_usuario', $arrDataUsuario)) {

        } else {
            $this->hasUsuarioSistema($arrDataUsuario['ds_login'], $arrDataUsuario['ds_sistema']);
            $arrDataUsuario['ds_senha'] = md5($arrDataUsuario['ds_senha']);
            $usuarioDAO->inserirUsuario($arrDataUsuario);
        }
    }

    /**
     * Metodo responsavel por evitar duplicidade
     *
     * @param $strLogin
     * @param $strSistema
     * @throws \Exception
     */
    protected function hasUsuarioSistema($strLogin, $strSistema)
    {
        $usuarioDAO = new UsuarioDAO();
        $arrInfoUsuario = $usuarioDAO->hasUsuarioSistema($strLogin, $strSistema);
        if ($arrInfoUsuario) {
            throw new \Exception('O login informado já encontra-se atribuído ao um sistema');
        }
    }
}