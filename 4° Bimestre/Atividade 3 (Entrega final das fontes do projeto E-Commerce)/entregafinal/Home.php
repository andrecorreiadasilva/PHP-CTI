<!DOCTYPE html>
<html>
    <?php
        include ("utilidades/cabecalho.php");
    ?>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">    
        <link rel="stylesheet" href="style/style.css">
        <link rel="stylesheet" href="style/home.css">
        <Title>GKHaven</Title>
    </head>
    <body>
        <header>
        </header>
        <nav> 
            <?php nav(); ?>
        </nav>
        <article> 
            <div class="geral">
                <div class = "broches">
                    <?php
                        $conn = conecta();
                        $varSQL = "SELECT nome, valor_unitario, id_produto, qtde_estoque, tipo_produto FROM produto ORDER BY id_produto";
                        $select = $conn->query($varSQL);
                        $coluna = 0;
                        while ( $linha = $select->fetch() ) {
                            $foto = "img/p/".$linha['id_produto'].".png";

                            echo "
                            <div class='prod1'>
                                <a href='Produto.php?id=".$linha['id_produto']."'>
                                    <img src= $foto>
                                    <p> Nome: ". $linha['nome'] ."</p>
                                    <p> Tipo: ". $linha['tipo_produto'] ."</p>
                                    <p> ID do produto: ". $linha['id_produto'] ."</p>
                                    <p> Quantidade: ". $linha['qtde_estoque'] ."</p>
                                    <p class='Preco'> R$ ". $linha['valor_unitario'] ."</p>
                                </a>
                            </div>";
                        }
                    ?>
                </div>
            </div>
        </article>
        <footer>
        </footer> 
        <script src="js/script.js"></script>
    </body>
</html>