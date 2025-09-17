<?php

//!EX 1!//
interface Forma {
    public function calcularArea();
}

class Quadrado implements Forma {
    private $lado;
    public function __construct($lado) {
        $this->lado = $lado;
    }
    public function calcularArea() {
        return $this->lado * $this->lado;
    }
}

class Retangulo implements Forma {
    private $base, $altura;
    public function __construct($base, $altura) {
        $this->base = $base;
        $this->altura = $altura;
    }
    public function calcularArea() {
        return $this->base * $this->altura;
    }
}

class Circulo implements Forma {
    private $raio;
    public function __construct($raio) {
        $this->raio = $raio;
    }
    public function calcularArea() {
        return pi() * $this->raio * $this->raio;
    }
}

//*TESTE
function exibirArea(Forma $forma) {
    echo "A área é: " . $forma->calcularArea() . "\n";
}


//!EX 2!//
class Animal {
    public function fazerSom() {}
}

class Cachorro extends Animal {
    public function fazerSom() {
        return "Au au!";
    }
}

class Gato extends Animal {
    public function fazerSom() {
        return "Miau!";
    }
}

class Vaca extends Animal {
    public function fazerSom() {
        return "Muuu!";
    }
}

//*TESTE
function emitirSom(Animal $animal) {
    echo $animal->fazerSom() . "\n";
}

//!EX 3!//
abstract class Transporte {
    abstract public function mover();
}

class Carro extends Transporte {
    public function mover() {
        return "O carro está andando na estrada";
    }
}

class Barco extends Transporte {
    public function mover() {
        return "O barco está navegando no mar";
    }
}

class Aviao extends Transporte {
    public function mover() {
        return "O avião está voando no céu";
    }
}

class Elevador extends Transporte {
    public function mover() {
        return "O elevador está correndo pelo prédio";
    }
}

//*TESTE
function iniciarTransporte(Transporte $transporte) {
    echo $transporte->mover() . "\n";
}

//!EX 4!//
class Email {
    public function enviar() {
        return "Enviando email...";
    }
}

class Sms {
    public function enviar() {
        return "Enviando SMS...";
    }
}

function notificar($meio) {
    echo $meio->enviar() . PHP_EOL;
}

//*TESTE
notificar(new Email());
notificar(new Sms());

//!EX 5!//
class Calculadora {
    public function somar(...$numeros) {
        return array_sum($numeros);
    }
}

//*TESTE
$calc = new Calculadora();
echo $calc->somar(1, 2) . "\n";         

