<?php
class Bebida {
    private $nome;
    private $categoria;
    private $volume;
    private $valor;
    private $qtde;

    public function __construct($nome, $categoria, $volume, $valor, $qtde){
        $this->nome = $nome;
        $this->categoria = $categoria;
        $this->volume = $volume;
        $this->valor = $valor;
        $this->qtde = $qtde;
    }

    public function toArray(){
        return [
            'nome' => $this->nome,
            'categoria' => $this->categoria,
            'volume' => $this->volume,
            'valor' => $this->valor,
            'qtde' => $this->qtde
        ];
    }

    public static function fromArray(array $data){
        return new Bebida(
            $data['nome'] ?? '',
            $data['categoria'] ?? '',
            $data['volume'] ?? '',
            $data['valor'] ?? 0,
            $data['qtde'] ?? 0
        );
    }

    public function getNome(){ return $this->nome; }
    public function getCategoria(){ return $this->categoria; }
    public function getVolume(){ return $this->volume; }
    public function getValor(){ return $this->valor; }
    public function getQtde(){ return $this->qtde; }
}
