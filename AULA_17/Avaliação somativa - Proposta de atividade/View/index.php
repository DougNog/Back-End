<?php
//* Inicia uma nova sessão ou retoma uma sessão existente.
//* Usada para armazenar mensagens temporárias (flash messages).
session_start();

require_once __DIR__ . '/../Controller/LivroController.php';
//* Inclui o arquivo do controller LivroController.
//* __DIR__ garante o caminho absoluto correto até a pasta Controller.

//* Cria uma instância do controller, que será usada para todas as ações.
$controller = new LivroController();

//* Lê a ação enviada pelo formulário via POST.
//* Se não existir, define como string vazia.
$acao = $_POST['acao'] ?? '';

//* Variável que armazenará um livro quando estiver em modo de edição.
//* Inicia como null (nenhum livro sendo editado).
$editarLivro = null;

//* Verifica se a requisição atual foi feita via método POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    //* Verifica se a ação solicitada é "criar".
    if ($acao === 'criar') {
        //* Chama o método criar do controller passando os dados do formulário.
        $resultado = $controller->criar(
            trim($_POST['titulo']),        //* Remove espaços extras do título
            trim($_POST['autor']),         //* Remove espaços extras do autor
            (int) $_POST['ano'],           //* Converte o ano para inteiro
            trim($_POST['genero']),        //* Remove espaços extras do gênero
            (int) $_POST['quantidade']     //* Converte a quantidade para inteiro
        );

        //* Define uma mensagem na sessão:
        //* se o retorno for true → sucesso
        //* caso contrário → mensagem de erro retornada pelo DAO
        $_SESSION['mensagem'] = ($resultado === true)
            ? "Livro cadastrado com sucesso."
            : $resultado;

        //* Redireciona para a mesma página para evitar reenvio do formulário.
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit; //* Encerra o script após o redirecionamento.
    }

    //* Verifica se a ação solicitada é "deletar".
    if ($acao === 'deletar') {
        //* Chama o método deletar do controller passando o título do livro.
        $controller->deletar(trim($_POST['titulo']));

        //* Define mensagem de sucesso na sessão.
        $_SESSION['mensagem'] = "Livro excluído com sucesso.";

        //* Redireciona para a mesma página.
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    //* Verifica se a ação solicitada é "editar".
    if ($acao === 'editar') {
        //* Busca o livro pelo título e armazena em $editarLivro.
        //* Isso ativa o modo de edição no formulário.
        $editarLivro = $controller->buscarPorTitulo(trim($_POST['titulo']));
    }

    //* Verifica se a ação solicitada é "atualizar".
    if ($acao === 'atualizar') {
        //* Chama o método atualizar do controller com os novos dados.
        $resultado = $controller->atualizar(
            trim($_POST['titulo_original']), //* Título original (chave de busca)
            trim($_POST['titulo']),          //* Novo título
            trim($_POST['autor']),           //* Novo autor
            (int) $_POST['ano'],             //* Novo ano
            trim($_POST['genero']),           //* Novo gênero
            (int) $_POST['quantidade']        //* Nova quantidade
        );

        //* Define mensagem de sucesso ou erro.
        $_SESSION['mensagem'] = ($resultado === true)
            ? "Livro atualizado com sucesso."
            : $resultado;

        //* Redireciona para a mesma página.
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
}

//* Busca todos os livros cadastrados para exibição na tabela.
$listaLivros = $controller->ler();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <!-- Define o conjunto de caracteres para suportar acentos -->
    <title>Catálogo de Livros - Biblioteca Escolar</title>
    <!-- Título exibido na aba do navegador -->
    <link rel="stylesheet" href="style.css">
    <!-- Importa o arquivo CSS -->
</head>
<body>

<div class="container">
    <!-- Container principal da página -->
    <h1 id="titulo_principal">Catálogo de Livros - Biblioteca Escolar</h1>
    <hr>

    <?php if (!empty($_SESSION['mensagem'])): ?>
        <!-- Exibe mensagem armazenada na sessão -->
        <p style="color:red; font-weight:bold;">
            <?= htmlspecialchars($_SESSION['mensagem']) ?>
            <!-- htmlspecialchars evita problemas de segurança (XSS) -->
        </p>
        <?php unset($_SESSION['mensagem']); ?>
        <!-- Remove a mensagem da sessão após exibir -->
    <?php endif; ?>

    <?php if ($editarLivro): ?>
        <!-- Formulário exibido quando está editando um livro -->
        <form id="cadastro" method="POST">
            <input type="hidden" name="acao" value="atualizar">
            <!-- Define a ação como atualizar -->

            <input type="hidden" name="titulo_original"
                   value="<?= htmlspecialchars($editarLivro->getTitulo()) ?>">
            <!-- Armazena o título original para identificar o registro -->

            <input type="text" name="titulo" required
                   value="<?= htmlspecialchars($editarLivro->getTitulo()) ?>">
            <input type="text" name="autor" required
                   value="<?= htmlspecialchars($editarLivro->getAutor()) ?>">
            <input type="number" name="ano" required
                   value="<?= htmlspecialchars($editarLivro->getAno()) ?>">
            <input type="text" name="genero" required
                   value="<?= htmlspecialchars($editarLivro->getGenero()) ?>">
            <input type="number" name="quantidade" required
                   value="<?= htmlspecialchars($editarLivro->getQuantidade()) ?>">

            <button type="submit">Atualizar Livro</button>
        </form>
    <?php else: ?>
        <!-- Formulário exibido quando NÃO está editando -->
        <form method="POST">
            <input type="hidden" name="acao" value="criar">
            <!-- Define a ação como criar -->

            <input type="text" name="titulo" placeholder="Título do livro" required>
            <input type="text" name="autor" placeholder="Autor" required>
            <input type="number" name="ano" placeholder="Ano de publicação" required>
            <input type="text" name="genero" placeholder="Gênero literário" required>
            <input type="number" name="quantidade" placeholder="Quantidade disponível" required>

            <button type="submit">Cadastrar Livro</button>
        </form>
    <?php endif; ?>

    <hr>

    <h2>Acervo de Livros</h2>

    <table>
        <!-- Cabeçalho da tabela -->
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Ano</th>
            <th>Gênero</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>

        <?php if (!empty($listaLivros)): ?>
            <!-- Loop que percorre todos os livros -->
            <?php foreach ($listaLivros as $livro): ?>
                <tr>
                    <td><?= htmlspecialchars($livro->getTitulo()) ?></td>
                    <td><?= htmlspecialchars($livro->getAutor()) ?></td>
                    <td><?= htmlspecialchars($livro->getAno()) ?></td>
                    <td><?= htmlspecialchars($livro->getGenero()) ?></td>
                    <td><?= htmlspecialchars($livro->getQuantidade()) ?></td>
                    <td class="actions">
                        <!-- Formulário para editar -->
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="acao" value="editar">
                            <input type="hidden" name="titulo"
                                   value="<?= htmlspecialchars($livro->getTitulo()) ?>">
                            <button type="submit">Editar</button>
                        </form>

                        <!-- Formulário para deletar -->
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="acao" value="deletar">
                            <input type="hidden" name="titulo"
                                   value="<?= htmlspecialchars($livro->getTitulo()) ?>">
                            <button type="submit"
                                    onclick="return confirm('Tem certeza que deseja excluir este livro?')">
                                Excluir
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Exibido quando não há livros cadastrados -->
            <tr>
                <td colspan="6" class="no-data">Nenhum livro cadastrado.</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>
