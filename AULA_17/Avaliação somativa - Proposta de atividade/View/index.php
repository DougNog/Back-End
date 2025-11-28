<?php //* Início da parte PHP que controla as ações da página

require_once __DIR__ . '/../Controller/LivroController.php';
//* Inclui o controlador de livros, responsável pela lógica de CRUD

$controller = new LivroController();
//* Cria uma instância do controlador, que será usada para chamar os métodos de negócio

$acao = $_POST['acao'] ?? '';
//* Lê o campo oculto "acao" do formulário via POST, se existir; caso contrário, fica string vazia
//* Serve para saber se o usuário está criando, editando, atualizando ou deletando

$editarLivro = null;
//* Variável que irá armazenar o objeto Livro quando estivermos no modo de edição (formulário preenchido)

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //* Verifica se a requisição é do tipo POST.
    //* Ou seja, se o usuário enviou um formulário.

    if ($acao === 'criar') {
        //* Quando a ação é "criar", cadastramos um novo livro
        $controller->criar(
            trim($_POST['titulo']),        //* Título, retirando espaços extras nas pontas
            trim($_POST['autor']),         //* Autor
            (int) $_POST['ano'],           //* Ano convertido para inteiro
            trim($_POST['genero']),        //* Gênero literário
            (int) $_POST['quantidade']     //* Quantidade convertida para inteiro
        );
        header('Location: ' . $_SERVER['REQUEST_URI']);
        //* Após criar, redireciona para a mesma página para evitar reenvio de formulário

        exit;
        //* Garante que o script pare aqui depois do redirecionamento
    }

    if ($acao === 'deletar') {
        //* Quando a ação é "deletar", removemos um livro
        $controller->deletar(trim($_POST['titulo']));
        //* Chama o método deletar informando o título recebido

        header('Location: ' . $_SERVER['REQUEST_URI']);
        //* Redireciona para limpar a requisição POST
        exit;
    }

    if ($acao === 'editar') {
        //* Quando a ação é "editar", não excluímos nem criamos.
        //* Aqui apenas buscamos o livro e preenchemos o formulário com os dados.
        $editarLivro = $controller->buscarPorTitulo(trim($_POST['titulo']));
        //* O objeto retornado é guardado para ser usado na parte HTML
    }

    if ($acao === 'atualizar') {
        //* Quando a ação é "atualizar", salvamos as alterações de um livro já existente
        $controller->atualizar(
            trim($_POST['titulo_original']), //* Título original, usado para localizar o registro
            trim($_POST['titulo']),          //* Novo título
            trim($_POST['autor']),           //* Novo autor
            (int) $_POST['ano'],             //* Novo ano
            trim($_POST['genero']),          //* Novo gênero
            (int) $_POST['quantidade']       //* Nova quantidade
        );
        header('Location: ' . $_SERVER['REQUEST_URI']);
        //* Redireciona para recarregar a lista já atualizada
        exit;
    }
}

$listaLivros = $controller->ler();
//* Independente de ter ou não POST, carregamos a lista de livros para mostrar na tabela

?>
<!DOCTYPE html>
<html lang="pt-br"> <!-- Documento HTML em português do Brasil -->
<head>
    <meta charset="UTF-8"> <!-- Define o charset da página -->
    <title>Catálogo de Livros - Biblioteca Escolar</title> <!-- Título da aba do navegador -->
    <link rel="stylesheet" href="style.css"> <!-- Importa o arquivo de estilos CSS -->
</head>
<body>

