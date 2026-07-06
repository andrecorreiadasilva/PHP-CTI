<?php
    ini_set ( 'display_errors' , 1); 
    error_reporting (E_ALL);

    

    function conecta ($params = "") {
        if ($params == "") {
            $params="";
        }
        $varConn = new PDO($params);
        if (!$varConn) {
            echo "Não foi possível conectar";
        } else { 
            return $varConn; 
        }
    }
    function login ($paramLogin, $paramSenha, &$paramAdmin){
        $conn = conecta();
        setcookie('loginCookie', $paramLogin, time()+86400);

        $varSQL = "SELECT senha, admin
                   FROM usuario
                   WHERE email = :paramLogin";
        
        $select = $conn -> prepare($varSQL);
        $select -> bindParam(':paramLogin', $paramLogin);
        $select -> execute();
        $linha = $select -> fetch();

        if ($linha) {
            $paramAdmin = $linha['admin'];
            return $linha['senha'] == $paramSenha;
        } else {
            $paramAdmin = false;
            return false;
        }
    }
    function nav () {
        if (isset($_SESSION['admin']) && $_SESSION['admin'])
                echo "<div class='topnav'>
                            <a href='Home.php'>Home</a>
                            <a href='Contato.php'>Contato</a>
                            <a href='SobreNos.php'>Sobre nós</a>
                            <a href='Relatorio.php'>Relatório</a>
                            <a class='btlogin' href='MinhasInformacoes.php'>Conta</a>
                        </div>";
        else if (isset($_SESSION['sessaoConectado']) && $_SESSION['sessaoConectado'])
            echo "<div class='topnav'>
                    <a href='Home.php'>Home</a>
                    <a href='Contato.php'>Contato</a>
                    <a href='SobreNos.php'>Sobre nós</a>
                    <a class='btlogin' href='MinhasInformacoes.php'>Conta</a>
                </div>";
        else
            echo "<div class='topnav'>
                    <a href='Home.php'>Home</a>
                    <a href='Contato.php'>Contato</a>
                    <a href='SobreNos.php'>Sobre nós</a>
                    <a class='btlogin' href='Login.php'>Login</a>
                </div>";
    }

    // funcao de envio de emails
    // Marcelo C Peres 2023 

    function EnviaEmail ( $pEmailDestino, $pAssunto, $pHtml, 
                        $pUsuario = "marcelocabello@projetoscti.com.br", 
                        $pSenha = "MarceloC@belo", 
                        $pSMTP = "smtp.projetoscti.com.br" )  {    
        try {
    
            //cria instancia de phpmailer
            echo "<br>Tentando enviar para $pEmailDestino...";
            $mail = new PHPMailer(); 
            $mail->IsSMTP();  // diz ao php que o servidor eh SMTP
        
            // servidor smtp
            $mail->Host = $pSMTP;  // configura o servidor
            $mail->SMTPAuth = true;// requer autenticacao com o servidor                         
            
            $mail->SMTPSecure = 'tls';  // nivel de seguranca                           
            $mail-> SMTPOptions = array ( 'ssl' => array ( 'verificar_peer' => false, 'verify_peer_name' => false,
            'allow_self_signed' => true ) );
            
            $mail->Port = 587;  // porta do servico no servidor     
            
            $mail->Username = $pUsuario; 
            $mail->Password = $pSenha; 
            $mail->From = $pUsuario; 
            $mail->FromName = "Suporte de senhas"; 
        
            $mail->AddAddress($pEmailDestino, "Usuario"); 
            $mail->IsHTML(true); // o conteudo enviado eh html (poderia ser txt comum sem formato)
            $mail->Subject = $pAssunto; 
            $mail->Body = $pHtml;
            $enviado = $mail->Send(); // disparo
            
            if (!$enviado) {
                echo "<br>Erro: " . $mail->ErrorInfo;
            } else {
                echo "<br><b>Enviado!</b>";
            }
            return $enviado;         
            
        } catch (phpmailerException $e) {
            echo $e->errorMessage(); // erros do phpmailer
        } catch (Exception $e) {
            echo $e->getMessage(); // erros da aplicaco - gerais
        }      
    }

    // funcao de executar frases sql
    // Marcelo C Peres 2023 

    function ExecutaSQL( $paramConn, $paramSQL ) 
    {
        // exec eh usado para update, delete, insert
        // eh um metodo da conexao
        // retorna TRUE se houve linhas afetadas
        $linhas = $paramConn->exec($paramSQL);
        return ($linhas > 0);
    }

    // funcao de retornar o valor de um campo de um select
    // Marcelo C Peres 2023 

    function ValorSQL( $pConn, $pSQL ) 
    {
        $linha = $pConn->query($pSQL)->fetch();
        if ( $linha ) { 
            return $linha[0]; // equivale a retornar o valor do campo
        } else { 
            return "0"; 
        }
    }
?>