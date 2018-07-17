<?php
/**
 * Created by PhpStorm.
 * User: Camilla
 * Date: 08/05/2018
 * Time: 20:08
 */

require_once "../Modelo/UsuarioSistema.class.php";
require_once "Conexao.php";

class ControllerUsuarioSistema
{
    /*realizar a comunicação com o banco*/

    //feito este construtor para nao conseguir instanciar a classe
    private function __construct(){

    }


    private static function inserir(UsuarioSistema $usuarioSistema)
    {
        try {
            $sql = "INSERT INTO usuariosistema (nome, sobrenome, email, senha) VALUES (";
            $sql .= ":nome,";
            $sql .= ":sobrenome,";
            $sql .= ":email,";
            $sql .= ":senha)";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":nome", $usuarioSistema->getNome());
            $p_sql->bindValue(":sobrenome", $usuarioSistema->getSobrenome());
            $p_sql->bindValue(":email", $usuarioSistema->getEmail());
            $p_sql->bindValue(":senha", $usuarioSistema->getSenha());

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
            $sql = "SELECT * FROM usuariosistema us ORDER BY us.nome"; // ORDENADO POR NOME
            $resultado = Conexao::getInstance()->query($sql); // pego a conexão com o banco ** QUERY NO SELECT
            $lista = $resultado->fetchAll(PDO::FETCH_ASSOC); // JOGO O RESULTADO PARA DENTRO DA LISTA

            $vetor_lista = array(); // vetor de objetos
            foreach ($lista as $item_lista) {
                $vetor_lista[] = self::popularUsuario($item_lista); // retorna um objeto cliente preenchido
            }
            return $vetor_lista;
        } catch (Exception $e) {
            print "Ocorreu um erro ao executar a consulta";
        }
    }

    private static function alterar(UsuarioSistema $usuarioSistema){
        try{
            $sql = "UPDATE usuariosistema us SET nome = :nome, sobrenome = :sobrenome, email = :email, senha = :senha WHERE us.id = :id";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":nome", $usuarioSistema->getNome());
            $p_sql->bindValue(":sobrenome", $usuarioSistema->getSobrenome());
            $p_sql->bindValue(":email", $usuarioSistema->getEmail());
            $p_sql->bindValue(":senha", $usuarioSistema->getSenha());
            $p_sql->bindValue(":id", $usuarioSistema->getId());

            return $p_sql->execute();
        } catch (PDOException $e) {
            print "Ocorreu um erro ao executar a alteração";
        }
    }

    public static function salvar(UsuarioSistema $usuarioSistema){
        if($usuarioSistema->getId( ) <= 0){
            return self::inserir($usuarioSistema);
        }else{
            return self::alterar($usuarioSistema);
        }
    }

    public static function excluir($id)
    {
        try {
            $sql = "DELETE FROM usuariosistema WHERE id = :id";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            return $p_sql->execute();
        } catch (Exception $e) {
            print "Ocorreu um erro ao executar a exclusão";
        }
    }

    private static function popularUsuario($itemLista)
    {
        $usuarioSistema = new UsuarioSistema();
        $usuarioSistema->setId($itemLista['id']);
        $usuarioSistema->setNome($itemLista['nome']);
        $usuarioSistema->setSobrenome($itemLista['sobrenome']);
        $usuarioSistema->setEmail($itemLista['email']);

        return $usuarioSistema;
    }

    /**
     * @param $id
     * @return string
     */

    public static function buscarUsuario($id)
    {
        try {
            $sql = "SELECT * FROM usuariosistema us WHERE us.id = :id"; // FAÇO a consulta sql
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":id", $id);
            $p_sql->execute(); // pego a conexão com o banco **
            $lista = $p_sql->fetchAll(PDO::FETCH_ASSOC); // JOGO O RESULTADO PARA DENTRO DA LISTA - pega o resultado do select e transforma
            // em um vetor associativo

            $usuarioSistema = new UsuarioSistema();
            foreach ($lista as $item_lista) {
                $usuarioSistema = self::popularUsuario($item_lista); // retorna um objeto cliente preenchido
            }

            return $usuarioSistema;

        }catch (PDOException $e) {
            print "Ocorreu um erro ao executar a consulta";
        }
    }

    public static function login(UsuarioSistema $usuarioSistema){
        try {
            $sql = "SELECT id, nome, sobrenome, email FROM usuariosistema WHERE email = :email AND senha = :senha"; // FAÇO a consulta sql
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":email", $usuarioSistema->getEmail());
            $p_sql->bindValue(":senha", $usuarioSistema->getSenha());
            $p_sql->execute(); // pego a conexão com o banco **
            $lista = $p_sql->fetchAll(PDO::FETCH_ASSOC); // JOGO O RESULTADO PARA DENTRO DA LISTA - pega o resultado do select e transforma


            $usuarioRet = new UsuarioSistema();
            foreach ($lista as $item_lista) {
                $usuarioRet = self::popularUsuario($item_lista); // retorna um objeto cliente preenchido
            }

            return $usuarioRet->getId();

        }catch (PDOException $e) {
            print "Ocorreu um erro ao executar a consulta";
        }
    }
}