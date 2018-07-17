<?php
/**
 * Created by PhpStorm.
 * User: Camilla
 * Date: 30/06/2018
 * Time: 20:03
 */

require_once "Conexao.php";
require_once "../Modelo/Marca.class.php";


class ControllerMarca
{

    private static function inserir(Marca $marca)
    {

        try {
            $sql = "INSERT INTO marca (descricaoMarca) VALUES (";
            $sql .= ":descricaoMarca)";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":descricaoMarca", $marca->getDescricao());

            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao executar a conexão/inserção, verificar função 'INSERIR'";

        }
    }


    public static function buscarTodos()
    {
        //retorna todos os estados civis encontrados no banco
        try {
            $sql = "SELECT * FROM marca ORDER BY descricaoMarca"; //
            $resultado = Conexao::getInstance()->query($sql); // pego a conexão com o banco ** QUERY NO SELECT
            $lista = $resultado->fetchAll(PDO::FETCH_ASSOC); // JOGO O RESULTADO PARA DENTRO DA LISTA

            $vetor_lista = array(); // vetor de objetos
            foreach ($lista as $item_lista) {
                $vetor_lista[] = self::popularMarca($item_lista); // retorna um objeto cliente preenchido
            }
            return $vetor_lista;
        } catch (Exception $e) {
            print "Ocorreu um erro ao executar a consulta";
        }
    }

    private static function popularMarca($itemLista)
    {
        $marca = new Marca();
        $marca->setId($itemLista['id']);
        $marca->setDescricao($itemLista['descricaoMarca']);


        return $marca;
    }

    public static function salvar(Marca $marca){
        if($marca->getId() <= 0){
            return self::inserir($marca);
        }else{
            return self::alterar($marca);
        }
    }

    private static function alterar(Marca $marca){
        try{
            $sql = "UPDATE marca m SET descricaoMarca = :descricao WHERE m.id = :id";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":descricao", $marca->getDescricao());
            $p_sql->bindValue(":id", $marca->getId());

            return $p_sql->execute();
        } catch (PDOException $e) {
            print "Ocorreu um erro ao executar a alteração";
        }
    }

    public static function excluir($id)
    {
        try {
            $sql = "DELETE FROM marca WHERE id = :id";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao executar a exclusão";
        }
    }


    public static function buscarMarcaPorId($id){
        try {
            $sql = "SELECT * FROM marca m WHERE m.id = :id"; // FAÇO a consulta sql
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            $p_sql->execute(); // pego a conexão com o banco **
            $lista = $p_sql->fetchAll(PDO::FETCH_ASSOC); // JOGO O RESULTADO PARA DENTRO DA LISTA - pega o resultado do select e transforma
            // em um vetor associativo

            $marca = new Marca();
            foreach ($lista as $item_lista){
                $marca = self::popularMarca($item_lista); // retorna um objeto cliente preenchido
            }

            return $marca;

        }catch (PDOException $e) {
            print "Ocorreu um erro ao executar a consulta";
        }
    }


}