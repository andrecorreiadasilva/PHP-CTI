<?php
    include("util.php");
    $conn = conecta();

    $varSQL = "SELECT * FROM produto 
               WHERE excluido = false";
    $select = $conn -> prepare($varSQL);
    $select -> execute();

    echo "
    <table border='1'>
        <tr>
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
            echo "<td>".$linha['nome']."</td>";

            echo "<td>".$linha['descricao']."</td>";

            echo "<td>".$linha['valor_unitario']."</td>";

            echo "<td>".$linha['qtde_estoque']."</td>";

            $foto = "img/p".$linha['id_produto'].".jpg";

            echo "<td>".$htmlFoto = (file_exists($foto) ? "<img src='$foto'
                       width=60>" : "<img src='img/semimg.jpg' width=60>")."<br><b></td>";

            echo "<td><a href='alterarProduto.php?id=".$linha['id_produto']."'>Alterar</a>  <a href='excluirProduto.php?id=".$linha['id_produto']."'>Excluir</a></td>";
        echo "</tr>";
    }
    echo "</table>";
    echo "<a href='adicionarProduto.php'>Adicionar Produto</a>";
?>