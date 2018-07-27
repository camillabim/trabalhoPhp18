<?php

require_once "../Modelo/UsuarioSistema.class.php";
require_once "../Controlador/ControllerUsuarioSistema.php";
require_once "../Controlador/Conexao.php";

$usuarioSistema = new UsuarioSistema();


    if (isset($_POST['enviar'])) {
        $usuarioSistema->setId($_POST[0]);
        $usuarioSistema->setNome($_POST['nome']);
        $usuarioSistema->setSobrenome($_POST['sobrenome']);
        $usuarioSistema->setEmail($_POST['email']);
        $usuarioSistema->setSenha(md5($_POST['senha'])); // encriptografada

        ControllerUsuarioSistema::salvar($usuarioSistema);

        header('Location: login.html');
    }

if(isset($_GET['id'])){
    $usuarioSistema = ControllerUsuarioSistema::buscarUsuario($_GET['id']);
}

?>

<!DOCTYPE html>
<html lang="pt">



<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>VendaS/A</title>
  <!-- Bootstrap core CSS-->
  <!-- Bootstrap core CSS-->
  <link rel="stylesheet" href="../css/estilo.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">

</head>

<body class="bg-info">
  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Registre uma conta</div>
      <div class="card-body">
          <form action="#" method="post">
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputName" >Primeiro Nome</label>
                <input class="form-control" id="exampleInputName" name="nome" type="text" aria-describedby="nameHelp" placeholder="Entre com seu primeiro nome">
              </div>
              <div class="col-md-6">
                <label for="exampleInputLastName" >Último nome</label>
                <input class="form-control" id="exampleInputLastName" name="sobrenome" type="text" aria-describedby="nameHelp" placeholder="Entre com seu último nome">
              </div>
            </div>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail1">Email</label>
            <input class="form-control" id="exampleInputEmail1" name="email" type="email" aria-describedby="emailHelp" placeholder="Entre com o seu email">
          </div>
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <label for="exampleInputPassword1">Senha</label>
                <input class="form-control" id="exampleInputPassword1" name="senha" type="password" placeholder="Senha">
              </div>
              <div class="col-md-6">
                <label for="exampleConfirmPassword">Confirmar senha</label>
                <input class="form-control" id="exampleConfirmPassword" type="password" name="senha1" placeholder="Confirme sua senha">
              </div>
            </div>
          </div>
          <button class="btn btn-info btn-block" type="submit" name="enviar">Registre-se</button>

        </form>
        <!--<div class="text-center">-->
          <!--<a class="d-block small mt-3" href="login.html">Login Page</a>-->
          <!--<a class="d-block small" href="forgot-password.html">Forgot Password?</a>-->
        <!--</div>-->
      </div>
    </div>
  </div>
  <script src="../js/jquery-3.3.1.min.js"></script>
  <script src="../js/bootstrap.min.js"></script>
</body>

</html>
