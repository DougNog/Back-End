<?php

require_once __DIR__ . '/../Model/LivroDAO.php';
//* Inclui o arquivo LivroDAO.php UMA vez (se já tiver sido incluído antes, não inclui de novo).
//* __DIR__ pega o diretório atual deste arquivo, evitando erros por "caminho relativo".

require_once __DIR__ . '/../Model/Livro.php';
//* Inclui o arquivo Livro.php UMA vez, para que a classe Livro exista e possa ser instanciada no controller.

class LivroController {
//* Declara a classe LivroController.
//* No padrão MVC, o Controller recebe dados da View (formulário/rotas) e coordena as ações usando o Model/DAO.

    private $dao;
    //* Declara uma propriedade privada $dao.
    //* Ela vai guardar a instância do LivroDAO (camada responsável por acessar o banco).

    public function __construct() {
        //* Método construtor: é executado automaticamente quando você faz new LivroController().

        $this->dao = new LivroDAO();
        //* Cria um objeto LivroDAO e armazena na propriedade $dao.
        //* Assim, todas as funções do controller podem usar o DAO para falar com o banco.
    }

    public function criar($titulo, $autor, $ano, $genero, $quantidade) {
        //* Método público para criar/cadastrar um livro.
        //* Recebe os dados (normalmente vindos de um formulário ou rota).

        $livro = new Livro($titulo, $autor, $ano, $genero, $quantidade);
        //* Instancia um objeto Livro (Model) com os dados recebidos.
        //* Isso encapsula os dados do livro em um objeto, em vez de passar valores soltos.

        return $this->dao->criarLivro($livro);
        //* Chama o método criarLivro do DAO, enviando o objeto Livro para ser inserido no banco.
        //* Retorna o resultado do DAO (ex.: true/false, id, etc., dependendo da implementação).
    }

    public function ler() {
        //* Método público para listar/ler os livros cadastrados.

        return $this->dao->lerLivros();
        //* Chama o método do DAO que busca todos os livros no banco e retorna a lista (array/coleção).
    }

    public function atualizar($tituloOriginal, $novoTitulo, $autor, $ano, $genero, $quantidade) {
        //* Método público para atualizar um livro existente.
        //* $tituloOriginal identifica qual livro será atualizado (critério), e os demais são os novos dados.

        return $this->dao->atualizarLivro($tituloOriginal, $novoTitulo, $autor, $ano, $genero, $quantidade);
        //* Encaminha a atualização para o DAO (que executa o UPDATE no banco).
        //* Retorna o resultado do DAO (sucesso/erro).
    }

    public function buscarPorTitulo($titulo) {
        //* Método público para buscar livro(s) filtrando pelo título.

        return $this->dao->buscarPorTitulo($titulo);
        //* Chama o método do DAO que faz a consulta no banco usando o título como filtro e retorna o resultado.
    }

    public function deletar($titulo) {
        //* Método público para excluir um livro, identificando-o pelo título.

        $this->dao->excluirLivro($titulo);
        //* Chama o método do DAO que remove o livro do banco (DELETE).
        //* Aqui não há "return"; o método apenas executa a ação.
    }
}
?>

