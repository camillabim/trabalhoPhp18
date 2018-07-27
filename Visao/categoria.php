<?php
/**
 * Created by PhpStorm.
 * User: Camilla Bim
 * Date: 26/06/2018
 * Time: 19:37
 */

require_once "../controlador/ControllerCategoria.php";
require_once "../controlador/verificaLogin.php";
require_once "../Controlador/ControllerProdutos.php";
require_once "../Modelo/UsuarioSistema.class.php";
require_once "../Controlador/ControllerUsuarioSistema.php";

if(isset($_GET['id'])){
    ControllerCategoria::excluir($_GET['id']); // chamo o método para excluir antes do método de atualizar a página
    header('Location: categoria.php'); //reescreve o cabeçalho da página para nao ficar mostrand sempre o código de exclusão
}

$item = ControllerCategoria::buscarTodos();

?>

<html>

<head>
    <title>VendaS/A - Aqui você encontra de tudo!</title>
    <!-- Configurando bootstrap-->
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">

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


<div class="col-12">

    <table class="table table-hover">

        <a type="button" href="inserirCategoria.php" class="btn btn-primary btn-sm">Cadastrar Novo</a>



        <thead>
        <tr>
            <th width="10%">Código</th>
            <th width="50%">Descrição da Categoria</th>
            <th width="30%">Ações</th>

        </tr>
        </thead>

        <?php
        foreach ($item as $categoria) { //LISTA EH UM VETOR DE MARCA

            echo "<tr>";
            echo "<td width=\"10%\">".$categoria->getId()."</td>" ;
            echo "<td width=\"50%\">".$categoria->getDescricao()."</td>";
            echo "<td width=\"15%\">";

            echo "<a href='categoria.php?id=".$categoria->getId()."' class='btn btn-danger' title='Excluir' alt='Excluir '><img src='../svg/si-glyph-delete.svg' width='15' height='15'></a>";
            echo "<a href='detalheCategoria.php?id=".$categoria->getId()."' class='btn btn-success' title='Detalhes' alt='Detalhes '><img src='../svg/si-glyph-badge-name.svg' width='15' height='15'></a>";
            echo "<a href='inserirCategoria.php?id=".$categoria->getId()."' class='btn btn-info ' title='Editar' alt='Editar'><img src='../svg/si-glyph-edit.svg' width='15' height='15'></a>";



            echo "</td>";
            echo "</tr>";
        }

        ?>

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
