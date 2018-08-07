<?php
/**
 * Created by PhpStorm.
 * User: Camilla
 * Date: 30/06/2018
 * Time: 17:36
 */

require_once "../Modelo/Produto.class.php";
require_once "Conexao.php";
require_once "../Modelo/Categoria.class.php";


class ControllerProdutos
{
    private static function inserir(Produto $produto)
    {

        try {
            $sql = "INSERT INTO produto (descricao, estoque, valor_unitario, FKmarca, FKcategoria) VALUES (";
            $sql .= ":descricao,";
            $sql .= ":estoque,";
            $sql .= ":valor_unitario,";
            $sql .= ":FKmarca,";
            $sql .= ":FKcategoria)";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":descricao", $produto->getDescricao());
            $p_sql->bindValue(":estoque", $produto->getEstoque());
            $p_sql->bindValue(":valor_unitario", $produto->getValorUnitario());
            $p_sql->bindValue(":FKmarca", $produto->getMarca()->getId());
            $p_sql->bindValue(":FKcategoria", $produto->getCategoria()->getId());

            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao executar a conexão/inserção, verificar função 'INSERIR'";

        }
    }


    private static function popularProduto($itemLista)
    {
        $produto = new Produto();
        $produto->setId($itemLista['id']);
        $produto->setDescricao($itemLista['descricao']);
        $produto->setEstoque($itemLista['estoque']);
        $produto->setValorUnitario($itemLista['valor_unitario']);
        $produto->getMarca()->setId($itemLista['FKmarca']);
        $produto->getMarca()->setDescricao($itemLista['descricaoMarca']);
        $produto->getCategoria()->setId($itemLista['FKcategoria']);
        $produto->getCategoria()->setDescricao($itemLista['descricaoCategoria']);

        return $produto;
    }

    public static function buscarTodos()
    {
        try {
            $sql = "SELECT p.*, m.descricaoMarca, c.descricaoCategoria FROM produto p INNER JOIN marca m ON m.id = p.FKmarca INNER JOIN categoria c ON c.id = p.FKcategoria ORDER BY p.descricao"; // ORDENADO POR NOME
            $resultado = Conexao::getInstance()->query($sql); // pego a conexão com o banco ** QUERY NO SELECT
            $lista = $resultado->fetchAll(PDO::FETCH_ASSOC); // JOGO O RESULTADO PARA DENTRO DA LISTA

            $vetor_lista = array(); // vetor de objetos
            foreach ($lista as $item_lista) {
                $vetor_lista[] = self::popularProduto($item_lista); // retorna um objeto produto preenchido
            }
            return $vetor_lista;
        } catch (Exception $e) {
            print "Ocorreu um erro ao executar a consulta - BUSCAR TODOS";
        }
    }

    public static function salvar(Produto $produto){
        if($produto->getId() <= 0){
            return self::inserir($produto);
        }else{
            return self::alterar($produto);
        }
    }

    public static function excluir($id)
    {
        try {
            $sql = "DELETE FROM produto WHERE id = :id";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao executar a exclusão";
        }
    }

    public static function buscarProdutoPorId($id)
    {
        try {
            $sql = "SELECT p.*, m.descricaoMarca, c.descricaoCategoria FROM produto p INNER JOIN marca m ON m.id = p.FKmarca INNER JOIN categoria c ON c.id = p.FKcategoria WHERE p.id = :id"; // FAÇO a consulta sql
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            $p_sql->execute(); // pego a conexão com o banco **
            $lista = $p_sql->fetchAll(PDO::FETCH_ASSOC); // JOGO O RESULTADO PARA DENTRO DA LISTA - pega o resultado do select e transforma
            // em um vetor associativo

            $produto = new Produto();
            foreach ($lista as $item_lista) {
                $produto = self::popularProduto($item_lista); // retorna um objeto cliente preenchido
            }

            return $produto;

        }catch (PDOException $e) {
            print "Ocorreu um erro ao executar a consulta";
        }
    }

    private static function alterar(Produto $produto){
        try{
            $sql = "UPDATE produto p SET descricao = :descricao, estoque = :estoque, valor_unitario = :valor_unitario, FKmarca = :marca, FKcategoria = :categoria WHERE p.id = :id";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":descricao", $produto->getDescricao());
            $p_sql->bindValue(":estoque", $produto->getEstoque());
            $p_sql->bindValue(":valor_unitario", $produto->getValorUnitario());
            $p_sql->bindValue(":marca", $produto->getMarca()->getId());
            $p_sql->bindValue(":categoria", $produto->getCategoria()->getId());
            $p_sql->bindValue(":id", $produto->getId());

            return $p_sql->execute();
        } catch (PDOException $e) {
            print "Ocorreu um erro ao executar a alteração";
        }
    }

    public static function buscarProdutoPorCategoria($categoria)
    {
        try {
            $sql = "SELECT p.*, m.descricaoMarca, c.descricaoCategoria FROM produto p INNER JOIN marca m ON m.id = p.FKmarca INNER JOIN categoria c ON c.id = p.FKcategoria WHERE FKcategoria = :categoria";

            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":categoria", $categoria);
            $p_sql->execute(); // pego a conexão com o banco **
            $lista = $p_sql->fetchAll(PDO::FETCH_ASSOC); // JOGO O RESULTADO PARA DENTRO DA LISTA

            $vetor_lista = array(); // vetor de objetos
            foreach ($lista as $item_lista) {
                $vetor_lista[] = self::popularProduto($item_lista); // retorna um objeto produto preenchido
            }
            return $vetor_lista;

        } catch (Exception $e) {
            print "Ocorreu um erro ao executar a consulta - BUSCAR TODOS";
        }
    }

}