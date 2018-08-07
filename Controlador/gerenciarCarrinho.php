<?php

session_start();

require_once "../Modelo/ItemCarrinho.class.php";
require_once "ControllerProdutos.php";

if(isset($_GET['adicionar'])){
    if(isset($_GET['produto'])){
        if(isset($_SESSION['carrinho'])){//se a sessão já existe
            $itens = unserialize($_SESSION['carrinho']);
        }else{
            $itens = array(); // crio um novo array
        }
        $itemCarrinho = new ItemCarrinho();
        $itemCarrinho->setProduto(ControllerProdutos::buscarProdutoPorId($_GET['produto']));
        $itemCarrinho->setQuantidade(1);
        $itens[] = $itemCarrinho; // insiro o itemcarrinho na ultima posição do vetor
        $_SESSION['carrinho'] = serialize($itens);
    }
}
header('Location: ../Web/Carrinho.php');

?>
