<?php
    include('cabecalho.php');
    echo "
    <style>
        table {
            width: 500px;
            text-align: center;
        }
    </style>";

    echo "<table border=1>";
    $conn = conecta();

    if(!$conn)
        echo "Conexão falhada";
    else
    {
        $varSQL = "SELECT nome, valor_unitario, id_produto FROM produto ORDER BY id_produto";
        $select = $conn->query($varSQL);
        $coluna = 0;
        while ( $linha = $select->fetch() ) {
            if ($coluna == 0)
                echo "<tr>";
            $foto = "img/p".$linha['id_produto'].".jpg";
            echo "<td>".
                    $htmlFoto = (file_exists($foto) ? "<img src='$foto'
                        width=60>" : "<img src='img/semimg.jpg' width=60>")."<br><b>".
                    $linha['nome']."</b><br>".
                    "R$".$linha['valor_unitario']."<br>".
                    "<a href='carrinho.php?operacao=INCLUIR&id_produto=".$linha['id_produto']."'>Comprar</a>".
                 "</td>";
            $coluna++;
            
            if ($coluna == 5) {
                echo "</tr>";
                $coluna = 0;
            }
            
        }
    }
    echo "</table>"; 
?>
