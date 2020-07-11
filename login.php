<?php
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
                    <form action="">
                        <h2>Sign In</h2>
                        <input type="text" name="" id="" placeholder="Nome de usuário">
                        <input type="password" name="" id="" placeholder="Senha">
                        <input type="submit" name="" value="Entrar">
                        <p class="signup">Não possui um cadastro? <a href="#" onclick="toggleForm();">Cadastrar-se</a></p>
                    </form>
                </div>
            </div>
            <div class="user signupBx">
                <div class="formBx">
                    <form action="">
                        <h2>Criar uma conta</h2>
                        <input type="text" name="" id="" placeholder="Nome de usuário">
                        <input type="email" name="" id="" placeholder="Endereço de email">
                        <input type="password" name="" id="" placeholder="Senha">
                        <input type="password" name="" id="" placeholder="Confirmar senha">
                        <input type="submit" name="" value="Cadastrar">
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