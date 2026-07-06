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
?>