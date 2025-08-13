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
            break; // Sai do switch, continua o loop for
        case 2:
            echo "Data Atual: " . date("d/m/Y H:i:s") . "\n";
            break; // Sai do switch, continua o loop for
        case 3:
            echo "Saindo do programa...\n";
            // 'break 2;' sai tanto do switch quanto do loop for
            exit; // 'exit;' termina a execução do script PHP imediatamente
            break; // Este break é redundante após exit;
        default:
            echo "Opção inválida. Por favor, escolha 1, 2 ou 3.\n";
            break; // Sai do switch, continua o loop for
    }
}

echo "\nFim das repetições do menu.\n"; // Esta linha só será executada se o loop for terminar naturalmente (após 5 repetições) e o usuário não escolher '3'.

?>