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
         <br>Login: <input type='text' name='login' value='$loginCookie'>
         <br>Senha: <input type='password' name='senha'>
         <br><input type='submit' value='Enviar'>
        </form>";

    if ( $_POST ) {
        if (login($_POST['login'], $_POST['senha'], $admin)) {
            $_SESSION['sessaoConectado'] = true;
            $_SESSION['sessaoLogin'] = $_POST['login'];
            $_SESSION['admin'] = $admin;
            header('Location: index.php');
        } else {
            echo "Usuário ou senha incorreto.
                  <br><a href='index.php'>Voltar</a>";
        }
    }
?>