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
    $sql = "SELECT * FROM cliente WHERE cpf_cnpj = '$cpf_cnpj'";
    $resultado = mysqli_query($connect, $sql);
    $dados = mysqli_fetch_array($resultado);
    mysqli_close($connect);
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
    <link rel="stylesheet" href="css/style-header.css">
    <link rel="stylesheet" href="css/style-footer.css">
    <link rel="stylesheet" href="css/style-index.css">
    <link rel="stylesheet" href="css/style-login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
</head>
<body>
    <header>
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a class="navbar-brand" href="#">Bem-vindo <?php if(isset($_SESSION['cpf_cnpj_cliente'])){ echo $dados['nome']; } ?></a>
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
                    <li <?php if (backtrace_filename_includes('login.php')) {echo 'class="nav-item active"';} else {echo 'class="nav-item"';}?>>
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
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