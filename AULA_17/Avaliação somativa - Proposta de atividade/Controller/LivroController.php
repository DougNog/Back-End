<?php
/**
 ** Arquivo: LivroController.php
 ** Descrição: Responsável por gerenciar as operações CRUD (Criar, Ler, Atualizar, Deletar) de livros.
 */

require_once __DIR__ . '/../Model/LivroDAO.php';
//* Inclui o arquivo LivroDAO.php, que contém a classe de acesso a dados (DAO) para operações no banco de dados.
//* __DIR__ representa o diretório atual deste arquivo, garantindo que o caminho seja resolvido corretamente independentemente do local de execução.

require_once __DIR__ . '/./Model/Livro.php';
//* Inclui o arquivo Livro.php, que define a classe Livro, representando a entidade de dados para um livro no sistema.

class LivroController {
    //* Classe controladora que faz a ponte entre a interface do usuário (como index.php na View) e o DAO (Data Access Object).
    //* Responsável por processar requisições, validar dados e coordenar operações de negócio sem expor diretamente o acesso ao banco.

    private $dao; //* Propriedade privada que armazena uma instância de LivroDAO, usada para interagir com o banco de dados.

    public function __construct() {
        //* Construtor da classe: inicializa o controlador criando uma nova instância de LivroDAO.
        //* Isso garante que o controlador tenha acesso aos métodos de persistência de dados.
        $this->dao = new LivroDAO(); //* Cria e armazena o objeto de acesso a dados para uso nas operações CRUD.
    }

    /**
     ** Cria um novo livro no sistema.
     ** $titulo: O título do livro a ser criado.
     ** $autor: O nome do autor do livro.
     ** $ano: O ano de publicação do livro.
     ** $genero: O gênero literário do livro.
     ** $quantidade: A quantidade de exemplares disponíveis no acervo.
     ** void: Não retorna valor, mas persiste o livro no banco de dados via DAO.
     */
    public function criar($titulo, $autor, $ano, $genero, $quantidade) {
        //* Método para criar um novo livro: recebe os dados do formulário, instancia um objeto Livro e delega a persistência ao DAO.
        $livro = new Livro($titulo, $autor, $ano, $genero, $quantidade);
        //* Instancia um novo objeto Livro com os dados fornecidos, encapsulando-os em uma entidade de domínio.

        $this->dao->criarLivro($livro);
        //* Chama o método do DAO para inserir o novo livro no banco de dados, garantindo a persistência dos dados.
    }

    /**
     * Retorna a lista completa de livros cadastrados no sistema.
     * @return array Um array de objetos Livro representando todos os livros no acervo, ordenados por título.
     */
    public function ler() {
        //* Método para ler todos os livros: delega a operação de leitura ao DAO, que consulta o banco e retorna os dados.
        return $this->dao->lerLivros();
        //* Retorna diretamente o resultado da consulta do DAO, sem processamento adicional neste nível.
    }

    /**
     * Atualiza os dados de um livro existente no sistema.
     * @param string $tituloOriginal O título atual do livro a ser atualizado (usado como identificador único).
     * @param string $novoTitulo O novo título do livro.
     * @param string $autor O novo nome do autor.
     * @param int $ano O novo ano de publicação.
     * @param string $genero O novo gênero literário.
     * @param int $quantidade A nova quantidade de exemplares disponíveis.
     * @return void Não retorna valor, mas atualiza o registro no banco via DAO.
     */
    public function atualizar($tituloOriginal, $novoTitulo, $autor, $ano, $genero, $quantidade) {
        //* Método para atualizar um livro existente: recebe os novos dados e o identificador original, delegando a atualização ao DAO.
        $this->dao->atualizarLivro($tituloOriginal, $novoTitulo, $autor, $ano, $genero, $quantidade);
        //* Passa todos os parâmetros diretamente para o DAO, que executará a query de UPDATE no banco de dados.
    }

    /**
     * Busca um livro específico pelo seu título.
     * @param string $titulo O título do livro a ser buscado.
     * @return Livro|null Retorna um objeto Livro se encontrado, ou null caso não exista um livro com o título fornecido.
     */
    public function buscarPorTitulo($titulo) {
        //* Método para buscar um livro único: utiliza o título como chave de busca e delega ao DAO.
        return $this->dao->buscarPorTitulo($titulo);
        //* Retorna o objeto Livro encontrado pelo DAO, ou null se não houver correspondência.
    }

    /**
     * Exclui um livro do sistema com base no seu título.
     * @param string $titulo O título do livro a ser deletado.
     * @return void Não retorna valor, mas remove o registro do banco via DAO.
     */
    public function deletar($titulo) {
        //* Método para deletar um livro: identifica o livro pelo título e solicita a exclusão ao DAO.
        $this->dao->excluirLivro($titulo);
        //* Delega a operação de exclusão ao DAO, que executará a query DELETE no banco de dados.
    }
}
?> <!-- Fim do código PHP -->
