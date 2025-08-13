<?php

for ($i = 1; $i <= 5; $i++) {
    echo "\n Menu \n";
    echo "1 - Olá\n";
    echo "2 - Data Atual\n";
    echo "3 - Sair\n";
    echo "------------\n";

    $opcao = (int)readline("Escolha uma opção: ");

    switch ($opcao) {
        case 1:
            echo "Olá!\n";
            break; 
        case 2:
            echo "Data Atual: " . date("d/m/Y H:i:s") . "\n";
            break;
        case 3:
            echo "Saindo do programa...\n";
            exit; 
            break; 
        default:
            echo "Opção inválida. Por favor, escolha 1, 2 ou 3.\n";
            break; 
    }
}

echo "\nFim das repetições do menu.\n";

?>