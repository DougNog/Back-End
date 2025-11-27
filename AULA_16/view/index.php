<?php
require_once __DIR__ . '/../controller/BebidaController.php';

$controller = new BebidaController();
$acao = $_POST['acao'] ?? '';
$editarBebida = null;

// --- Processamento das ações ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CRIAR nova bebida
    if ($acao === 'criar') {
        $controller->criar(
            trim($_POST['nome']),
            trim($_POST['categoria']),
            trim($_POST['volume']),
            (float) $_POST['valor'],
            (int) $_POST['qtde']
        );
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    // DELETAR bebida existente
    if ($acao === 'deletar') {
        $controller->deletar(trim($_POST['nome']));
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }

    // ENTRAR NO MODO DE EDIÇÃO
    if ($acao === 'editar') {
        $editarBebida = $controller->buscarPorNome(trim($_POST['nome']));
    }

    // ATUALIZAR bebida existente
    if ($acao === 'atualizar') {
        $controller->atualizar(
            trim($_POST['nome_original']),
            trim($_POST['nome']),
            trim($_POST['categoria']),
            trim($_POST['volume']),
            (float) $_POST['valor'],
            (int) $_POST['qtde']
        );
        header('Location: ' . $_SERVER['REQUEST_URI']);
        exit;
    }
}

// LER bebidas cadastradas
$lista = $controller->ler();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciamento de Bebidas</title>
    <link rel="stylesheet" href="style.css">

</head>
<body>

<h1>Gerenciamento de bebidas</h1>
<br>
<hr>

<?php if ($editarBebida): ?>
    <!-- Formulário de atualização -->
    <form method="POST">
        <input type="hidden" name="acao" value="atualizar">
        <input type="hidden" name="nome_original" value="<?= htmlspecialchars($editarBebida->getNome()) ?>">

        <input type="text" name="nome" placeholder="Nome da bebida:" required value="<?= htmlspecialchars($editarBebida->getNome()) ?>">

        <select name="categoria" required>
            <option value="">Selecione a categoria</option>
            <option value="Refrigerante" <?= $editarBebida->getCategoria() === 'Refrigerante' ? 'selected' : '' ?>>Refrigerante</option>
            <option value="Cerveja" <?= $editarBebida->getCategoria() === 'Cerveja' ? 'selected' : '' ?>>Cerveja</option>
            <option value="Vinho" <?= $editarBebida->getCategoria() === 'Vinho' ? 'selected' : '' ?>>Vinho</option>
            <option value="Destilado" <?= $editarBebida->getCategoria() === 'Destilado' ? 'selected' : '' ?>>Destilado</option>
            <option value="Água" <?= $editarBebida->getCategoria() === 'Água' ? 'selected' : '' ?>>Água</option>
            <option value="Suco" <?= $editarBebida->getCategoria() === 'Suco' ? 'selected' : '' ?>>Suco</option>
            <option value="Energético" <?= $editarBebida->getCategoria() === 'Energético' ? 'selected' : '' ?>>Energético</option>
        </select>

        <input type="text" name="volume" placeholder="Volume (ex: 300ml):" required value="<?= htmlspecialchars($editarBebida->getVolume()) ?>">
        <input type="number" name="valor" step="0.01" placeholder="Valor em Reais (R$):" required value="<?= htmlspecialchars($editarBebida->getValor()) ?>">
        <input type="number" name="qtde" placeholder="Quantidade em estoque:" required value="<?= htmlspecialchars($editarBebida->getQtde()) ?>">

        <button type="submit">Atualizar</button>
    </form>

<?php else: ?>
    <!-- Formulário de criação -->
    <form method="POST">
        <input type="hidden" name="acao" value="criar">
        <input type="text" name="nome" placeholder="Nome da bebida:" required>
        <select name="categoria" required>
            <option value="">Selecione a categoria</option>
            <option value="Refrigerante">Refrigerante</option>
            <option value="Cerveja">Cerveja</option>
            <option value="Vinho">Vinho</option>
            <option value="Destilado">Destilado</option>
            <option value="Água">Água</option>
            <option value="Suco">Suco</option>
            <option value="Energético">Energético</option>
        </select>
        <input type="text" name="volume" placeholder="Volume (ex: 300ml):" required>
        <input type="number" name="valor" step="0.01" placeholder="Valor em Reais (R$):" required>
        <input type="number" name="qtde" placeholder="Quantidade em estoque:" required>
        <button type="submit">Cadastrar</button>
    </form>
<?php endif; ?>

<hr>
<br><br>

<h2>Lista de Bebidas</h2>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>Nome</th>
        <th>Categoria</th>
        <th>Volume</th>
        <th>Valor (R$)</th>
        <th>Quantidade</th>
        <th>Ações</th>
    </tr>

    <?php if (!empty($lista)): ?>
        <?php foreach ($lista as $bebida): ?>
            <tr>
                <td><?= htmlspecialchars($bebida->getNome()) ?></td>
                <td><?= htmlspecialchars($bebida->getCategoria()) ?></td>
                <td><?= htmlspecialchars($bebida->getVolume()) ?></td>
                <td><?= number_format($bebida->getValor(), 2, ',', '.') ?></td>
                <td><?= htmlspecialchars($bebida->getQtde()) ?></td>
                <td>
                    <!-- Botão Editar -->
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="acao" value="editar">
                        <input type="hidden" name="nome" value="<?= htmlspecialchars($bebida->getNome()) ?>">
                        <input type="submit" value="Editar">
                    </form>

                    <!-- Botão Deletar -->
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="acao" value="deletar">
                        <input type="hidden" name="nome" value="<?= htmlspecialchars($bebida->getNome()) ?>">
                        <input type="submit" value="Deletar" onclick="return confirm('Tem certeza que deseja deletar esta bebida?');">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr><td colspan="6">Nenhuma bebida cadastrada.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>
