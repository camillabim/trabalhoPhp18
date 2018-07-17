<?php
/**
 * Created by PhpStorm.
 * User: Camilla
 * Date: 11/07/2018
 * Time: 20:05
 */

session_start();

//destroi todas as sessoes do meu sistema
session_destroy();

unset($_SESSION['usuario']);

//redireciono para o produtos caso não esteja logado
header('Location: ../Visao/produtos.php');