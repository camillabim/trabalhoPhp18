<?php
/**
 * Created by PhpStorm.
 * User: Camilla
 * Date: 11/07/2018
 * Time: 19:36
 */

require_once "ControllerUsuarioSistema.php";

session_start();//sempre startar a sessão quando for trabalhar com ela

if (isset($_POST['entrar'])){
    $usuarioSistema = new UsuarioSistema();
    $usuarioSistema->setEmail($_POST['email']);
    $usuarioSistema->setSenha(md5($_POST['senha']));
    $usuarioSistema->setId(ControllerUsuarioSistema::login($usuarioSistema));
    //echo var_dump($usuarioSistema);
    if($usuarioSistema->getId() > 0){
        $_SESSION['usuario'] = $usuarioSistema->getId(); // dentro da sessão do usuario tem apenas o id
        header('Location: ../Visao/produtos.php');
    }else{
        header('Location: ../Visao/login.html');
    }
}else{
    header('Location: ../Visao/login.html');
}

//a função login vai disparar uma consulta no banco e vai buscar o id
//se nao achar vai retornar 0