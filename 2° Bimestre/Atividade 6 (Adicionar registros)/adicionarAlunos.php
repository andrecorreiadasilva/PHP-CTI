<?php
    echo "Adicionar Alunos

    <form action='add.php' method='post'>
        <label for='nome'>Nome:</label><br>
        <input type='text' id='nome' name='nome'><br>
        
        <label for='matricula'>Matrícula:</label><br>
        <input type='text' id='matricula' name='matricula'><br>
        
        <label for='celular'>Celular:</label><br>
        <input type='tel' id='celular' name='celular'><br>
        
        <label for='email'>Email:</label><br>
        <input type='email' id='email' name='email'><br>

        <label for='sexo'>Sexo:</label><br>
        <select id='sexo' name = 'sexo'>
            <option value='M'>Masculino</option>
            <option value='F'>Feminino</option>
        </select><br>
        
        <label for='turma'>Turma:</label><br>
        <select id='turma' name='turma'>
            <option value='1INIA'>1INIA</option>
            <option value='1INIB'>1INIB</option>
            <option value='1ELI'>1ELI</option>
            <option value='1MEC'>1MEC</option>
            <option value='2INIA'>2INIA</option>
            <option value='2INIB'>2INIB</option>
            <option value='2ELI'>2ELI</option>
            <option value='2MEC'>2MEC</option>
            <option value='3INIA'>3INIA</option>
            <option value='3INIB'>3INIB</option>
            <option value='3ELI'>3ELI</option>
            <option value='3MEC'>3MEC</option>
        </select><br><br>
        
        <input type='submit' value='Adicionar Aluno'>
    </form>";
?>