<div class="container">
    <!-- Container principal da página, centraliza e organiza o conteúdo -->
    <h1 id="titulo_principal">Catálogo de Livros - Biblioteca Escolar</h1>
    <!-- Título principal exibido na interface -->
    <hr> <!-- Linha horizontal para separar visualmente as seções -->

    <?php if ($editarLivro): ?>
        <!-- Se $editarLivro não for null, significa que estamos no modo edição -->
        <form id="cadastro" method="POST">
            <!-- Formulário para ATUALIZAR livro existente -->
            <input type="hidden" name="acao" value="atualizar">
            <!-- Campo oculto que indica que a ação será 'atualizar' -->

            <input type="hidden" name="titulo_original" value="<?= htmlspecialchars($editarLivro->getTitulo()) ?>">
            <!-- Guarda o título original do livro antes de qualquer alteração -->

            <input type="text" name="titulo" placeholder="Título do livro" required
                   value="<?= htmlspecialchars($editarLivro->getTitulo()) ?>">
            <!-- Campo de texto para o título, já preenchido com o valor atual -->

            <input type="text" name="autor" placeholder="Autor" required
                   value="<?= htmlspecialchars($editarLivro->getAutor()) ?>">
            <!-- Campo de texto para o autor, preenchido -->

            <input type="number" name="ano" placeholder="Ano de publicação" required
                   value="<?= htmlspecialchars($editarLivro->getAno()) ?>">
            <!-- Campo numérico para ano de publicação -->

            <input type="text" name="genero" placeholder="Gênero literário" required
                   value="<?= htmlspecialchars($editarLivro->getGenero()) ?>">
            <!-- Campo para gênero literário -->

            <input type="number" name="quantidade" placeholder="Quantidade disponível" required
                   value="<?= htmlspecialchars($editarLivro->getQuantidade()) ?>">
            <!-- Campo numérico para quantidade em estoque -->

            <button type="submit">Atualizar Livro</button>
            <!-- Botão que envia o formulário para atualizar os dados -->
        </form>
    <?php else: ?>
        <!-- Caso contrário, estamos no modo de CADASTRO de um novo livro -->
        <form method="POST">
            <!-- Formulário para criar um novo livro -->
            <input type="hidden" name="acao" value="criar">
            <!-- Campo oculto indicando que a ação é 'criar' -->

            <input type="text" name="titulo" placeholder="Título do livro" required>
            <!-- Campo para digitar o título do novo livro -->

            <input type="text" name="autor" placeholder="Autor" required>
            <!-- Campo para digitar o autor -->

            <input type="number" name="ano" placeholder="Ano de publicação" required>
            <!-- Campo numérico para o ano -->

            <input type="text" name="genero" placeholder="Gênero literário" required>
            <!-- Campo para o gênero -->

            <input type="number" name="quantidade" placeholder="Quantidade disponível" required>
            <!-- Campo para quantidade disponível -->

            <button type="submit">Cadastrar Livro</button>
            <!-- Botão para enviar o formulário de cadastro -->
        </form>
    <?php endif; ?>

    <hr> <!-- Separador visual -->

    <h2>Acervo de Livros</h2>
    <!-- Título da seção de listagem de livros -->

    <table>
        <!-- Tabela onde será exibido o acervo -->
        <tr>
            <th>Título</th>      <!-- Cabeçalho da coluna Título -->
            <th>Autor</th>       <!-- Cabeçalho da coluna Autor -->
            <th>Ano</th>         <!-- Cabeçalho da coluna Ano -->
            <th>Gênero</th>      <!-- Cabeçalho da coluna Gênero -->
            <th>Quantidade</th>  <!-- Cabeçalho da coluna Quantidade -->
            <th>Ações</th>       <!-- Cabeçalho da coluna Ações (Editar/Excluir) -->
        </tr>

        <?php if (!empty($listaLivros)): ?>
            <!-- Se existir pelo menos um livro na lista -->
            <?php foreach ($listaLivros as $livro): ?>
                <!-- Percorre cada objeto Livro da lista -->
                <tr>
                    <td><?= htmlspecialchars($livro->getTitulo()) ?></td>
                    <!-- Exibe o título do livro com escape para evitar XSS -->

                    <td><?= htmlspecialchars($livro->getAutor()) ?></td>
                    <!-- Exibe o autor -->

                    <td><?= htmlspecialchars($livro->getAno()) ?></td>
                    <!-- Exibe o ano de publicação -->

                    <td><?= htmlspecialchars($livro->getGenero()) ?></td>
                    <!-- Exibe o gênero literário -->

                    <td><?= htmlspecialchars($livro->getQuantidade()) ?></td>
                    <!-- Exibe a quantidade disponível -->

                    <td class="actions">
                        <!-- Coluna contendo os botões de ação (Editar/Excluir) -->

                        <form method="post" style="display:inline;">
                            <!-- Formulário pequeno para acionar a edição deste livro -->
                            <input type="hidden" name="acao" value="editar">
                            <!-- Define a ação como 'editar' -->

                            <input type="hidden" name="titulo" value="<?= htmlspecialchars($livro->getTitulo()) ?>">
                            <!-- Passa o título do livro a ser editado -->

                            <button type="submit">Editar</button>
                            <!-- Botão que enviar o pedido de edição -->
                        </form>

                        <form method="post" style="display:inline;">
                            <!-- Formulário para excluir o livro -->
                            <input type="hidden" name="acao" value="deletar">
                            <!-- Define a ação como 'deletar' -->

                            <input type="hidden" name="titulo" value="<?= htmlspecialchars($livro->getTitulo()) ?>">
                            <!-- Título do livro que será excluído -->

                            <button type="submit"
                                    onclick="return confirm('Tem certeza que deseja excluir este livro?')">
                                Excluir
                            </button>
                            <!-- Botão de exclusão com confirmação via JavaScript -->
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Caso a lista esteja vazia, mostra uma mensagem -->
            <tr>
                <td colspan="6" class="no-data">
                    Nenhum livro cadastrado.
                </td>
            </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
