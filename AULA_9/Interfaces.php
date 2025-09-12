<?php

namespace AULA_9;

interface pagamento
{
    public function pagar($valor);
}

class cartaoDeCredito implements pagamento
{
    public function pagar($valor)
    {
        echo "Pagamento realizado com cartão de crédito no valor de R$ $valor\n";
    }
}

class Pix implements pagamento {
    public function pagar($valor)
    {
        echo "Pagamento realizado com Pix no valor de R$ $valor\n";
    }
}

//! 1. Criando um inerface simples 

//*Crie uma interface chamada forma que abrigue qualquer classe a ter um metodo calcularArea() 
//*Depois crie as classes quadrado e circulo que implemnentem a interface

//*quadrado deve receber o lado  e calcular  area 
//*circula deve receber o raio e calcular a area

interface forma {
    public function calcularArea();
}

class quadrado implements forma {
    private $lado;

    public function __construct($lado) {
        $this->lado = $lado;
    }

    public function calcularArea() {
        return $this->lado * $this->lado;
    }
}

$meuCirculo = new quadrado(4);
echo "A área do quadrado é: " . $meuCirculo->calcularArea() . "\n";

class Circulo {
    private $raio;

    public function __construct($raio) {
        $this->raio = $raio;
    }

    public function calcularArea() {
        return 3.14 * ($this->raio * $this->raio);
    }
}

$meuCirculo = new Circulo(5);
echo "A área do círculo é: " . $meuCirculo->calcularArea();

//* crie a classe pentagono e calcule a area do mesmo 
//* crie a classe hexagono, e calcule a area do mesmo 

class Pentagono implements forma {
    private $lado;
    private $apotema;

    public function __construct($lado, $apotema) {
        $this->lado = $lado;
        $this->apotema = $apotema;
    }

    public function calcularArea() {
        return (5 * $this->lado * $this->apotema) / 2;
    }
}

class Hexagono implements forma {
    private $lado;

    public function __construct($lado) {
        $this->lado = $lado;
    }

    public function calcularArea() {
        return (3 * sqrt(3) * ($this->lado * $this->lado)) / 2;
    }
}

?>