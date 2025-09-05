<?php

class Imovel {
    private $Categoria;
    private $N_comodos;
    private $Valor;
    private $Estado_conservacao;

    public function __construct($Categoria, $N_comodos, $Valor, $Estado_conservacao) {
        

    }
}

class Casa extends Imovel {
    private $TemQuintal; // atributo booleano true ou false
    public function __construct($Categoria, $N_comodos, $Valor, $Estado_conservacao, $TemQuintal) {
        parent::__construct($Categoria, $N_comodos, $Valor, $Estado_conservacao);
        $this->TemQuintal = $TemQuintal;
    }
}
class Apartamento extends Imovel {
    private $Andar;

    public function __construct($Categoria, $N_comodos, $Valor, $Estado_conservacao, $Andar) {
        parent::__construct($Categoria, $N_comodos, $Valor, $Estado_conservacao);
        $this->Andar = $Andar;
    }
}

    class Escola extends Imovel {
    private $Seguimento;

    public function __construct($Categoria, $N_comodos, $Valor, $Estado_conservacao, $Seguimento) {
        parent::__construct($Categoria, $N_comodos, $Valor, $Estado_conservacao);
        $this->Seguimento = $Seguimento;

    }
}