<?php
/**
 * Created by PhpStorm.
 * User: Camilla
 * Date: 31/07/2018
 * Time: 19:56
 */

require_once "Produto.class.php";

class ItemCarrinho
{
    private $produto;
    private $quantidade;

    public function __construct(){
        $this->produto = new Produto();
    }

    /**
     * @return Produto
     */
    public function getProduto()
    {
        return $this->produto;
    }

    /**
     * @param Produto $produto
     */
    public function setProduto($produto)
    {
        $this->produto = $produto;
    }

    /**
     * @return mixed
     */
    public function getQuantidade()
    {
        return $this->quantidade;
    }

    /**
     * @param mixed $quantidade
     */
    public function setQuantidade($quantidade)
    {
        $this->quantidade = $quantidade;
    }



}