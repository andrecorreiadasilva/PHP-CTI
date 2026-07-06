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
        <title>GKHaven - Redefinir</title>
    </head>
    <body>
        <header>
        </header>
        <nav> 
            <?php nav(); ?>
        </nav>
        <article class="login">
            <div class="caixalogin">
                <h3>Redefinir senha</h3>
                <?php

                    echo "<form action='' method='post'>  
                            <div class='espaco'>
                                <label>Senha</label>
                                <input type='password' name='senha1'>
                            </div>
                            <div class='espaco'>
                                <label>Redigite a senha</label>
                                <input type='password' name='senha2'>
                                <input type='submit' class='logar' value='Alterar'>
                            </div>
                        </form>";

                    if ( $_POST ) {  

                        $conn = conecta();

                        $senha1 = $_POST['senha1'];
                        $senha2 = $_POST['senha2'];
                        
                        // recupera o email salvo como var sessao em esqueci.php
                        
                        $token = $_GET['token'];
                        
                        $email = $_SESSION[$token];

                        // obtem a senha

                        $senha = ValorSQL($conn, "select senha from usuario where email='$email'");     
                        
                        // confere se o token é VERDADEIRO
                        if ( md5 ($senha) <> $token ) {
                            echo "<br>Token invalido !!";
                            exit;
                        }
                        
                        // se o preenchimento da nova senha esta correto
                        // atualiza a senha do usuario !!!

                        if ( $senha1 == $senha2 ) {
                            ExecutaSQL($conn, "update usuario set senha='$senha1' where email='$email'");
                            echo "<br>Senha alterada com sucesso!!";
                        } else {
                            echo "<br>Senhas estão diferentes";
                        }
                        echo "<br><br><a href='index.php'>Voltar</a>";
                    }
                ?>
            </div>
        </article>
        <footer>
        </footer>

        <script src="js/script.js"></script>
    </body>
</html>
</html>