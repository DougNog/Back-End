<?php //* Início do código PHP

class Livro { //* Classe que representa a entidade "Livro" na aplicação
    private $titulo;      //* Armazena o título do livro
    private $autor;       //* Armazena o nome do autor
    private $ano;         //* Armazena o ano de publicação
    private $genero;      //* Armazena o gênero literário do livro
    private $quantidade;  //* Armazena a quantidade disponível no acervo

    public function __construct($titulo, $autor, $ano, $genero, $quantidade){
        //* Construtor da classe, usado para criar um objeto Livro já preenchido
        $this->titulo = $titulo;           //* Define o título do livro
        $this->autor = $autor;             //* Define o autor do livro
        $this->ano = $ano;                 //* Define o ano de publicação
        $this->genero = $genero;           //* Define o gênero literário
        $this->quantidade = $quantidade;   //* Define a quantidade disponível
    }

    public function getTitulo() { return $this->titulo; } 
    //* Retorna o valor atual do título

    public function setTitulo($titulo) { 
        $this->titulo = $titulo; //* Atribui um novo valor ao título
        return $this;            //* Retorna o próprio objeto para permitir encadeamento (chaining)
    }

    public function getAutor() { return $this->autor; } 
    //* Retorna o autor do livro

    public function setAutor($autor) { 
        $this->autor = $autor; //* Atualiza o nome do autor
        return $this;          //* Retorna o próprio objeto
    }

    public function getAno() { return $this->ano; } 
    //* Retorna o ano de publicação

    public function setAno($ano) { 
        $this->ano = $ano; //* Atualiza o ano de publicação
        return $this;      //* Retorna o próprio objeto
    }

    public function getGenero() { return $this->genero; } 
    //* Retorna o gênero literário

    public function setGenero($genero) { 
        $this->genero = $genero; //* Atualiza o gênero
        return $this;            //* Retorna o próprio objeto
    }

    public function getQuantidade() { return $this->quantidade; } 
    //* Retorna a quantidade disponível

    public function setQuantidade($quantidade) { 
        $this->quantidade = $quantidade; //* Atualiza a quantidade
        return $this;                    //* Retorna o próprio objeto
    }
}
?>
