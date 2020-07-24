<?php
    include_once 'header.php';

    function component($imagemProduto, $nomeProduto, $descricaoProduto, $precoProduto, $codProduto){
        $element = "
        <div class='body-produtos'>
            <form action='' method='POST' class='container-produtos'>
                <div class='imgBx'>
                    <img src='$imagemProduto' alt=''>
                </div>
                <div class='details'>
                    <div class='content'>
                        <h2>$nomeProduto<br><span>Versão única</span></h2>
                        <p>$descricaoProduto</p>
                        <h3>R$ $precoProduto</h3>
                        <button name='btn-adicionar'>Adicionar <i class='fas fa-shopping-basket'></i></button>
                        <input type='hidden' name='codProduto' value='$codProduto'>
                    </div>
                </div>
            </form>
        </div>
        ";
        echo $element;
    }

    if(isset($_POST['btn-adicionar'])){
        $erros = array();
        if(isset($_SESSION['carrinho'])){
            $codProduto = $_POST['codProduto'];
            $sqlProdutoAdd = "SELECT * FROM produto WHERE codProduto = '$codProduto'";
            $resultadoProdutoAdd = mysqli_query($connect, $sqlProdutoAdd);
            $dadosProdutoAdd = mysqli_fetch_array($resultadoProdutoAdd);
            $sqlCarrinhoAdd = "SELECT * FROM carrinho WHERE codProduto = '$codProduto'";
            $resultadoCarrinhoAdd = mysqli_query($connect, $sqlCarrinhoAdd);
            if(mysqli_num_rows($resultadoCarrinhoAdd) == 1){
                $erros[] = "Produto já adicionado ao carrinho!";
            } else {
                array_push($_SESSION['carrinho'], $_POST);
                $sqlCarrinhoInserir = "INSERT INTO carrinho (cpf_cnpj_cliente, codProduto, nomeProduto, precoProduto, descricaoProduto) VALUES ('$dadosCliente[cpf_cnpj]', $dadosProdutoAdd[codProduto], '$dadosProdutoAdd[nomeProduto]', $dadosProdutoAdd[precoProduto], '$dadosProdutoAdd[descricaoProduto]')";
                mysqli_query($connect, $sqlCarrinhoInserir);
                header('Location: produtos.php');
            }
        }else{
            $erros[] = "Você precisa estar logado para adicionar itens ao carrinho!";
        }
    }
?>

<div class="background">
    <?php
            if(!empty($erros)){
                foreach($erros as $erro){
                    echo $erro;
                }
            }
            if(!isset($_SESSION['cpf_cnpj_cliente'])){
            $sqlProduto = "SELECT * FROM produto";
            $resultadoProduto = mysqli_query($connect, $sqlProduto);
            }
            $imagem = array('img/Catflap-SUR001-angled-White.png', 'img/Coleira-removebg.png');
            $contador = 0;
            while($dadosProduto = mysqli_fetch_array($resultadoProduto)){
                component($imagem[$contador],
                    $dadosProduto['nomeProduto'],
                    $dadosProduto['descricaoProduto'],
                    $dadosProduto['precoProduto'],
                    $dadosProduto['codProduto']);
                    $contador++;
            }
    ?>
</div>

<script>
    var numbers = document.getElementById('box');
    for (i = 0; i <= 10; i++){
        var span = document.createElement('span');
        span.textContent = i;
        numbers.appendChild(span);
    }

    var num = numbers.getElementsByTagName('span');
    var index = "<?php echo $qtdeCarrinho; ?>";
    function nextNum(){
        num[index].style.display = 'none';
        index = (index + 1) % num.length;
        num[index].style.display = 'initial';
    }

    function prevNum(){
        num[index].style.display = 'none';
        index = (index - 1 + num.length) % num.length;
        num[index].style.display = 'initial';
    }
</script>

<?php
    mysqli_close($connect);
    include_once 'footer.php';
?>