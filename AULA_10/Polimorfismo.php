<?php

//!Polimorfismo!//

interface Veiculo {
    public function mover ();
}


class Carro implements Veiculo {
    public $nome;
    public function mover() {
        echo "O carro {$this->nome} está andando";
    }
}

class Aviao implements Veiculo {
    public $nome;
    public function mover() {
        echo "O avião {$this->nome} está voando";
    }
}

?>