<?php

echo "Digite um número final: ";
$numFinal = (int)trim(fgets(STDIN));

echo "Números pares de 0 até " . $numFinal . ":\n";
for ($i = 0; $i <= $numFinal; $i++) {
    if ($i % 2 == 0) {
        echo $i . "\n";
    }
}

?>