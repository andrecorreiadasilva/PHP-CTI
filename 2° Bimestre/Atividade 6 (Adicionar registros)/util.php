<?php
    function conectar ($params = "")
    {
        if($params == "")
            $params = "";
        $varConn = new PDO($params);
        if (!$varConn)
            echo "Não conectado";
        else
            return $varConn;
    }
?>