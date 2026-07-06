<!DOCTYPE html>
<html>
    <?php
        include ("utilidades/cabecalho.php");
        include ("vendor/autoload.php");

        use Dompdf\Dompdf;
    ?>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">    
        <link rel="stylesheet" href="style/style.css">
        <link rel="stylesheet" href="style/login.css">
        <title>GKHaven - Relatório</title>
    </head>
    <body>
        <header>
        </header>
        <nav> 
            <?php nav(); ?>
        </nav>
        <article class="login">
            <div class="caixalogin">
                <?php
                    if (isset($_SESSION['admin']) && $_SESSION['admin']) {
                        echo "
                            <h3>Relatório</h3>
                            <form action='' method='post'>
                                Data inicial <input type='date' name='datai'>
                                Data final <input type='date' name='dataf'><br> 
                                <input type='submit' class='logar' value='Enviar'><br>  
                            </form>";

                        if ($_POST ) {
                            $conn = conecta();

                            $datai = $_POST['datai'];
                            $dataf = $_POST['dataf'];

                            $sql = "SELECT id_compra, status, id_transacao, data, u.nome, acrescimo_total, total 
                                    FROM compra AS c
                                    LEFT JOIN usuario as u
                                    ON c.fk_id_usuario = u.id_usuario
                                    WHERE status='FINALIZADO' AND (data between :datai and :dataf)   
                                    ORDER BY data";

                            $select = $conn->prepare($sql);
                            $select->bindParam(':datai',$datai);
                            $select->bindParam(':dataf',$dataf);
                            $select->execute();

                            ///--- INICIA UMA NOVA PAGINA HTML A EXPORTAR PRA PDF -------------------------------///
                            ob_clean();
                            ob_start();

                            ///----------------------------------------------------------------------------------///
                            echo "<!DOCTYPE html>
                                    <html lang='pt-br'>
                            
                                    <body>
                                    <center>
                                        <h1>Relatorio de Vendas</h1>
                                        <h3>Periodo de $datai a $dataf</h3>
                                    </center>

                                    <table border='1'>
                                    <tr>
                                        <th colspan='3'>Id</th>
                                        <th>Data</th>
                                        <th>Usuario</th>
                                        <th>($)Acres/Desc</th>
                                        <th>($)Total</th>
                                    </tr>";
                            
                            while ( $linha = $select->fetch() ) {

                                $id_compra = $linha['id_compra'];
                                $status    = $linha['status'];
                                $voucher   = $linha['id_transacao'];

                                $data      = new DateTime($linha['data']);
                                $data      = $data->format('d-m-Y');
                                
                                $nome      = $linha['nome'];
                                $ac_desc   = number_format($linha['acrescimo_total']+0,2);
                                $total     = number_format($linha['total']+0,2);
                                
                                echo "<tr>
                                            <td colspan='3' align='right'>$id_compra</td>
                                            <td>$data</td>
                                            <td>$nome</td>
                                            <td align='right'>R$ $ac_desc</td>
                                            <td align='right'>R$ $total</td>
                                        </tr>";

                                //////// SELECIONA E IMPRIME OS ITENS DA COMPRA //////////////// 
                                $sqlItens =
                                        "SELECT cp.fk_id_produto, p.nome, cp.quantidade, cp.valor_unitario, 
                                                cp.valor_unitario * cp.quantidade as sub
                                        FROM compra_produto as cp
                                        INNER JOIN produto as p
                                        ON cp.fk_id_produto = p.id_produto
                                        WHERE cp.fk_id_compra = $id_compra 
                                        ORDER BY p.nome";

                                $selectItens = $conn->prepare($sqlItens);
                                $selectItens->execute();
                                
                                while ( $linhaItens = $selectItens->fetch() ) {

                                        $id_produto     = $linhaItens['fk_id_produto']; 
                                        $nome           = $linhaItens['nome'];  
                                        $quantidade     = $linhaItens['quantidade'];  
                                        $valor_unitario = number_format($linhaItens['valor_unitario'],2);  
                                        $sub            = number_format($linhaItens['sub'],2); 

                                        echo "<tr>
                                                    <td colspan='5'><b>$nome</b></td>
                                                    <td align='right'>$quantidade x R$ $valor_unitario</td>
                                                    <td align='right'>R$ $sub</td>
                                                </tr>";
                                            
                                }
                                
                                //////// FIM DE IMPRIME OS ITENS DA COMPRA //////////////// 
                                
                                $selectItens = null;
                            }
                            
                            echo "</table></html>";

                            ///------- FINAL DA NOVA PAGINA HTML A EXPORTAR PRA PDF  ---------------------///
                            
                            $html = ob_get_clean(); // CAPTURA O HTML PARA UMA VARIAVEL !!!

                            $dompdf = new Dompdf();
                            $dompdf->loadHtml($html);  
                            $dompdf->setPaper('A4','portrait');
                            $dompdf->render();
                            $dompdf->stream();  /// CRIA PDF PARA DOWNLOAD COM O RELATORIO DENTRO
                        }
                    }
                    else {
                        echo "Acesso proibido";
                    }
                ?>
            </div>
        </article>
        <footer>
        </footer>

        <script src="js/script.js"></script>
    </body>
</html>