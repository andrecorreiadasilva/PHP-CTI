<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-commerce</title>
</head>
<body>
    <img width=492 height=202 src='img/cti.png'><br>
</body>
</html>

<?php
    include('util.php');
    session_start();

    if (isset($_COOKIE['idSessao'])) {
        $idSessao = $_COOKIE['idSessao'];
    }

    if (isset($_SESSION['sessaoConectado'])) {
        $sessaoConectado = $_SESSION['sessaoConectado'];
        $login = $_SESSION['sessaoLogin'];
    } else {
        $sessaoConectado = false;
    }

    if ($sessaoConectado) {
        if (!isset($_COOKIE['idSessao'])) {
            $idSessao = session_id();
            setcookie('idSessao', $idSessao, time()+86400);
        }
        echo "Olá, $login (id sessão: <b>$idSessao</b>)
            <br><a href='logout.php'>Sair</a><br><br>";

        if ( $_SESSION['admin'] )
        {
            echo "<a href='produtos.php'>Produtos</a>
                <a href='usuarios.php'>Usuários</a> ";
        }

        echo "<a href='carrinho.php'>Carrinho</a>";
    } else {
        echo "<a href='login.php'>Login</a>";
    }
    echo "<br><br><a href='index.php'>Página Inicial</a>";
    echo "<hr>";
?>
