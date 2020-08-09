<?php
    require_once 'php/db_connect.php';

    session_start();

    if(isset($_SESSION['cpf_cnpj_cliente'])){
        header('Location: index.php');
    }

    if(isset($_POST['btn-entrar'])){
        $login = mysqli_escape_string($connect, $_POST['login']);
        $senha = mysqli_escape_string($connect, $_POST['senha']);
        if(empty($login) or empty($senha)){
            $_SESSION['mensagem'] = "O campo login e senha precisam ser preenchidos.";
        } else {
            $sql = "SELECT * FROM cliente WHERE nome = '$login'";
            $resultado = mysqli_query($connect, $sql);
            if(mysqli_num_rows($resultado) > 0){
                $dados = mysqli_fetch_assoc($resultado);
                if(password_verify($senha, $dados['senha'])){
                    $sql = "SELECT * FROM cliente WHERE nome = '$login' AND senha = '$dados[senha]'";
                    $resultado = mysqli_query($connect, $sql);
                    if(mysqli_num_rows($resultado) == 1){
                        $dados = mysqli_fetch_array($resultado);
                        mysqli_close($connect);
                        $_SESSION['logado'] = true;
                        $_SESSION['cpf_cnpj_cliente'] = $dados['cpf_cnpj'];
                        header('Location: index.php');
                    } 
                } else {
                    $_SESSION['mensagem'] = "Usuário e senha não conferem!";
                }
            } else {
                $_SESSION['mensagem'] = "Usuário inexistente!";
            }
        }
    }


    if(isset($_POST['btn-cadastrar'])){
        $nome = mysqli_escape_string($connect, $_POST['nome']);
        $senha = mysqli_escape_string($connect, $_POST['senha']);
        $cpfcnpj = mysqli_escape_string($connect, $_POST['cpfcnpj']);
        $telefone = mysqli_escape_string($connect, $_POST['telefone']);
        $endereco = mysqli_escape_string($connect, $_POST['endereco']);
        if(empty($nome) or empty($senha) or empty($cpfcnpj) or empty($telefone) or empty($endereco)){
            $_SESSION['mensagem'] = "Todos os campos precisam ser preenchidos.";
        } else {
            $sql = "SELECT cpf_cnpj FROM cliente WHERE cpf_cnpj = '$cpfcnpj'";
            $resultado = mysqli_query($connect, $sql);
            if(mysqli_num_rows($resultado) == 1){
                $_SESSION['mensagem'] = "Usuário já cadastrado!";
            } else {
                $senhaSegura = password_hash($senha, PASSWORD_DEFAULT);
                $sql = "INSERT INTO cliente (cpf_cnpj, nome, senha, telefone, endereco) VALUES ('$cpfcnpj', '$nome', '$senhaSegura', '$telefone', '$endereco')";
                if(mysqli_query($connect, $sql)){
                    $sql = "SELECT * FROM cliente WHERE cpf_cnpj = '$cpfcnpj'";
                    $resultado = mysqli_query($connect, $sql);
                    if(mysqli_num_rows($resultado) == 1){
                        $dados = mysqli_fetch_array($resultado);
                        mysqli_close($connect);
                        $_SESSION['logado'] = true;
                        $_SESSION['cpf_cnpj_cliente'] = $dados['cpf_cnpj'];
                        header('Location: index.php');
                    } else {
                        $_SESSION['mensagem'] = "Usuário e senha não conferem!";
                    }
                } else {
                    $_SESSION['mensagem'] = "Não foi possível cadastrar!";
                }
            }
        }
    }

    include_once 'header.php';
?>

<div class="container-slider">
    <video autoplay muted id="video1" class="video1">
        <source src="videos/dog 1.mp4" type="video/mp4">
    </video>

    <video muted id="video2" class="video2">
        <source src="videos/cat 1.mp4" type="video/mp4">
    </video>

    <video muted id="video3" class="video3">
        <source src="videos/dog 2.mp4" type="video/mp4">
    </video>

    <video muted id="video4" class="video4">
        <source src="videos/cat 2.mp4" type="video/mp4">
    </video>

    <video muted id="video5" class="video5">
        <source src="videos/dog 3.mp4" type="video/mp4">
    </video>

    <video muted id="video6" class="video6">
        <source src="videos/cat 3.mp4" type="video/mp4">
    </video>
    <section>
        <div class="container-login">
            <div class="user signinBx">
                <div class="imgBx">
                    <img src="img/adoravel-animal-animal-de-estimacao-animal-domestico-1741205.jpg" alt="">
                </div>
                <div class="formBx">
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                        <h2>Fazer Login</h2>
                        <input type="text" name="login" id="" placeholder="Nome de usuário">
                        <input type="password" name="senha" id="" placeholder="Senha">
                        <input type="submit" name="btn-entrar" value="Entrar">
                        <p class="signup">Não possui um cadastro? <a href="#" onclick="toggleForm();">Cadastrar-se</a></p>
                    </form>
                </div>
            </div>
            <div class="user signupBx">
                <div class="formBx">
                    <form action="" method="POST">
                        <h2>Criar uma conta</h2>
                        <input type="text" name="nome" id="" placeholder="Nome de usuário">
                        <input type="password" name="senha" id="" placeholder="Senha" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}">
                        <input type="text" name="cpfcnpj" id="cpfcnpj" placeholder="CPF/CNPJ" pattern="/^([0-9]{3}\.?[0-9]{3}\.?[0-9]{3}\-?[0-9]{2}|[0-9]{2}\.?[0-9]{3}\.?[0-9]{3}\/?[0-9]{4}\-?[0-9]{2})$/">
                        <input type="tel" name="telefone" id="telefone" placeholder="telefone" pattern="\([0-9]{2}\) [0-9]{4,6}-[0-9]{3,4}$">
                        <input type="text" name="endereco" id="" placeholder="endereço">
                        <input type="submit" name="btn-cadastrar" value="Cadastrar">
                        <p class="signup">Já possui um cadastro? <a href="#" onclick="toggleForm();">Fazer login</a></p>
                    </form>
                </div>
                <div class="imgBx">
                    <img src="img/animal-bicho-cachorro-cao-3009441.png" alt="">
                </div>
            </div>
        </div>    
    </section>
</div>
<?php
    include_once 'footer.php';
?>