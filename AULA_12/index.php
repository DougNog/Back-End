<?php 

        require_once "CRUD.php";
        require_once "Aluno_DAO.php";
    // Objeto da classe 
    $dao = new Aluno_DAO();

    // Create
    $dao -> criar_aluno( new Aluno(1, "Eduardo", "TADS"));

    $dao -> criar_aluno( new Aluno(2, "Marcelo", "Medicina"));

    $dao -> criar_aluno( new Aluno(3, "Gabriel", "Engenharia"));


    //!Crie mais 6 objetos obedescendo a seguinte lista:
    //* Id - Nome - Curso
    //*   4 - Aurora - Arquitetura
    //*   5 - Oliver - Director
    //*   6 - Amanda - Lutadora
    // *  7 - Gleyse - Engenharia
    //*   8 - Jao - Professor
    //*   9 - Bernardo - Streamer

    $dao -> criar_aluno( new Aluno(4, "Aurora", "Arquitetura"));

    $dao -> criar_aluno( new Aluno(5, "Oliver", "Director"));

    $dao -> criar_aluno( new Aluno(6, "Amanda", "Lutadora"));

    $dao -> criar_aluno( new Aluno(7, "Gleyse", "Engenharia"));

    $dao -> criar_aluno( new Aluno(8, "Jao", "Professor"));

    $dao -> criar_aluno( new Aluno(9, "Bernardo", "Streamer"));


    //READ
    echo "Listagem inicial:\n   ";
    foreach($dao -> ler_aluno() as $aluno){
        echo "{$aluno -> getId()} - {$aluno -> getNome()} - {$aluno -> getCurso()}\n";
    }


    // Update   
    $dao -> atualizar_aluno(1, "Mariana", "Design");
    //Faça as seguintes atualizações:
    //  - Alterar nome da Gleyse para Clotilde
    $dao -> atualizar_aluno(7, "Clotilde", "Engenharia");

    //  - Alterar nome do Jao para Joana
    $dao -> atualizar_aluno(8, "Joana", "Professor");

    //  - Alterar nome do Bernardo para Dev
    $dao -> atualizar_aluno(9, "Bernardo", "Dev");

    //  - Alterar curso da Amanda para Logistica
    $dao -> atualizar_aluno(6, "Amanda", "Logistica");

    //  - Alterar curso do Oliver para Eletria
    $dao -> atualizar_aluno(5, "Oliver", "Eletria");



    echo "\nListagem após atualização:\n";
    foreach($dao -> ler_aluno() as $aluno){
        echo "{$aluno -> getId()} - {$aluno -> getNome()} - {$aluno -> getCurso()}\n";
    }




    //DELETE
    $dao -> excluir_aluno(2);

    echo "\nListagem após exclusão:\n";
    foreach($dao -> ler_aluno() as $aluno){
        echo "{$aluno -> getId()} - {$aluno -> getNome()} - {$aluno -> getCurso()}\n";
    }