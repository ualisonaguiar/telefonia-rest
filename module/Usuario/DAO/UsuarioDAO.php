<?php

namespace Usuario\DAO;

use Usuario\DAO\AbstractConexao;

class UsuarioDAO extends AbstractConexao
{
    /**
     * Metodo responsavel por retornar a listagem de usuarios cadastrados
     *
     * @return array
     */
    public function getListagem()
    {
        $strSQL = 'select * from tb_usuario';
        $connection = self::getConection();
        $query = $connection->prepare($strSQL);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Metodo responsavel por autenticar no sistema
     *
     * @param $strUsuario
     * @param $strSenha
     * @return array
     */
    public function getAutenticacao($strUsuario, $strSenha)
    {
        $strSQL = 'select * from tb_usuario where ds_login = :dsLogin and ds_senha = :dsSenha';
        $connection = self::getConection();
        $query = $connection->prepare($strSQL);
        $query->execute([
            'dsLogin' => $strUsuario,
            'dsSenha' => $strSenha,
        ]);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Metodo responsavel por evitar duplicidade de usuario no mesmo sistema
     *
     * @param $strUsuario
     * @param $strSistema
     * @return array
     */
    public function hasUsuarioSistema($strUsuario, $strSistema)
    {
        $strSQL = 'select id_usuario from tb_usuario where ds_login = :dsLogin and ds_sistema = :dsSistema';
        $connection = self::getConection();
        $query = $connection->prepare($strSQL);
        $query->execute([
            'dsLogin' => $strUsuario,
            'dsSistema' => $strSistema,
        ]);
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Metodo responsavel por inserir o usuario no sistema
     *
     * @param $arrDataUsuario
     * @return bool
     */
    public function inserirUsuario($arrDataUsuario)
    {
        $strSQL = 'insert into tb_usuario (ds_login, ds_senha, ds_sistema, id_usuario_cadastrado) VALUES ';
        $strSQL .= '(:ds_login, :ds_senha, :ds_sistema, :id_usuario_cadastrado)';
        $connection = self::getConection();
        $query = $connection->prepare($strSQL);
        $this->setBind($query, $arrDataUsuario);
        return $query->execute();
    }

    protected function setBind(&$query, $arrDataUsuario)
    {
        $query->bindParam('ds_login', $arrDataUsuario['ds_login'], \PDO::PARAM_STR);
        $query->bindParam('ds_senha', $arrDataUsuario['ds_senha'], \PDO::PARAM_STR);
        $query->bindParam('ds_sistema', $arrDataUsuario['ds_sistema'], \PDO::PARAM_STR);
        $query->bindParam('id_usuario_cadastrado', $arrDataUsuario['idUsuarioLogado'], \PDO::PARAM_INT);
    }
}