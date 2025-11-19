<?php
require_once __DIR__ . '/../Controller/LivroController.php';

$controller = new LivroController();
$acao = $_POST['acao'] ?? '';
$editarLivro = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if ($acao === 'criar') {
        $controller->criar(
            trim($_POST['titulo']),
            trim($_POST['autor']),
            (int) $_POST['ano'],
            trim($_POST['genero']),
            (int) $_POST['quantidade']
        );
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    if ($acao === 'deletar') {
        $controller->deletar(trim($_POST['titulo']));
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    if ($acao === 'editar') {
        $editarLivro = $controller->buscarPorTitulo(trim($_POST['titulo']));
    }

    if ($acao === 'atualizar') {
        $controller->atualizar(
            trim($_POST['titulo_original']),
            trim($_POST['titulo']),
            trim($_POST['autor']),
            (int) $_POST['ano'],
            trim($_POST['genero']),
            (int) $_POST['quantidade']
        );
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

    <?php if ($editarLivro): ?>
        <form id="cadastro" method="POST">
            <input type="hidden" name="acao" value="atualizar">
            <input type="hidden" name="titulo_original" value="<?= htmlspecialchars($editarLivro->getTitulo()) ?>">

            <input type="text" name="titulo" placeholder="Título do livro" required value="<?= htmlspecialchars($editarLivro->getTitulo()) ?>">
            <input type="text" name="autor" placeholder="Autor" required value="<?= htmlspecialchars($editarLivro->getAutor()) ?>">
            <input type="number" name="ano" placeholder="Ano de publicação" required value="<?= htmlspecialchars($editarLivro->getAno()) ?>">
            <input type="text" name="genero" placeholder="Gênero literário" required value="<?= htmlspecialchars($editarLivro->getGenero()) ?>">
            <input type="number" name="quantidade" placeholder="Quantidade disponível" required value="<?= htmlspecialchars($editarLivro->getQuantidade()) ?>">

            <button type="submit">Atualizar Livro</button>
        </form>
    <?php else: ?>
        <form method="POST">
            <input type="hidden" name="acao" value="criar">
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
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="acao" value="editar">
                            <input type="hidden" name="titulo" value="<?= htmlspecialchars($livro->getTitulo()) ?>">
                            <button type="submit">Editar</button>
                        </form>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="acao" value="deletar">
                            <input type="hidden" name="titulo" value="<?= htmlspecialchars($livro->getTitulo()) ?>">
                            <button type="submit" onclick="return confirm('Tem certeza que deseja excluir este livro?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" class="no-data">Nenhum livro cadastrado.</td></tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>