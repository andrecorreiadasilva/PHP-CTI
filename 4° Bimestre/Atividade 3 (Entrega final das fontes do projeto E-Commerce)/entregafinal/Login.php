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
        <title>GKHaven - Login</title>
    </head>
    <body>
        <header>
        </header>
        <nav> 
            <?php nav(); ?>
        </nav>
        <article class="login">
            <div class="caixalogin">
                <h3>Login</h3>
                <?php                    
                    $_SESSION['sessaoConectado'] = false;
                    $_SESSION['sessaoLogin'] = "";
                
                    if ( isset($_COOKIE['loginCookie']) ) {
                        $loginCookie = $_COOKIE['loginCookie'];
                    } else {
                        $loginCookie = '';
                    }

                    echo "<form name='formlogin' method='post' action=''>
                            <div class='espaco'>
                                <label>Email:</label>
                                <input type='text' name='login' value='$loginCookie'>
                            </div>
                            <div class='espaco'>
                                <label>Senha:</label>
                                <input type='password' name='senha'>
                            </div>
                            <div class='espaco' id='logar'>
                                <a href='Esqueci.php'>Esqueci minha senha</a><br><br>
                                <button type='submit' class='logar'>Logar</button>
                                <a href='Cadastrar.php'>Não tem uma conta? Cadastre aqui!</a>
                            </div>
                           </form>";
                    if ( $_POST ) {
                        if (login($_POST['login'], $_POST['senha'], $admin)) {
                            $_SESSION['sessaoConectado'] = true;
                            $_SESSION['sessaoLogin'] = $_POST['login'];
                            $_SESSION['admin'] = $admin;
                            header('Location: Home.php');
   
                        } else {
                            echo "<script>window.alert('Informações incorretas');</script>";
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
