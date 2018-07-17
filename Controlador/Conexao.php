<?php
/**
 * Created by PhpStorm.
 * User: Camilla
 * Date: 09/05/2018
 * Time: 19:51
 */

class Conexao{
    private static $instance;

    private function __construct(){//método construtor privado para nao instanciar em outra classe

    }

    //para trocar de banco é só mudar o mysql para postgre por exemplo, oracle, etc.
    public static function getInstance(){
        if(!isset(self::$instance)){//se nao existir conexao
            self::$instance = new PDO('mysql:host=localhost;dbname=trabalhoFinal','root','');//CRIO UMA NOVA INSTANCIA
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//erros de excessao
        }
        return self::$instance; //caso ja exista, retorne a instancia existente
    }
    //PDO é uma classe de conexao já pronta, php data objects.
}