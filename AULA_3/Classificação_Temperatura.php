<?php

$temperatura = (float)readline("Digite a temperatura em Celsius: ");

if ($temperatura < 15) {
    echo "Frio\n";
} elseif ($temperatura >= 15 && $temperatura <= 25) {
    echo "Agradável\n";
} else { // $temperatura > 25
    echo "Quente\n";
}

?>





