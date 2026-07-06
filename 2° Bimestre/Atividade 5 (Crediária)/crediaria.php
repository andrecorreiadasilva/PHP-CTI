<?php
    echo "
    <form method='POST' name='formulario' action=''>
        <label for='curso'>Curso:</label>
        <select name='curso'>
            <option value='médio'>Ensino Médio</option>
            <option value='eletronica'>Eletrônica</option>
            <option value='informatica'>Informática</option>
            <option value='mecanica'>Mecânica</option>
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

        $varSQL = "SELECT * FROM disciplinas
            WHERE (curso = :curso)";

        $filtroCurso = $_POST['curso'];
        $select = $conn->prepare($varSQL);
        $select->bindParam (":curso", $filtroCurso);
        $select->execute();

        echo "<table border=1>
                <tr>
                    <td> <strong> ID </strong> </td>
                    <td> <strong> Descrição </strong> </td>
                    <td> <strong> Curso </strong> </td>
                </tr>";
        
        while ( $linha = $select->fetch() ) 
        {
            echo "<tr>";
                echo "<td>";
                    echo $linha["id"];
                echo "</td>";
            
                echo "<td>";
                    echo $linha["descricao"];
                echo "</td>";

                echo "<td>";
                    echo $linha["curso"];
                echo "</td>";
            echo "</tr>";       
        }
        echo "</table>" ;
    }
?>