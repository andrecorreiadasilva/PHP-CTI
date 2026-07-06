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
        <link rel="stylesheet" href="style/produto.css">
        
    </head>
    <script src="js/script.js">
    </script>
    <body>
        <header>
        </header>
        <nav> 
            <?php nav(); ?>
        </nav>
        <article> 
            <div class="geral">
                <div class="broches">
                    <div class="prod1">
                        <?php
                            $conn = conecta();
                            $idSessao = session_id();

                            $id = $_GET['id'];
                            $varSQL = "SELECT * FROM produto 
                                    WHERE excluido = false AND id_produto = :id";

                            $select = $conn -> prepare($varSQL);
                            $select -> bindParam(':id', $id);
                            $select -> execute();
                            $linha = $select -> fetch();


                            echo "<Title>GKHaven - " . $linha['nome'] . "</Title>";


                            $varSQL = "SELECT quantidade FROM COMPRA_PRODUTO WHERE fk_id_produto = :id_produto AND fk_id_compra = (SELECT id_compra FROM COMPRA WHERE sessao = :sessao)";
                            $select = $conn->prepare($varSQL);
                            $select->bindParam(':id_produto', $id);
                            $select->bindParam(':sessao', $idSessao);
                            $select->execute();
                            $produtoCarrinho = $select->fetch();
                            
                            $quantidadeNoCarrinho = $produtoCarrinho ? $produtoCarrinho['quantidade'] : 0;

                            $nome = $linha['nome'];
                            $descricao = $linha['descricao'];
                            $valor_unitario = $linha['valor_unitario'];
                            $qtde_estoque = $linha['qtde_estoque'];
                            $tipo_produto = ($linha['tipo_produto'] == 'b' ? 'Botton' : 'Sticker');
                            $foto = "img/p/".$linha['id_produto'].".png";

                            echo "<div class='imagem_produto'>
                                <img src='$foto'>
                                <p class='nome'>$nome</p>
                                <p> ID do produto: $id </p>
                                <p> Tipo: $tipo_produto </p>
                                <p> Descrição: $descricao </p>
                            </div>
                            <div class='compra'>
                                <div class='subcompra'>
                                    <p class='Preco'> R$ $valor_unitario </p>
                                    <p>Quantidade disponível: $qtde_estoque</p>
                                    <p>Quantidade no carrinho: $quantidadeNoCarrinho</p>
                                    <select id='quantidade' name='quantidade'>";

                                    for ($i = 1; $i <= $qtde_estoque - $quantidadeNoCarrinho; $i++) {
                                        echo "<option value='$i'>$i</option>";
                                    }
                                    echo "</select><br><br>";

                                    $desabilitarBotao = ($qtde_estoque <= $quantidadeNoCarrinho) ? 'disabled' : '';
                                    echo "<button class='button-19' role='button' onclick='adicionarAoCarrinho(" . $linha['id_produto'] . ")' $desabilitarBotao>Comprar</button>";

                                    if ($qtde_estoque <= $quantidadeNoCarrinho) {
                                        echo "<p class='desabilitado'>Este produto não está mais disponível para compra.</p>";
                                    }
                                    
                                    echo "</div>
                                </div>"; 
                        ?>
                    </div>
                </div>
            </div>
        </article>
        <footer>
        </footer> 

        <script>
            function adicionarAoCarrinho(idProduto) {
                const quantidade = document.getElementById('quantidade').value;
                window.location = 'Carrinho.php?operacao=INCLUIR&id_produto=' 
                + idProduto + '&quantidade=' + quantidade;
            }
        </script>
    </body>
</html>