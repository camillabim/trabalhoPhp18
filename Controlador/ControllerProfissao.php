<?php
/**
 * Created by PhpStorm.
 * User: Camilla
 * Date: 19/06/2018
 * Time: 19:38
 */

//importa a classe estado civil
require_once "../Modelo/Profissao.class.php";
// importa a conexao com php
require_once "Conexao.php";

class ControllerProfissao{

    public static function buscarTodos()
    {
        //retorna todos os estados civis encontrados no banco
        try {
            $sql = "SELECT * FROM profissao ORDER BY descricao"; //
            $resultado = Conexao::getInstance()->query($sql); // pego a conexão com o banco ** QUERY NO SELECT
            $lista = $resultado->fetchAll(PDO::FETCH_ASSOC); // JOGO O RESULTADO PARA DENTRO DA LISTA

            $vetor_lista = array(); // vetor de objetos
            foreach ($lista as $item_lista) {
                $vetor_lista[] = self::popularProfissao($item_lista); // retorna um objeto profissao preenchido
            }
            return $vetor_lista;
        } catch (Exception $e) {
            print "Ocorreu um erro ao executar a consulta";
        }
    }

    private static function popularProfissao($itemLista)
    {
        $profissao = new Profissao();
        $profissao->setId($itemLista['id']);
        $profissao->setProfissao($itemLista['descricao']);

        return $profissao;
    }

}