<?php
    echo "
    <form method='POST' name='formulario' action=''>
        <label for='id'>ID:</label>
        <input type='number' name='id' min='0'><br>

        <label for='nome'>Nome:</label>
        <input type='text' name='nome'><br>

        <label for='sexo'>Sexo:</label>
        <select name='sexo'>
            <option value='F'>Feminino</option>
            <option value='M'>Masculino</option>
        </select><br>

        <label for='matricula'>Matrícula:</label>
        <input type='number' name='matricula'><br>

        <label for='celular'>Celular:</label>
        <input type='number' name='celular'><br>

        <label for='email'>E-mail:</label>
        <input type='text' name='email'><br>

        <label for='turma'>Turma:</label>
        <select name='turma'>
            <option value='2INIA'>2INIA</option>
            <option value='2INIB'>2INIB</option>
            <option value='2INF'>2INF</option>
        </select><br>

        <button type='submit'>Enviar</button>
    </form>";
?>