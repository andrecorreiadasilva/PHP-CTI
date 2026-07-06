<?php
    function conecta ($params = "") {
        if ($params == "") {
            $params="";
        }
        $varConn = new PDO($params);
        if (!$varConn) {
            echo "Não foi possível conectar";
        } else { 
            return $varConn; 
        }
    }
    function login ($paramLogin, $paramSenha, &$paramAdmin){
        $conn = conecta();
        setcookie('loginCookie', $paramLogin, time()+86400);

        $varSQL = "SELECT senha, admin
                   FROM usuario
                   WHERE email = :paramLogin";
        
        $select = $conn -> prepare($varSQL);
        $select -> bindParam(':paramLogin', $paramLogin);
        $select -> execute();
        $linha = $select -> fetch();

        if ($linha) {
            $paramAdmin = $linha['admin'];
            return $linha['senha'] == $paramSenha;
        } else {
            $paramAdmin = false;
            return false;
        }
    }
?>