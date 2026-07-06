<?php
    include ("util.php");

    $conn = conecta();

    $id = $_GET['id'];
    $varSQL = "SELECT * FROM usuario 
               WHERE id_usuario = :id";

    $select = $conn->prepare($varSQL);
    $select->bindParam(':id', $id);
    $select->execute();
    $linha = $select->fetch();

    $nome = $linha['nome'];
    $email = $linha['email'];
    $telefone = $linha['telefone'];
    $admin = $linha['admin'];

    echo "
    <form action='' method='post' enctype='multipart/form-data'>
    
        <label for='nome'>Nome:</label>
        <input type='text' name='nome' value='$nome' required>

        <br><br>
        <label for='email'>Email:</label>
        <input type='email' name='email' value='$email' required>
        
        <br><br>
        <label for='telefone'>Telefone:</label>
        <input type='text' name='telefone' value='$telefone' required>
        
        <br><br>
        <label for='admin'>Admin:</label>
        <input type='checkbox' name='admin' ".($admin ? 'checked' : '').">
        
        <br><br>
        <label for='foto'>Foto:</label>
        <input type='file' name='foto' accept='image/*'>
        
        <br><br>
        <button type='submit'>Salvar</button>
    </form>";

    if ($_POST) {
        $varSQL = "UPDATE usuario 
        SET nome = :nome, email = :email, telefone = :telefone, 
        admin = :admin WHERE id_usuario = :id";
        $update = $conn->prepare($varSQL);

        $admin = isset($_POST['admin']) ? 1 : 0;

        $update->bindParam(':nome', $_POST['nome']);
        $update->bindParam(':email', $_POST['email']);
        $update->bindParam(':telefone', $_POST['telefone']);
        $update->bindParam(':admin', $admin);
        $update->bindParam(':id', $id);

        if ($update->execute()) {
            if ($_FILES['foto']['name']) {
                $imagem = $_FILES['foto']['name'];
                $imagemPath = $_SERVER['DOCUMENT_ROOT'].'/imagens/u'.$id.'.jpg';
                move_uploaded_file($_FILES['foto']['tmp_name'], $imagemPath);
            }
            echo "Usuário alterado com sucesso";
        } else {
            echo "Houve um erro ao alterar o usuário";
        }
    }
    echo "<br><a href='usuario.php'>Voltar</a>";
?>