<?php

//!Crie uma classe (molde de objetos) chamada 'Cachorro' com os seguintes atributos: Nome, idade, raca, castrado e sexo
//! após a criação da classe crie 10 objetos

class Cachorro
{
    public $nome;

    public $idade;

    public $raca;

    public $castrado;

    public $sexo;

    public function __construct($nome, $idade, $raca, $castrado, $sexo)
    {

        $this->nome = $nome;
        $this->idade = $idade;
        $this->raca = $raca;
        $this->castrado = $castrado;
        $this->sexo = $sexo;
    }

//! Exericio S: 
//!Crie um método para a classe 'Cachorro' chamado de 'latir', no qual exibe uma mensagem "O cachorro $nome está latindo!"
public function latir() {
    echo "O Cachorro $this->nome Está Latindo! \n";
}

//! Exercicio 6:
//! Crie outro método para a classe 'Cachorro' chamado de 'marcar território', no qual exibe uma mensagem "O cachorro $nome da raça $raca está marcando território*.
public function MarcarTerritorio() {
    echo "O Cachorro $this->nome da raça $this->raca está marcando território \n";
}

}

$cachorro1 = new Cachorro("Rex", 5, "Labrador", true, "Macho");
$cachorro2 = new Cachorro("Bella", 3, "Poodle", false, "Fêmea");
$cachorro3 = new Cachorro("Max", 2, "Bulldog", true, "Macho");
$cachorro4 = new Cachorro("Luna", 4, "Beagle", false, "Fêmea");
$cachorro5 = new Cachorro("Charlie", 1, "Golden Retriever", true, "Macho");
$cachorro6 = new Cachorro("Molly", 6, "Shih Tzu", false, "Fêmea");
$cachorro7 = new Cachorro("Buddy", 3, "Cocker Spaniel", true, "Macho");
$cachorro8 = new Cachorro("Daisy", 2, "Dachshund", false, "Fêmea");
$cachorro9 = new Cachorro("Rocky", 5, "Boxer", true, "Macho");
$cachorro10 = new Cachorro("Sadie", 4, "Schnauzer", false, "Fêmea");

?>