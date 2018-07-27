<?php
/**
 * Created by PhpStorm.
 * User: Camilla
 * Date: 30/06/2018
 * Time: 19:36
 */

require_once "../Modelo/Cliente.class.php";
require_once "../Controlador/ControllerMarca.php";
require_once "../Controlador/ControllerCategoria.php";
require_once "../Controlador/ControllerProdutos.php";
require_once "../Controlador/ControllerProfissao.php";
require_once "../Controlador/ControllerEstCivil.php";
require_once "../Controlador/ControllerCliente.php";
require_once "../Controlador/Conexao.php";
require_once "../controlador/verificaLogin.php";

$cliente = new Cliente();

if(isset($_GET['id'])){
    $cliente = ControllerCliente::buscarCliente($_GET['id']);
}


//Busca todos as profissões do banco
$listaProfissao = ControllerProfissao::buscarTodos();

//Busca todos os estados civil do banco
$listaEstCivil = ControllerEstCivil::buscarTodos();


if (isset($_POST['enviar'])){
    $cliente->setId($_POST['id']);
    $cliente->setNome($_POST['nome']);
    $cliente->setEmail($_POST['email']);
    $cliente->setTelefone($_POST['telefone']);
    $cliente->setEndereco($_POST['endereco']);
    $cliente->setSexo($_POST['sexo']);
    $cliente->setProfissao($_POST['profissao']);
    $cliente->getEstCivil()->setId($_POST['estcivil']);

    ControllerCliente::salvar($cliente);

    header('Location: clientes.php');
}

?>

<!DOCTYPE html>
<html>

<html lang="pt-br">
<head>
    <title>VendaS/A - Aqui você encontra de tudo!</title>
    <!-- Configurando bootstrap-->
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <meta http-equiv="Content-Language" content="pt-br">

    <style>
        h5{
            color: #6c757d;
            padding: 5px;
            font-size: 18pt;
        }

        a:hover h5{
            color: white;
            transition:all 0.3s ease;
            animation: none;
            text-decoration: none;
        }

        a{
            text-decoration: none;
        }

        a :active{
            color: black;

        }

        h3{
            color: #005cbf;
            font-family: Roboto;
            padding-top: 35px;
        }

    </style>
</head>
<body>


<section id="cabecalho">

    <nav class="navbar navbar-expand-lg navbar-light bg-light col-12">
        <h3>VendaS/A  </h3>

        <div class="col-md-1 d-md-block row">
            <br>
            <ul class="nav nav-tabs">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Cadastro</a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="produtos.php">Produtos</a>
                        <a class="dropdown-item" href="clientes.php">Clientes</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="marca.php">Marcas</a>
                        <a class="dropdown-item" href="categoria.php">Categoria</a>
                    </div>
                </li>
            </ul>

            <div class="col-md-8 d-md-block">
                <li class="btn-group btn-danger ">
                    <a class="nav-link" data-toggle="modal" data-target="#exampleModal">
                        <i class="btn-group"></i>Sair</a>
                </li>
            </div>
        </div>
        <div class="col-12 text-center">
            <?php
            if(($_SESSION['usuario'])!=null){
                echo 'Olá! Seja bem-vindo(a) '. unserialize($_SESSION['usuario'])->getNome();
            }
            ?>
        </div>
    </nav>

</section>



<div class="col-md-12 d-md-block">


    <div class="col-10 offset-1">
        <form action="#" method="post"> <!-- # chama o proprio arquivo-->
            <input type="hidden" name="id" value="<?php echo $cliente->getId();?>">
            <div class="form-group row">
                <div class="col-12">
                    <label>Nome: </label>
                    <input type="text" name="nome" placeholder="Digite seu nome" class="form-control" value="<?php echo $cliente->getNome();?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label>E-mail:</label>
                    <input type="email" name="email" placeholder="email@site.com.br" class="form-control" value="<?php echo $cliente->getEmail();?>">
                </div>
            </div>
            <div class="form-group row">
                <div class="col-6">
                    <label>Telefone:</label>
                    <input type="tel" name="telefone" placeholder="(00)0.0000-0000" class="form-control" value="<?php echo $cliente->getTelefone();?>">
                </div>

                <div class="col-6">
                    <label class="label">Sexo</label>
                    <select name="sexo" class="form-control">
                        <?php
                        if($cliente->getSexo() == 'F') {
                            ?>

                            <option value="F" selected>Feminino</option>
                            <option value="M">Masculino</option>
                            <?php
                        }else{
                            ?>
                            <option value="F">Feminino</option>
                            <option value="M" selected>Masculino</option>
                            <?php
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-12">
                    <label>Endereço:</label>
                    <input type="text" name="endereco" placeholder="Digite seu endereço" class="form-control" value="<?php echo $cliente->getEndereco();?>">
                </div>
            </div>



            <div class="form-group row">
                <div class="col-6">
                    <label>Profissão: </label>
                    <select name="profissao" class="form-control">
                        <?php
                        foreach ($listaProfissao as $profissao) {
                            if($cliente->getProfissao()->getId() == $profissao->getId()){
                                echo "<option value='".$profissao->getId()."' selected>".$profissao->getProfissao()."</option>";
                            }else{
                                echo "<option value='".$profissao->getId()."'>".$profissao->getProfissao()."</option>";
                            }
                        }

                        ?>
                    </select>
                </div>



                <div class="col-6">
                    <label class="label">Estado Civil</label>
                    <select name="estcivil" class="form-control">
                        <?php
                        foreach ($listaEstCivil as $estcivil) {
                            if($cliente->getEstCivil()->getId() == $estcivil->getId()){
                                echo "<option value='".$estcivil->getId()."' selected>".$estcivil->getDescricao()."</option>";
                            }else{
                                echo "<option value='".$estcivil->getId()."'>".$estcivil->getDescricao()."</option>";
                            }
                        }

                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group row col-md-6">
                <button type="submit" class="btn btn-success" name="enviar">Salvar</button>
                <a href="clientes.php" class="btn btn-danger">Cancelar</a>
            </div>
        </form>
    </div>


</div>


<section id="modalSair">
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Pronto para sair?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Selecione "Sair" se está pronto para sair da sessão.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="../Controlador/logout.php">Sair</a>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Configurando javascript bootstrap  -->
<script src="../js/jquery-3.3.1.min.js"></script>
<script src="../js/bootstrap.min.js"></script>

</body>

</html>
