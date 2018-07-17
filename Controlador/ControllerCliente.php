<?php
/**
 * Created by PhpStorm.
 * User: Camilla
 * Date: 08/05/2018
 * Time: 20:08
 */

require_once "../Modelo/Cliente.class.php";
require_once "Conexao.php";

class ControllerCliente
{
    /*realizar a comunicação com o banco*/

    private static function inserir(Cliente $cliente)
    {

        try {
            $sql = "INSERT INTO cliente (nome, email, telefone, endereco, sexo, profissao, fkidEstCivil, fkidClienteProfissao) VALUES (";
            $sql .= ":nome,";
            $sql .= ":email,";
            $sql .= ":telefone,";
            $sql .= ":endereco,";
            $sql .= ":sexo,";
            $sql .= ":profissao)";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":nome", $cliente->getNome());
            $p_sql->bindValue(":email", $cliente->getEmail());
            $p_sql->bindValue(":telefone", $cliente->getTelefone());
            $p_sql->bindValue(":endereco", $cliente->getEndereco());
            $p_sql->bindValue(":sexo", $cliente->getSexo());
            $p_sql->bindValue(":profissao", $cliente->getProfissao());

            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao executar a conexão/inserção, verificar função 'INSERIR'";

        }
    }

    // método static so consegue acessar metodos static
    /*metodo para realizar a busca de todos os clientes no banco*/
    public static function buscarTodos()
    {
        try {
            $sql = "SELECT c.*, ec.descricao FROM cliente c INNER JOIN  est_civil ec ON ec.id = c.fkidEstCivil ORDER BY nome"; // ORDENADO POR NOME
            $resultado = Conexao::getInstance()->query($sql); // pego a conexão com o banco ** QUERY NO SELECT
            $lista = $resultado->fetchAll(PDO::FETCH_ASSOC); // JOGO O RESULTADO PARA DENTRO DA LISTA

            $vetor_lista = array(); // vetor de objetos
            foreach ($lista as $item_lista) {
                $vetor_lista[] = self::popularCliente($item_lista); // retorna um objeto cliente preenchido
            }
            return $vetor_lista;
        } catch (Exception $e) {
            print "Ocorreu um erro ao executar a consulta";
        }
    }

    private static function alterar(Cliente $cliente){
        try{
            $sql = "UPDATE cliente SET nome = :nome, email = :email, telefone = :telefone, endereco = :endereco, sexo = :sexo, profissao = :profissao WHERE c.id = :id";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":nome", $cliente->getNome());
            $p_sql->bindValue(":email", $cliente->getEmail());
            $p_sql->bindValue(":telefone", $cliente->getTelefone());
            $p_sql->bindValue(":endereco", $cliente->getEndereco());
            $p_sql->bindValue(":sexo", $cliente->getSexo());
            $p_sql->bindValue(":profissao", $cliente->getProfissao());
            $p_sql->bindValue(":id", $cliente->getId());

            return $p_sql->execute();
        } catch (PDOException $e) {
            print "Ocorreu um erro ao executar a alteração";
        }
    }

    public static function salvar(Cliente $cliente){
        if($cliente->getId() <= 0){
            return self::inserir($cliente);
        }else{
            return self::alterar($cliente);
        }
    }

    public static function excluir($id)
    {
        try {
            $sql = "DELETE FROM cliente WHERE id = :id";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao executar a exclusão";
        }
    }

    private static function popularCliente($itemLista)
    {
        $cliente = new Cliente();
        $cliente->setId($itemLista['id']);
        $cliente->setNome($itemLista['nome']);
        $cliente->setEmail($itemLista['email']);
        $cliente->setTelefone($itemLista['telefone']);
        $cliente->setEndereco($itemLista['endereco']);
        $cliente->setSexo($itemLista['sexo']);
        $cliente->setProfissao($itemLista['profissao']);
        $cliente->getEstCivil()->setId($itemLista['fkidEstCivil']);
        $cliente->getEstCivil()->setDescricao($itemLista['descricao']);


        return $cliente;
    }

    /**
     * @param $id
     * @return string
     */

    public static function buscarCliente($id)
    {
        try {
            $sql = "SELECT c.*, ec.descricao FROM cliente c INNER JOIN  est_civil ec ON ec.id = c.fkidEstCivil WHERE c.id = :id"; // FAÇO a consulta sql
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            $p_sql->execute(); // pego a conexão com o banco **
            $lista = $p_sql->fetchAll(PDO::FETCH_ASSOC); // JOGO O RESULTADO PARA DENTRO DA LISTA - pega o resultado do select e transforma
            // em um vetor associativo

            $cliente = new Cliente();
            foreach ($lista as $item_lista) {
                $cliente = self::popularCliente($item_lista); // retorna um objeto cliente preenchido
            }

            return $cliente;

        }catch (PDOException $e) {
            print "Ocorreu um erro ao executar a consulta";
        }
    }
}