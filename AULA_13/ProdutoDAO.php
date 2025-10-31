<?php

// Crie uma classe 'Produtos' com os atributos: código, nome e preço.
// Em seguida, crie a classe ProdutoDAO para a utilização dos métodos CRUD.
// Por fim, desenvolva um arquivo index.php para testar a criação e manipulação dos objetos.
// Implemente também a persistência de dados utilizando o arquivo produtos.json.




require_once 'Produto.php'; 

class ProdutoDAO { // DAO = "Data Access Object"

    private $produtos = []; // Array para armazenar temporariamente os objetos
    private $arquivo = "produtos.json"; // Corrigido: faltava ponto e vírgula

    // Construtor: carrega os dados do arquivo JSON ao iniciar a aplicação
    public function __construct() { 
        if (file_exists($this->arquivo)) {
            $conteudo = file_get_contents($this->arquivo);  
            $dados = json_decode($conteudo, true); // Converte JSON em array associativo

            if ($dados) {
                foreach ($dados as $codigo => $info) {
                    $this->produtos[$codigo] = new produtos(
                        $info['codigo'],
                        $info['nome'],
                        $info['preco']
                    );
                }
            }
        }
    }

    // Função privada para salvar os dados no arquivo JSON
    private function salvarEmArquivo() {
        $dados = [];

        foreach ($this->produtos as $codigo => $produtos) {
            $dados[$codigo] = [
                'codigo' => $produtos->getCodigo(),
                'nome' => $produtos->getNome(),
                'preco' => $produtos->getPreco() // Corrigido erro de digitação
            ];
        }

        file_put_contents($this->arquivo, json_encode($dados, JSON_PRETTY_PRINT));
    }

    // CREATE
    public function criarProdutos(Produtos $produtos) {
        $this->produtos[$produtos->getCodigo()] = $produtos;
        $this->salvarEmArquivo();
    }

    // READ
    public function lerProdutos() {
        return $this->produtos;
    }

    // UPDATE
    public function atualizarProdutos($codigo, $novoNome, $novoPreco) {
        if (isset($this->produtos[$codigo])) {
            $this->produtos[$codigo]->setNome($novoNome);
            $this->produtos[$codigo]->setPreco($novoPreco);
            $this->salvarEmArquivo();
        }
    }

    // DELETE
    public function excluirProdutos($codigo) {
        if (isset($this->produtos[$codigo])) {
            unset($this->produtos[$codigo]);
            $this->salvarEmArquivo();
        }
    }
}

?>
