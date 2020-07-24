<?php
    include_once 'header.php';

    function dateEmMysql($dateSql){
        $ano= substr($dateSql, 6);
        $mes= substr($dateSql, 3,-5);
        $dia= substr($dateSql, 0,-8);
        return $ano."-".$mes."-".$dia;
    }

    function componentCart($imagemProduto, $nomeProduto, $descricaoProduto, $qtdeProduto, $precoProduto, $codProduto){
        $element = "
        <form action='' method='POST' class='container-produtos-cart'>
            <div class='imgBx-cart'>
                <img src='$imagemProduto' alt=''>
            </div>
            <div class='details-cart'>
                <div class='content-cart'>
                    <h2>$nomeProduto<br><span>Versão única</span></h2>
                    <p>$descricaoProduto</p>
                    <div class='qtde'>
                        <h2><span>Quantidade: </span></h2>
                        <input type='number' name='qtdeProduto' value='$qtdeProduto' min='1'>
                        </input>
                    </div>
                    <h3>R$ $precoProduto</h3>
                    <button name='btn-remover' class='btn-remover'>Remover <i class='fas fa-shopping-basket'></i></button>
                    <button name='btn-salvar' class='btn-salvar'>Salvar <i class='fas fa-shopping-basket'></i></button>
                    <input type='hidden' name='codProduto' value='$codProduto'>
                </div>
            </div>
        </form>
        ";
        echo $element;
    }

    if(isset($_POST['btn-salvar'])){
        $erros = array();
        if(isset($_SESSION['carrinho'])){
            $codProduto = mysqli_escape_string($connect, $_POST['codProduto']);
            $qtdeProduto = mysqli_escape_string($connect, $_POST['qtdeProduto']);
            $sqlCarrinhoSalvar = "UPDATE carrinho SET qtdeProduto = $qtdeProduto WHERE codProduto = '$codProduto'";
            mysqli_query($connect, $sqlCarrinhoSalvar);
            header('Location: carrinho.php');
        }else{
            $erros[] = "Você precisa estar logado para excluir itens do carrinho!";
        }
    }

    if(isset($_POST['btn-remover'])){
        $erros = array();
        if(isset($_SESSION['carrinho'])){
            $codProduto = mysqli_escape_string($connect, $_POST['codProduto']);
            if (!empty($_SESSION['carrinho'])) {
                foreach(array_keys($_SESSION['carrinho'], $_POST['codProduto'], true) as $key){
                    unset($_SESSION['carrinho'][$key]);
                }
            }
            $sqlCarrinhoExcluir = "DELETE FROM carrinho WHERE codProduto = '$codProduto'";
            mysqli_query($connect, $sqlCarrinhoExcluir);
            header('Location: carrinho.php');
        }else{
            $erros[] = "Você precisa estar logado para excluir itens do carrinho!";
        }
    }

    if(isset($_POST['btn-venda'])){
        $erros = array();
        if(isset($_SESSION['carrinho'])){
            date_default_timezone_set('America/Sao_Paulo');
            $dataVenda = date('d-m-Y');
            $dataVenda = dateEmMysql($dataVenda);
            $soma = 0;
            $sqlCarrinhoTotal = "SELECT * FROM carrinho WHERE cpf_cnpj_cliente = '$dadosCliente[cpf_cnpj]'";
            $resultadoCarrinhoTotal = mysqli_query($connect, $sqlCarrinho);
            while($dadosCarrinhoTotal = mysqli_fetch_array($resultadoCarrinhoTotal)){
                foreach ($total as $key => $value){
                    $soma += $dadosCarrinhoTotal['qtdeProduto'] * $dadosCarrinhoTotal['precoProduto'];
                }
            }
            $soma = number_format($soma, 2, '.', '');
            $sqlConcluirVenda = "INSERT INTO venda (cpf_cnpj_cliente, precoTotal, dataVenda) VALUES ('$dadosCliente[cpf_cnpj]', '$soma', '$dataVenda')";
            $dadosConcluirVenda = mysqli_query($connect, $sqlConcluirVenda);
            $sqlCountVenda = "SELECT COUNT(codVenda) FROM venda WHERE cpf_cnpj_cliente = '$dadosCliente[cpf_cnpj]'";
            $resultadoCountVenda = mysqli_query($connect, $sqlCountVenda);
            $dadosCountVenda = mysqli_fetch_array($resultadoCountVenda);
            if($dadosCountVenda['COUNT(codVenda)'] >= 0){
                $sqlVenda = "SELECT * FROM venda WHERE cpf_cnpj_cliente = '$dadosCliente[cpf_cnpj]'";
                $resultadoVenda = mysqli_query($connect, $sqlVenda);
                $dadosVenda = mysqli_fetch_array($resultadoVenda);
                while($dadosVenda = mysqli_fetch_array($resultadoVenda)){ //muda chave primária codVenda
                    $sqlCarrinhoPedido = "SELECT * FROM carrinho WHERE cpf_cnpj_cliente = '$dadosCliente[cpf_cnpj]'";
                    $resultadoCarrinhoPedido = mysqli_query($connect, $sqlCarrinhoPedido);
                    while($dadosCarrinhoPedido = mysqli_fetch_array($resultadoCarrinhoPedido)){
                        $sqlPedidoRows = "SELECT * FROM pedido";
                        $resultadoPedidoRows = mysqli_query($connect, $sqlPedidoRows);
                        $dadosPedidoRows = mysqli_fetch_array($resultadoPedidoRows);
                        $sqlPedidoExiste = "SELECT * FROM pedido WHERE codVenda = $dadosVenda[codVenda] AND codProduto = $dadosCarrinhoPedido[codProduto]";
                        $resultadoPedidoExiste = mysqli_query($connect, $sqlPedidoExiste);
                        if(mysqli_num_rows($resultadoPedidoExiste) == 0){
                            $sqlPedido = "INSERT INTO pedido (codVenda, codProduto, nomeProduto, qtdeProduto, precoProduto, descricaoProduto) VALUES ('$dadosVenda[codVenda]', '$dadosCarrinhoPedido[codProduto]', '$dadosCarrinhoPedido[nomeProduto]', '$dadosCarrinhoPedido[qtdeProduto]', '$dadosCarrinhoPedido[precoProduto]', '$dadosCarrinhoPedido[descricaoProduto]')";
                            $resultadoPedido = mysqli_query($connect, $sqlPedido);
                            $sqlCarrinhoExcluir = "DELETE FROM carrinho WHERE codProduto = '$dadosCarrinhoPedido[codProduto]'";
                            mysqli_query($connect, $sqlCarrinhoExcluir);
                        }
                    }
                }
                header('Location: produtos.php');
            } 
        }
    }
