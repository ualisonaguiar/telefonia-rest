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
    public function getListagem($intIdUsuario = null)
    {
        $this->validarToken();
        $usuarioDAO = new UsuarioDAO();
        return $usuarioDAO->getListagem($intIdUsuario);
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
        $arrDataUsuario['ds_senha'] = md5($arrDataUsuario['ds_senha']);
        $arrInfoHasUser = $this->hasUsuarioSistema($arrDataUsuario['ds_login'], $arrDataUsuario['ds_sistema']);
        $strMessage = 'O login informado já encontra-se atribuído ao um sistema';
        if (array_key_exists('id_usuario', $arrDataUsuario)) {
            if (!empty($arrInfoHasUser) && $arrInfoHasUser['id_usuario'] != $arrDataUsuario['id_usuario']) {
                throw new \Exception($strMessage);
            }
            $usuarioDAO->alterar($arrDataUsuario);
        } else {
            if ($arrInfoHasUser) {
                throw new \Exception($strMessage);
            }
            $usuarioDAO->inserirUsuario($arrDataUsuario);
        }
    }

    /**
     * Metodo responsavel por excluir o usuario
     *
     * @param $intIdUsuario
     * @throws \Exception
     */
    public function excluir($intIdUsuario)
    {
        $arrInfoUsuario = $this->getListagem($intIdUsuario);
        if (!$arrInfoUsuario) {
            throw new \Exception('Usuário não encontrado no sistema.');
        }
        $usuarioDAO = new UsuarioDAO();
        $usuarioDAO->excluir($intIdUsuario);
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
        return ($arrInfoUsuario) ? reset($arrInfoUsuario) : false;
    }
}