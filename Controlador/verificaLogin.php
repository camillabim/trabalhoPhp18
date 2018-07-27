<?php
/**
 * Created by PhpStorm.
 * User: Camilla
 * Date: 11/07/2018
 * Time: 19:44
 */

require_once "../Modelo/UsuarioSistema.class.php";
$usuarioLogado = new UsuarioSistema();

//indico ao arquivo que vou usar session
session_start();

//se a sessão não existir ele retorna ao login.html
if(!isset($_SESSION['usuario'])){
    header('Location: ../Visao/login.html');
}else{
    $usuarioLogado = unserialize($_SESSION['usuario']);
}