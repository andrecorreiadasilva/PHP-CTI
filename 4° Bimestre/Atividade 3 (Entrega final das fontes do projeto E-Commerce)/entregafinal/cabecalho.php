<?php
    include('util.php');
    include('PHPMailer/PHPMailer/src/PHPMailer.php');
    include('PHPMailer/PHPMailer/src/SMTP.php');
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
    }
?>
