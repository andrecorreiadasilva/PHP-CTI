<?php
    function conectar ($params = "")
    {
        if($params == "")
            $params = "";
        $conn = new PDO($params);
        if (!$conn)
            echo "Não conectado";
        else
            return $conn;
    }
?>