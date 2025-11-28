<?php
session_start();

require_once __DIR__ . '/../Controller/LivroController.php';

$controller = new LivroController();

$acao = $_POST['acao'] ?? '';
$editarLivro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($acao === 'criar') {

        $msg = $controller->criar(
            trim($_POST['titulo']),
            trim($_POST['autor']),
            (int) $_POST['ano'],
            trim($_POST['genero']),
            (int) $_POST['quantidade']
        );

        $_SESSION['mensagem'] = $msg;

        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    if ($acao === 'deletar') {

        $controller->deletar(trim($_POST['titulo']));
        $_SESSION['mensagem'] = "Livro excluído com sucesso!";

        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    if ($acao === 'editar') {

        $editarLivro = $controller->buscarPorTitulo(trim($_POST['titulo']));
    }

    if ($acao === 'atualizar') {

        $msg = $controller->atualizar(
            trim($_POST['titulo_original']),
            trim($_POST['titulo']),
            trim($_POST['autor']),
            (int) $_POST['ano'],
            trim($_POST['genero']),
            (int) $_POST['quantidade']
        );

        $_SESSION['mensagem'] = $msg;

        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
}

$listaLivros = $controller->ler();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Livros - Biblioteca Escolar</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="container">

    <h1 id="titulo_principal">Catálogo de Livros - Biblioteca Escolar</h1>
    <hr>

    <!-- Exibição das mensagens -->
    <?php if (!empty($_SESSION['mensagem'])): ?>
        <p style="color:red; font-weight:bold; font-size:16px;">
            <?= htmlspecialchars($_SESSION['mensagem']); ?>
        </p>
        <?php unset($_SESSION['mensagem']); ?>
    <?php endif; ?>

    <?php if ($editarLivro): ?>

        <form id="cadastro" method="POST">

            <input type="hidden" name="acao" value="atualizar">

            <input type="hidden" name="titulo_original"
                   value="<?= htmlspecialchars($editarLivro->getTitulo()) ?>">

            <input type="text" name="titulo" required
                   placeholder="Título do livro"
                   value="<?= htmlspecialchars($editarLivro->getTitulo()) ?>">

            <input type="text" name="autor" required
                   placeholder="Autor"
                   value="<?= htmlspecialchars($editarLivro->getAutor()) ?>">

            <input type="number" name="ano" required
                   placeholder="Ano de publicação"
                   value="<?= htmlspecialchars($editarLivro->getAno()) ?>">

            <input type="text" name="genero" required
                   placeholder="Gênero literário"
                   value="<?= htmlspecialchars($editarLivro->getGenero()) ?>">

            <input type="number" name="quantidade" required
                   placeholder="Quantidade disponível"
                   value="<?= htmlspecialchars($editarLivro->getQuantidade()) ?>">

            <button type="submit">Atualizar Livro</button>

        </form>

    <?php else: ?>

        <form method="POST">

            <input type="hidden" name="acao" value="criar">

            <input type="text" name="titulo" required placeholder="Título do livro">
            <input type="text" name="autor" required placeholder="Autor">
            <input type="number" name="ano" required placeholder="Ano de publicação">
            <input type="text" name="genero" required placeholder="Gênero literário">
            <input type="number" name="quantidade" required placeholder="Quantidade disponível">

            <button type="submit">Cadastrar Livro</button>

        </form>

    <?php endif; ?>

    <hr>

    <h2>Acervo de Livros</h2>

    <table>
        <tr>
            <th>Título</th>
            <th>Autor</th>
            <th>Ano</th>
            <th>Gênero</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>

        <?php if (!empty($listaLivros)): ?>
            <?php foreach ($listaLivros as $livro): ?>
                <tr>
                    <td><?= htmlspecialchars($livro->getTitulo()) ?></td>
                    <td><?= htmlspecialchars($livro->getAutor()) ?></td>
                    <td><?= htmlspecialchars($livro->getAno()) ?></td>
                    <td><?= htmlspecialchars($livro->getGenero()) ?></td>
                    <td><?= htmlspecialchars($livro->getQuantidade()) ?></td>

                    <td class="actions">

                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="acao" value="editar">
                            <input type="hidden" name="titulo" value="<?= htmlspecialchars($livro->getTitulo()) ?>">
                            <button type="submit">Editar</button>
                        </form>

                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="acao" value="deletar">
                            <input type="hidden" name="titulo" value="<?= htmlspecialchars($livro->getTitulo()) ?>">
                            <button type="submit"
                                    onclick="return confirm('Tem certeza que deseja excluir este livro?')">
                                Excluir
                            </button>
                        </form>

                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="6" class="no-data">Nenhum livro cadastrado.</td>
            </tr>
        <?php endif; ?>

    </table>

</div>

</body>
</html>
