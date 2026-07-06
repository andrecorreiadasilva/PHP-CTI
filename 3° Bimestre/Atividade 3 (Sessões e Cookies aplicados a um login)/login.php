<?php
    include('cabecalho.php');

    $_SESSION['sessaoConectado'] = false;
    $_SESSION['sessaoLogin'] = "";

    if ( isset($_COOKIE['loginCookie']) ) {
        $loginCookie = $_COOKIE['loginCookie'];
    } else {
        $loginCookie = '';
    }

    echo "
        <form name='formlogin' method='post' action=''>
         <br>Login<input type='text' name='login' value='$loginCookie'>
         <br>Senha<input type='password' name='senha'>
         <br><input type='submit' value='Enviar'>
        </form>";

    if ( $_POST ) {
        $login = $_POST['login'];
        $senha = $_POST['senha'];
        setcookie('loginCookie', $login, time()+86400);

        if ( $login=='admin@email' and $senha=='123' ) {
            $_SESSION['sessaoConectado'] = true;
            $_SESSION['sessaoLogin'] = $login;
            header('Location: index.php');
        } else {
            echo "<b>Usuário ou senha não encontrado</b>
                <br><br><a href='index.php'>Voltar</a>";
        }
    }
?>