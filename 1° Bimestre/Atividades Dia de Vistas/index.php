<?php
    echo "
    <form method='POST' name='formulario' action=''>
        <label for='num'>Número:</label>
        <input type='number' name='num' placeholder='Digite o número'><br>

        <label for='nome'>Nome:</label>
        <input type='text' name='nome' placeholder='Digite o nome'><br>

        <label for='disciplina'>Disciplina:</label>
        <select id='disciplina' name='disciplina'>
            <option value='C#'>C#</option>
            <option value='PHP'>PHP</option>
        </select><br>

        <label for='nota'>Nota da prova:</label>
        <input type='range' name='nota' min='0' max='5' oninput='prova_nota.innerText = this.value'>
        <label id='prova_nota'></label><br>

        <label for='cred'>Nota da cred:</label>
        <input type='range' name='cred' min='0' max='1' step='0.05' oninput='cred_nota.innerText = this.value'>
        <label id='cred_nota'></label><br>

        <label>Atividades entregues:</label><br>
        <label for='atividade1'>Atividade 1</label>
        <input type='checkbox' name='atividade1'><br>
        <label for='atividade1'>Atividade 2</label>
        <input type='checkbox' name='atividade2'><br>
        <label for='atividade1'>Atividade 3</label>
        <input type='checkbox' name='atividade3'><br>
        <label for='atividade1'>Atividade 4</label>
        <input type='checkbox' name='atividade4'><br>
        <label for='atividade1'>Atividade 5</label>
        <input type='checkbox' name='atividade5'><br>
        <label for='atividade1'>Atividade 6</label>
        <input type='checkbox' name='atividade6'><br>
        <label for='atividade1'>Atividade 7</label>
        <input type='checkbox' name='atividade7'><br>
        <label for='atividade1'>Atividade 8</label>
        <input type='checkbox' name='atividade8'><br><br>        
        
        <button type='submit'>Enviar</button>
    </form>";

    

    if( $_POST ) {
        $num = $_POST['num'];
        $nome = $_POST['nome'];
        $disciplina = $_POST['disciplina'];
        $nota = $_POST['nota'];
        $cred = $_POST['cred'];
        $ativ = 0;
        for ($i = 1; $i <= 8; $i++) {
            if (isset($_POST['atividade'.$i])) {
                $ativ += 0.5;
            }
        }
        
        echo "
        <style>
            table, td {
                border: 1px solid;
            }
        </style>

        <table>
            <tr>
                <td>Número</td>
                <td>$num</td>
            </tr>
            <tr>
                <td>Nome</td>
                <td>$nome</td>
            </tr>
            <tr>
                <td>Disciplina</td>
                <td>$disciplina</td>
            </tr>
            <tr>
                <td>Nota da prova</td>
                <td>$nota</td>
            </tr>
            <tr>
                <td>Nota da crediária</td>
                <td>$cred</td>
            </tr>
            <tr>
                <td>Nota das atividades</td>
                <td>$ativ</td>
            </tr>
        </table>";
    }
?>