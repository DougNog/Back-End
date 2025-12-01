<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Catálogo de Livros - Biblioteca Escolar</title>
    <link rel="stylesheet" href="style.css">
    <!-- Importa o CSS externo -->
</head>
<body>

<div class="container">
    <!-- Bloco principal da página -->

    <h1 id="titulo_principal">Catálogo de Livros - Biblioteca Escolar</h1>
    <hr>

    <!-- Exibição de mensagens armazenadas na sessão -->
    <?php if (!empty($_SESSION['mensagem'])): ?>
        <p style="color:red; font-weight:bold; font-size:16px;">
            <?= htmlspecialchars($_SESSION['mensagem']); ?>
            <!-- htmlspecialchars evita XSS -->
        </p>
        <?php unset($_SESSION['mensagem']); ?>
        <!-- Apaga a mensagem após exibir (flash message) -->
    <?php endif; ?>

    <?php if ($editarLivro): ?>
        <!-- SE estiver editando, exibe o formulário preenchido -->

        <form id="cadastro" method="POST">
            <input type="hidden" name="acao" value="atualizar">
            <!-- Diz ao backend que este formulário é de atualização -->

            <input type="hidden" name="titulo_original"
                   value="<?= htmlspecialchars($editarLivro->getTitulo()) ?>">
            <!-- Guarda o título original para localizar o registro -->

            <!-- Campos preenchidos com os valores atuais -->
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
            <!-- Botão do modo edição -->
        </form>

    <?php else: ?>

        <!-- Formulário padrão para cadastrar novo livro -->
        <form method="POST">
            <input type="hidden" name="acao" value="criar">
            <!-- Indica ação de criação -->

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
            <!-- Cabeçalho da tabela -->
            <th>Título</th>
            <th>Autor</th>
            <th>Ano</th>
            <th>Gênero</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>

        <?php if (!empty($listaLivros)): ?>
            <!-- Se houver livros cadastrados... -->

            <?php foreach ($listaLivros as $livro): ?>
                <tr>
                    <!-- Exibe cada dado nas colunas -->
                    <td><?= htmlspecialchars($livro->getTitulo()) ?></td>
                    <td><?= htmlspecialchars($livro->getAutor()) ?></td>
                    <td><?= htmlspecialchars($livro->getAno()) ?></td>
                    <td><?= htmlspecialchars($livro->getGenero()) ?></td>
                    <td><?= htmlspecialchars($livro->getQuantidade()) ?></td>

                    <td class="actions">
                        <!-- Botão editar -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="acao" value="editar">
                            <input type="hidden" name="titulo" value="<?= htmlspecialchars($livro->getTitulo()) ?>">
                            <button type="submit">Editar</button>
                        </form>

                        <!-- Botão excluir com confirmação JS -->
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

            <!-- Caso não haja livros -->
            <tr>
                <td colspan="6" class="no-data">Nenhum livro cadastrado.</td>
            </tr>

        <?php endif; ?>

    </table>

</div>

</body>
</html>
