<?php
require_once 'Autoload.php';

$instancia = new \SON\Cliente\ListaClientes();
$listaClientes = $instancia->getList();

$ordenarValue = 'desc';
$ordenarLabel = 'Descendente';

if(isset($_GET['ordenacao'])){

    if($_GET['ordenacao'] == 'desc'){
        $ordenarValue = 'asc';
        $ordenarLabel = 'Ascendente';
    }else{
        $ordenarValue = 'desc';
        $ordenarLabel = 'Descendente';
    }
    $listaClientes = $instancia->orderList($ordenarValue);
}


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Cadastro de Clientes</title>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            padding-top: 70px;
            /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
        }
    </style>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Inicio</a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="#">Listar Clientes</a></li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container -->
</nav>

<!-- Page Content -->
<div class="container">
    <style>
        th{text-align: center}
    </style>
    <div class="row">
        <div class="col-lg-12 text-left">
            <table class="table table-bordered">
                <tr>
                    <th>Id</th>
                    <th>Nome</th>
                    <th>Documento</th>
                    <th>Endereco</th>
                    <th>Tipo</th>
                    <th>Acao</th>
                </tr>
                <tr>
                    <form method="get">
                        <input type="hidden" name="ordenacao" value="<?php echo $ordenarValue ?>" />
                        <button type='submit' class='btn btn-success btn-sm'><?php echo $ordenarLabel ?></button>
                    </form>
                    <?php
                    /** @var SON\Cliente\AbstractCliente $cliente */
                    foreach($listaClientes as $key=>$cliente){

                        $filiacao = '';
                        if($cliente instanceof \SON\Cliente\TipoCliente\ClientePessoaFisica){
                            $nome = $cliente->getNome();
                            $documento = $cliente->getCpf();
                            $tipoCliente = $cliente->getLabelTipoCliente();
                            $filiacao = "<br><strong>Filiacao:</strong> {$cliente->getFiliacao()} <br>";
                        }else{
                            $nome = $cliente->getNomeEmpresa();
                            $documento = $cliente->getCnpj();
                            $tipoCliente = $cliente->getLabelTipoCliente();
                        }

                        $enderecoCobranca = '';
                        if($cliente->getEnderecoCobranca()){
                            $enderecoCobranca = "<strong>Endereco de Cobranca:</strong> {$cliente->getEnderecoCobranca()}";
                        }

                        echo "<tr><td>{$key}</td>";
                        echo "<td>{$nome}</td>";
                        echo "<td>{$documento}</td>";
                        echo "<td>{$cliente->getEndereco()}</td>";
                        echo "<td>".$tipoCliente."</td>";
                        echo "<td class='text-center'><button type='button' class='btn btn-primary btn-sm' data-toggle='modal' data-target='#myModal{$key}'>Ver Detalhes</button></td>";

                        echo "<div class='modal fade' id='myModal{$key}' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
                                  <div class='modal-dialog' role='document'>
                                    <div class='modal-content'>
                                      <div class='modal-header'>
                                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
                                        <h4 class='modal-title' id='myModalLabel'>Detalhes</h4>
                                      </div>
                                      <div class='modal-body'>
                                        <strong>Telefone :</strong> {$cliente->getTelefone()} <br>
                                        <strong>Nivel de importancia :</strong> {$cliente->getNvlImportancia()}<br>
                                        {$enderecoCobranca}
                                        {$filiacao}
                                      </div>
                                      <div class='modal-footer'>
                                        <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
                                        <button type='button' class='btn btn-primary'>Save changes</button>
                                      </div>
                                    </div>
                                  </div>
                                </div>";
                        echo '</tr>';
                    }
                    ?>
                </tr>
            </table>
        </div>
    </div>
    <!-- /.row -->

</div>
<!-- /.container -->

<!-- jQuery Version 1.11.1 -->
<script src="js/jquery.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="js/bootstrap.min.js"></script>

</body>

</html>
