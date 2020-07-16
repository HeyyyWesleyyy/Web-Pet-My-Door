<?php 
function backtrace_filename_includes($name){
  $backtrace_array=debug_backtrace();
  if (strpos($backtrace_array[1]['file'],$name)==false){
      return false;
  }else{
      return true;
  }
}
?>

<?php
  require_once 'php/db_connect.php';
  if (!isset($_SESSION)) {
    session_start();
  }
  if(isset($_SESSION['cpf_cnpj_cliente'])){
    $cpf_cnpj = $_SESSION['cpf_cnpj_cliente'];
    $sqlCliente = "SELECT * FROM cliente WHERE cpf_cnpj = '$cpf_cnpj'";
    $sqlProduto = "SELECT * FROM produto";
    $sqlCarrinho = "SELECT * FROM carrinho";
    $resultadoCliente = mysqli_query($connect, $sqlCliente);
    $resultadoProduto = mysqli_query($connect, $sqlProduto);
    $resultadoProdutoAdd = mysqli_query($connect, $sqlProduto);
    $resultadoCarrinho = mysqli_query($connect, $sqlCarrinho);
    $dadosCliente = mysqli_fetch_array($resultadoCliente);
    $dadosCarrinho = mysqli_fetch_array($resultadoCarrinho);
    $_SESSION['carrinho'] = true;
  }
?>

<!DOCTYPE html>
<!--Header-->
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style-header.css">
    <link rel="stylesheet" href="css/style-footer.css">
    <link rel="stylesheet" href="css/style-index.css">
    <link rel="stylesheet" href="css/style-login.css">
    <link rel="stylesheet" href="css/style-produtos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>
<body>
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="#">Bem-vindo <?php if(isset($_SESSION['cpf_cnpj_cliente'])){ echo $dadosCliente['nome']; } ?></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                  <span class="navbar-toggler-icon"></span>
                </button>
              
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav ml-lg-auto">
                    <li <?php if (backtrace_filename_includes('index.php')) {echo 'class="nav-item active"';} else {echo 'class="nav-item"';}?>>
                      <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li <?php if (backtrace_filename_includes('produtos.php')) {echo 'class="nav-item active"';} else {echo 'class="nav-item"';}?>>
                      <a class="nav-link" href="produtos.php">Produtos</a>
                    </li>
                    <?php
                      if(!isset($_SESSION['cpf_cnpj_cliente'])){
                        if (backtrace_filename_includes('login.php')) {echo "<li class='nav-item active'>";} else {echo "<li class='nav-item'>";}
                          echo "<a class='nav-link' href='login.php'>Login</a>
                        </li>"; }
                    ?>
                    <?php
                      if(isset($_SESSION['cpf_cnpj_cliente'])){ echo 
                        "<li class='nav-item'>
                          <a class='nav-link' href='php/logout.php'>Sair</a>
                        </li>"; }
                    ?>
                  </ul>
                </div>
            </nav>
        </div>
    </header>