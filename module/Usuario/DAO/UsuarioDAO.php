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
    public function getListagem($intIdUsuario = null)
    {
        $strSQL = 'select * from tb_usuario';
        $arrDataBind = [];
        if ($intIdUsuario) {
            $strSQL .= ' where id_usuario = :id_usuario';
            $arrDataBind['id_usuario'] = $intIdUsuario;
        }
        $connection = self::getConection();
        $query = $connection->prepare($strSQL);
        $query->execute($arrDataBind);
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

    /**
     * Metodo responsavel por alterar os dados do usuario
     *
     * @param $arrDataUsuario
     * @return bool
     */
    public function alterar($arrDataUsuario)
    {
        $strSQL = 'update tb_usuario set ds_login = :ds_login, ds_senha = :ds_senha, ds_sistema = :ds_sistema,';
        $strSQL .= 'id_usuario_cadastrado = :id_usuario_cadastrado where id_usuario =:id_usuario';

        $connection = self::getConection();
        $query = $connection->prepare($strSQL);
        $this->setBind($query, $arrDataUsuario);
        $query->bindParam('id_usuario', $arrDataUsuario['id_usuario'], \PDO::PARAM_INT);
        $query->execute();
    }

    /**
     * Metodo responsavel por excluir o usuario no sistema
     *
     * @param $intIdUsuario
     * @return bool
     */
    public function excluir($intIdUsuario)
    {
        $strSQL = 'delete from tb_usuario where id_usuario = :id_usuario';
        $connection = self::getConection();
        $query = $connection->prepare($strSQL);
        $query->bindParam('id_usuario', $intIdUsuario, \PDO::PARAM_INT);
        return $query->execute();
    }

    protected function setBind(&$query, $arrDataUsuario)
    {
        $query->bindParam('ds_login', $arrDataUsuario['ds_login'], \PDO::PARAM_STR);
        $query->bindParam('ds_senha', $arrDataUsuario['ds_senha'], \PDO::PARAM_STR);
        $query->bindParam('ds_sistema', $arrDataUsuario['ds_sistema'], \PDO::PARAM_STR);
        $query->bindParam('id_usuario_cadastrado', $arrDataUsuario['id_usuario_cadastrado'], \PDO::PARAM_INT);
    }
}