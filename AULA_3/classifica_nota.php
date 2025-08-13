<?php

    $nota = readline("Digite a nota do aluno: ");

    if ($nota >= 9) {
        echo "Excelnete.";
    } else if ($nota >= 7) {
        echo "Bom.";
    } else if ($nota < 7) {
        echo "Reprovado.";
    }

?>