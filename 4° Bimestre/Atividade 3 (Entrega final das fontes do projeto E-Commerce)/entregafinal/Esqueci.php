<!DOCTYPE html>
<html>
    <?php
        include ("utilidades/cabecalho.php");
    ?>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">    
        <link rel="stylesheet" href="style/style.css">
        <link rel="stylesheet" href="style/login.css">
        <title>GKHaven - Esqueci</title>
    </head>
    <body>
        <header>
        </header>
        <nav> 
            <?php nav(); ?>
        </nav>
        <article class="login">
            <div class="caixalogin">
                <h3>Esqueci a senha</h3>
                <?php
                    echo "<form action='' method='post'>
                        <div class='espaco'>
                            <label>Enviar recuperação da senha para:</label>
                            <input type='email' name='email'>
                            <input type='submit' class='logar' value='Enviar'>
                        </div>
                        </form>";

                    if ( $_POST ) {   
                        /*
                            O usuario devera saber qual é o seu email 
                            para poder receber um link de recuperacao.
                            O link de recuperacao é uma chamada GET para um codigo php
                            que vai receber um token, o token recebido na vdd eh a senha antiga 
                            criptografada que foi obtida do email valido informado. 
                            Essa senha sera trocada em redefinir.php.
                            Ao receber o token e verificar se bate com a senha atual, 
                            estamos assegurando que nao houve uma tentativa de quebra de seguranca. 
                            Ai o programa pede nova senha e altera      

                            código por Marcelo C Peres 2023
                        */
                        $conn = conecta();
                        $email = $_POST['email'];
                        $select = $conn->prepare("select nome,senha from usuario where email=:email ");
                        $select->bindParam(':email',$email);
                        $select->execute();
                        $linha = $select->fetch();
                        
                        if ( $linha ) {
                            // md5 é um tipo de criptografia
                            $token = md5($linha['senha']); 
                            $nome = $linha['nome'];
                            $html="<h4>Redefinir sua senha</h4><br>
                                    <b>$nome</b>, <br>
                                    Clique no link para redefinir sua senha:<br>https://projetoscti.com.br/projetoscti03/ecommerce/Redefinir.php?token=$token";
                            
                            $_SESSION[$token]= $email;
                    
                            if ( EnviaEmail ( $email, '* Recupere a sua senha do ecommerce *', $html ) ) {
                                echo "<br><b>Email enviado com sucesso</b> (verifique sua caixa de spam se não encontrar)";
                            }   
                        } 
                    }
                ?>
            </div>
        </article>
        <footer>
        </footer>

        <script src="js/script.js"></script>
    </body>
</html>