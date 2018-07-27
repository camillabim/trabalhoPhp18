<?php
/**
 * Created by PhpStorm.
 * User: Camilla
 * Date: 20/06/2018
 * Time: 19:59
 */


//Class que representa banco de dados
class Profissao
{
    private $id;
    private $profissao;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getProfissao()
    {
        return $this->profissao;
    }

    /**
     * @param mixed $profissao
     */
    public function setProfissao($profissao)
    {
        $this->profissao = $profissao;
    }


}