<?php
    include ("util.php");
    echo "
        <form action='' method='post' enctype='multipart/form-data'>

        <label for='nome'>Nome:</label>
        <input type='text' name='nome'>

        <br><br>
        <label for='email'>Email:</label>
        <input type='email' name='email'>

        <br><br>
        <label for='senha'>Senha:</label>
        <input type='password' name='senha'>

        <br><br>
        <label for='telefone'>Telefone:</label>
        <input type='number' name='telefone'>

        <br><br>
        <label for='admin'>Admin:</label>
        <input type='checkbox' name='admin'>

        <br><br>
        <label for='foto'>Foto:</label>
        <input type='file' name='foto' accept='image/*' required>

        <br><br>
        <button type='submit'>Enviar</button>
        </form>
    ";

    if($_POST)
    {
        $conn = conecta();

        $varSQL = "INSERT INTO usuario (nome, email, senha, telefone, admin)
                   VALUES (:nome, :email, :senha, :telefone, :admin)";

        $insert = $conn->prepare($varSQL);

        $insert->bindParam(':nome', $_POST['nome']);
        $insert->bindParam(':email', $_POST['email']);
        $insert->bindParam(':senha', $_POST['senha']);
        $insert->bindParam(':telefone', $_POST['telefone']);
        $insert->bindParam(':admin', $_POST['admin']);

        if ($insert->execute()) {
            $idUsuario = $conn -> lastInsertId();
            $imagem = $_FILES['foto']['name'];
            $imagemPath = $_SERVER['DOCUMENT_ROOT'].'/imagens/u'.$idUsuario.'.jpg';
            move_uploaded_file($_FILES['foto']['tmp_name'], $imagemPath);
            echo "Usuário cadastrado com sucesso";
        } else {
            echo "Houve um erro ao cadastrar o usuário";
        }

        echo "<br><br><a href='usuario.php'>Voltar</a>";
    }
?>