<?php
    $string_conexao = "mysql:host=200.145.153.196; port=3306; dbname=cursos; user=root; password=";
    $conn = new PDO($string_conexao);
    
    if (!$conn)
    {
        echo "Não conectado";
        exit;
    }
    else
    {
        echo "
        <form method='POST' name='formulario' action=''>
            <label for='valor'>Valor máximo:</label>
            <input type='number' name='valor' min='0' max='5000' step='0.05'>
            <button type='submit'>Enviar</button>
        </form>";
        
        if ($_POST) 
        {
            $varSQL = "SELECT *
                   FROM cursos
                   WHERE (valor < :valor)";

            $filtroValor = $_POST['valor'];
            $select = $conn->prepare($varSQL);
            $select->bindParam (":valor", $filtroValor);
            $select->execute();

            echo "<table border=1>";
            while ( $linha = $select->fetch() ) 
            {
                echo "<tr>";
                    echo "<td>";
                        echo $linha["titulo"];
                    echo "</td>";
                
                    echo "<td>";
                        echo $linha["valor"];
                    echo "</td>";

                    echo "<td>";
                        echo $linha["descricao"];
                    echo "</td>";
                echo "</tr>";       
            }
            echo "</table>" ;
        }
    }
?>