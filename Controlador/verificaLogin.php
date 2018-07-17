<?php
/**
 * Created by PhpStorm.
 * User: Camilla
 * Date: 11/07/2018
 * Time: 19:44
 */

//indico ao arquivo que vou usar session
session_start();

//se a sessão não existir ele retorna ao login.html
if(!isset($_SESSION['usuario'])){
    header('Location: ../Visao/login.html');
}