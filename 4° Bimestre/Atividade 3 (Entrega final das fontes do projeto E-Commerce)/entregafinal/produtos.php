<?php
    include("../utilidades/util.php");
    $conn = conecta();
    session_start();

    if (isset($_SESSION['admin']) && $_SESSION['admin']) {
        $varSQL = "SELECT * FROM produto 
               WHERE excluido = false";
        $select = $conn -> prepare($varSQL);
        $select -> execute();

        echo "
        <table border='1'>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Valor Unitário</th>
                <th>Quantidade em Estoque</th>
                <th>Foto</th>
                <th></th>
            </tr>";

        while ($linha = $select -> fetch()) 
        {
            echo "<tr>";
                echo "<td>".$linha['id_produto']."</td>";

                echo "<td>".$linha['nome']."</td>";

                echo "<td>".$linha['descricao']."</td>";

                echo "<td>".$linha['valor_unitario']."</td>";

                echo "<td>".$linha['qtde_estoque']."</td>";

                $foto = "../img/p/".$linha['id_produto'].".png";

                echo "<td>".$htmlFoto = (file_exists($foto) ? "<img src='$foto'
                        width=60>" : "<img src='../img/p/semimg.jpg' width=60>")."<br><b></td>";

                echo "<td><a href='alterarProduto.php?id=".$linha['id_produto']."'>Alterar</a>  <a href='excluirProduto.php?id=".$linha['id_produto']."'>Excluir</a></td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<a href='adicionarProduto.php'>Adicionar Produto</a><br>
        <a href='relatorio.php'>Gerar relatório</a>";
    }
    else {
        echo "Acesso proibido";
        
    }
    
    
?>