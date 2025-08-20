<?php

class Carro
{

    public $marca;

    public $modelo;

    public $ano;

    public $revisao;

    public $N_Donos;

    public function __construct($marca, $modelo, $ano, $revisao, $N_Donos)
    {

        $this->marca = $marca;
        $this->modelo = $modelo;
        $this->ano = $ano;
        $this->revisao = $revisao;
        $this->N_Donos = $N_Donos;
    }
}

$carro1 = new Carro("Porsche" , "911" , "2020" , false , 3);
$carro2 = new Carro("Mitsubishi" , "Lancer" , "1945" , true , 1);
$carro3 = new Carro("Chevrolet" , "Onix" , "2022" , false , 0);
$carro4 = new Carro("Volkswagen" , "Fusca" , "1970" , true , 5);
$carro5 = new Carro("Fiat" , "Uno" , "1990" , false , 2);
$carro6 = new Carro("Ford" , "Ka" , "2018" , true , 4);





?>