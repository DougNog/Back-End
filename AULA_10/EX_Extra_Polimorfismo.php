<?php
interface Movel {
    public function mover();
}

interface Abastecivel {
    public function abastecer($quantidade);
}

interface Manutenivel {
    public function fazerManutencao();
}

class Carro implements Movel, Abastecivel {
    public function mover() {
        echo "O carro está se movimentando\n";
    }
    public function abastecer($quantidade) {
        echo "Carro abastecido com $quantidade litros\n";
    }
}

class Bicicleta implements Movel, Manutenivel {
    public function mover() {
        echo "A bicicleta está pedalando\n";
    }
    public function fazerManutencao() {
        echo "A bicicleta foi lubrificada\n";
    }
}

class Onibus implements Movel, Abastecivel, Manutenivel {
    public function mover() {
        echo "O ônibus está transportando passageiros\n";
    }
    public function abastecer($quantidade) {
        echo "Ônibus abastecido com $quantidade litros\n";
    }
    public function fazerManutencao() {
        echo "O ônibus está passando por revisão\n";
    }
}

//*Teste simples
$carro = new Carro($mover, $abastecer);
$carro->mover();
$carro->abastecer(50);

$bike = new Bicicleta($mover, $fazerManutencao);
$bike->mover();
$bike->fazerManutencao();

$onibus = new Onibus($mover, $abastecer, $fazerManutencao);
$onibus->mover();
$onibus->abastecer(200);
$onibus->fazerManutencao();


