<?php
/**
 * Created by PhpStorm.
 * User: Camilla
 * Date: 30/06/2018
 * Time: 14:32
 */

require_once "Marca.class.php";
require_once "Categoria.class.php";

class Produto{
    private $id;
    private $descricao;
    private $estoque;
    private $valor_unitario;
    private $marca;
    private $categoria;

    public function __construct(){
        $this->id = 0;
        $this->marca = new Marca();
        $this->categoria = new Categoria();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getDescricao()
    {
        return $this->descricao;
    }

    /**
     * @param mixed $descricao
     */
    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    /**
     * @return mixed
     */
    public function getEstoque()
    {
        return $this->estoque;
    }

    /**
     * @param mixed $estoque
     */
    public function setEstoque($estoque)
    {
        $this->estoque = $estoque;
    }

    /**
     * @return mixed
     */
    public function getValorUnitario()
    {
        return $this->valor_unitario;
    }

    /**
     * @param mixed $valor_unitario
     */
    public function setValorUnitario($valor_unitario)
    {
        $this->valor_unitario = $valor_unitario;
    }

    /**
     * @return Marca
     */
    public function getMarca()
    {
        return $this->marca;
    }

    /**
     * @param Marca $marca
     */
    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    /**
     * @return Categoria
     */
    public function getCategoria()
    {
        return $this->categoria;
    }

    /**
     * @param Categoria $categoria
     */
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }



}