<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecommerce</title>
</head>
<body>
    <img width=492 height=202 src='img/cti.png'><br>
</body>
</html>

<?php
    session_start();
    if ( isset($_SESSION['sessaoConectado']) ) {
        $sessaoConectado = $_SESSION['sessaoConectado'];
        $login = $_SESSION['sessaoLogin'];
    }
    else {
        $sessaoConectado = false;
    }

    if ( $sessaoConectado ) {
        $idSessao = session_id();
        echo "<a href='logout.php'>Sair</a>
            <br>Olá, $login (id sessão:<b>$idSessao</b>)
            <br>
            <a href='produtos.php'>Produtos</a>
            <a href='usuarios.php'>Usuários</a>";
    }
    else {
        echo "<a href='login.php'>Login</a>";
    }
    echo "<hr>";
?>