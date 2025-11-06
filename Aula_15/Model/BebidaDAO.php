<?php
require_once __DIR__ . '/Bebida.php';

class BebidaDAO {
    private $bebidasArray = [];
    private $arquivoJson;

    public function __construct(){
        $this->arquivoJson = __DIR__ . '/../data/bebidas.json';

        if(!file_exists(dirname($this->arquivoJson))){
            mkdir(dirname($this->arquivoJson), 0777, true);
        }

        if(file_exists($this->arquivoJson)){
            $conteudo = file_get_contents($this->arquivoJson);
            $dados = json_decode($conteudo, true);

            if ($dados){
                foreach ($dados as $nome => $info){
                    $this->bebidasArray[$nome] = new Bebida(
                        $info['nome'],
                        $info['categoria'],
                        $info['volume'],
                        $info['valor'],
                        $info['qtde']
                    );
                }
            }
        }
    }

    private function salvarArquivo(){
        $dados = [];
        foreach ($this->bebidasArray as $nome => $bebida){
            $dados[$nome] = [
                'nome' => $bebida->getNome(),
                'categoria' => $bebida->getCategoria(),
                'volume' => $bebida->getVolume(),
                'valor' => $bebida->getValor(),
                'qtde' => $bebida->getQtde()
            ];
        }
        file_put_contents($this->arquivoJson, json_encode($dados, JSON_PRETTY_PRINT));
    }

    public function criarBebida(Bebida $bebida){
        $this->bebidasArray[$bebida->getNome()] = $bebida;
        $this->salvarArquivo();
    }

    public function lerBebidas(){
        return $this->bebidasArray;
    }

    public function atualizarBebida($nome, $novoValor, $novaQtde){
        if(isset($this->bebidasArray[$nome])){
            $this->bebidasArray[$nome]->setValor($novoValor);
            $this->bebidasArray[$nome]->setQtde($novaQtde);
            $this->salvarArquivo();
        }
    }

    public function excluirBebida($nome){
        if(isset($this->bebidasArray[$nome])){
            unset($this->bebidasArray[$nome]);
            $this->salvarArquivo();
        }
    }
}
?>
