<!DOCTYPE html>
<html>
    <?php
        include("utilidades/cabecalho.php");
    ?>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">    
        <link rel="stylesheet" href="style/style.css">
        <link rel="stylesheet" href="style/minhas_informacoes.css">
        <title>GKHaven - Conta</title>
    </head>
    <body>
        <header>
        </header>
        <nav> 
            <?php nav(); ?>
        </nav>
        <article class="login">
            <div class="caixalogin">
                <h3>Minhas informações</h3>
                <?php
                    $conn = conecta();

                    if (isset($_SESSION['sessaoConectado']))
                    {
                        $email = $_SESSION['sessaoLogin'];
                        $varSQL = "SELECT * FROM usuario 
                                    WHERE email = :email";

                        $select = $conn -> prepare($varSQL);
                        $select->bindParam(':email', $email);
                        $select->execute();
                        $linha = $select -> fetch();

                        $nome = $linha['nome'];
                        $email = $linha['email'];
                        $telefone = $linha['telefone'];

                        echo "
                        <div class='espaco'>
                            <label>Nome de usuário: $nome </label>
                        </div>
                        <div class='espaco'>
                            <label>Email: $email </label>
                        </div>
                        <div class='espaco'>
                            <label>Telefone: $telefone </label>
                        </div>
                        <div class='espaco'>
                            <a href='AlterarInformacoes.php'>Alterar informações</a><br>
                            <a href='utilidades/logout.php'>Sair</a>
                        </div>
                        <div class='espaco'>";

                        if ($_SESSION['admin']) {
                            echo "
                                <a href='adm/produtos.php'>Acessar lista de produtos</a><br>
                                <a href='adm/usuarios.php'>Acessar lista de usuários</a><br>
                            </div>
                            <div class='espaco'>";
                        }
                            
                        echo "</div>
                        </div>";
                    }
                    else {
                        echo "Favor logar em sua conta antes de tentar acessar suas informações";
                    }
                ?>
            </div>
        </article>
        <footer>
        </footer>

        <script src="js/script.js"></script>
    </body>
</html>