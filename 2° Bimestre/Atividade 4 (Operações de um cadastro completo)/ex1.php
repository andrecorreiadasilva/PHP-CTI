<?php
    echo "
    <form method='POST' name='formulario' action=''>
        <label for='sexo'>Sexo:</label>
        <select name='sexo'>
            <option value='F'>Feminino</option>
            <option value='M'>Masculino</option>
        </select>
        <button type='submit'>Enviar</button>
    </form>";
    
    if ($_POST) 
    {
        $string_conexao = "";
        $conn = new PDO($string_conexao);

        if (!$conn)
        {
            echo "Não conectado";
            exit;
        }

        $varSQL = "SELECT *
            FROM alunos
            WHERE (sexo = :sexo)";

        $sexo = $_POST['sexo'];
        $select = $conn->prepare($varSQL);
        $select->bindParam (":sexo", $sexo);
        $select->execute();

        echo "<table border=1>";
        while ( $linha = $select->fetch() ) 
        {
            echo "<tr>";
                echo "<td>";
                    echo $linha["id"];
                echo "</td>";
            
                echo "<td>";
                    echo $linha["nome"];
                echo "</td>";

                echo "<td>";
                    echo $linha["sexo"];
                echo "</td>";

                echo "<td>";
                    echo $linha["matricula"];
                echo "</td>";

                echo "<td>";
                    echo $linha["celular"];
                echo "</td>";

                echo "<td>";
                    echo $linha["email"];
                echo "</td>";

                echo "<td>";
                    echo $linha["turma"];
                echo "</td>";
            echo "</tr>";       
        }
        echo "</table>" ;
    }
?>