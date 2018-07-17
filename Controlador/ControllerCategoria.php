<?php
/**
 * Created by PhpStorm.
 * User: Camilla
 * Date: 30/06/2018
 * Time: 20:03
 */

require_once "../modelo/Categoria.class.php";
require_once "Conexao.php";



class ControllerCategoria
{

    public static function buscarTodos()
    {
        //retorna todos os estados civis encontrados no banco
        try {
            $sql = "SELECT * FROM categoria ORDER BY descricaoCategoria"; //
            $resultado = Conexao::getInstance()->query($sql); // pego a conexão com o banco ** QUERY NO SELECT
            $lista = $resultado->fetchAll(PDO::FETCH_ASSOC); // JOGO O RESULTADO PARA DENTRO DA LISTA

            $vetor_lista = array(); // vetor de objetos
            foreach ($lista as $item_lista) {
                $vetor_lista[] = self::popularCategoria($item_lista); // retorna um objeto profissao preenchido
            }
            return $vetor_lista;
        } catch (Exception $e) {
            print "Ocorreu um erro ao executar a consulta";
        }
    }

    private static function popularCategoria($itemLista)
    {
        $categoria = new Categoria();
        $categoria->setId($itemLista['id']);
        $categoria->setDescricao($itemLista['descricaoCategoria']);

        return $categoria;
    }

    public static function salvar(Categoria $categoria){
        if($categoria->getId() <= 0){
            return self::inserir($categoria);
        }else{
            return self::alterar($categoria);
        }
    }

    public static function excluir($id)
    {
        try {
            $sql = "DELETE FROM categoria WHERE id = :id";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao executar a exclusão";
        }
    }

    public static function buscarCategoriaPorId($id){
        try {
            $sql = "SELECT * FROM categoria c WHERE c.id = :id"; // FAÇO a consulta sql
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            $p_sql->execute(); // pego a conexão com o banco **
            $lista = $p_sql->fetchAll(PDO::FETCH_ASSOC); // JOGO O RESULTADO PARA DENTRO DA LISTA - pega o resultado do select e transforma
            // em um vetor associativo

            $categoria = new Categoria();
            foreach ($lista as $item_lista){
                $categoria = self::popularCategoria($item_lista); // retorna um objeto cliente preenchido
            }

            return $categoria;

        }catch (PDOException $e) {
            print "Ocorreu um erro ao executar a consulta";
        }
    }

    private static function alterar(Categoria $categoria){
        try{
            $sql = "UPDATE categoria c SET descricaoCategoria = :descricao WHERE c.id = :id";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":descricao", $categoria->getDescricao());
            $p_sql->bindValue(":id", $categoria->getId());

            return $p_sql->execute();
        } catch (PDOException $e) {
            print "Ocorreu um erro ao executar a alteração";
        }
    }

    private static function inserir(Categoria $categoria)
    {

        try {
            $sql = "INSERT INTO categoria (descricaoCategoria) VALUES (";
            $sql .= ":descricaoCategoria)";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":descricaoCategoria", $categoria->getDescricao());

            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao executar a conexão/inserção, verificar função 'INSERIR'";

        }
    }

}