?>

<div class="background-cart">
    <div class='body-produtos-cart'>
        <?php
            $imagem = array('img/Catflap-SUR001-angled-White.png', 'img/Coleira-removebg.png');
            $contador = 0;
            while($dadosCarrinho = mysqli_fetch_array($resultadoCarrinho)){
                componentCart($imagem[$contador],
                    $dadosCarrinho['nomeProduto'],
                    $dadosCarrinho['descricaoProduto'],
                    $dadosCarrinho['qtdeProduto'],
                    $dadosCarrinho['precoProduto'],
                    $dadosCarrinho['codProduto']);
                    $contador++;
            }
        ?>
    </div>
    <form action='' method='POST' class='container-venda'>
        <div class="top">
            <h1>Finalizar compra</h1>
        </div>
        <div class="package-container">
            <div class="packages">
                <h1>Detalhes da compra:</h1>
                <?php
                    $sqlCarrinho = "SELECT * FROM carrinho WHERE cpf_cnpj_cliente = '$cpf_cnpj'";
                    $resultadoCarrinho = mysqli_query($connect, $sqlCarrinho);
                    $soma = 0;
                    while($dadosCarrinho = mysqli_fetch_array($resultadoCarrinho)){
                        foreach ($total as $key => $value){
                            $soma += $dadosCarrinho['qtdeProduto'] * $dadosCarrinho['precoProduto'];
                        }
                    }
                    $soma = number_format($soma, 2, '.', '');
                    echo "<h2 class='text1'>Total: R$ $soma</h2>"
                ?>
                <h2 class="text2">Itens:</h2>
                <ul class="list">
                    <?php 
                        $sqlCarrinho = "SELECT * FROM carrinho WHERE cpf_cnpj_cliente = '$cpf_cnpj'";
                        $resultadoCarrinho = mysqli_query($connect, $sqlCarrinho);
                        $sqlCarrinhoFirst = "SELECT min(codProduto) FROM carrinho";
                        $resultadoCarrinhoFirst = mysqli_query($connect, $sqlCarrinhoFirst);
                        $dadosCarrinhoFirst = mysqli_fetch_array($resultadoCarrinhoFirst);
                        while($dadosCarrinho = mysqli_fetch_array($resultadoCarrinho)){
                            echo "<li ";
                            if($dadosCarrinho['codProduto'] == $dadosCarrinhoFirst['min(codProduto)']){
                                echo "class='first'";
                            }
                            echo ">$dadosCarrinho[nomeProduto]</li>";
                        }
                    ?>
                </ul>
                <button name="btn-venda" class="btn-venda">Concluir <i class='fas fa-shopping-basket'></i></button>
            </div>
        </div>
    </form>   
</div>

<?php
    include_once 'footer.php';
?>