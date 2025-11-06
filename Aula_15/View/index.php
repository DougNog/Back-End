<?php
require_once __DIR__ . '/../controller/BebidaController.php';
$controller = new BebidaController();

$bebidaEdit = null;

// Ações de CRUD
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['acao'] === 'criar') {
        $controller->criar($_POST['nome'], $_POST['categoria'], $_POST['volume'], $_POST['valor'], $_POST['qtde']);
    } elseif ($_POST['acao'] === 'deletar') {
        $controller->deletar($_POST['nome']);
    } elseif ($_POST['acao'] === 'editar') {
        $controller->atualizar($_POST['nome'], $_POST['valor'], $_POST['qtde']);
    }
}

// Se for GET com ?edit=nome, carrega bebida para edição
if (isset($_GET['edit'])) {
    $listaTemp = $controller->ler();
    $nomeEdit = $_GET['edit'];
    if (isset($listaTemp[$nomeEdit])) {
        $bebidaEdit = $listaTemp[$nomeEdit];
    }
}

$lista = $controller->ler();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Bebidas</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <h1>Cadastro de Bebidas</h1>

    <form method="POST">
        <input type="hidden" name="acao" value="<?= $bebidaEdit ? 'editar' : 'criar' ?>">

        <input type="text" name="nome" placeholder="Nome da bebida" required
               value="<?= $bebidaEdit ? htmlspecialchars($bebidaEdit->getNome()) : '' ?>"
               <?= $bebidaEdit ? 'readonly' : '' ?>>

        <select name="categoria" <?= $bebidaEdit ? 'disabled' : '' ?> required>
            <option value="">Selecione a categoria</option>
            <?php
            $categorias = ["Refrigerante", "Cerveja", "Vinho", "Destilado", "Água", "Suco", "Energético"];
            foreach ($categorias as $cat) {
                $selected = ($bebidaEdit && $bebidaEdit->getCategoria() === $cat) ? 'selected' : '';
                echo "<option value='$cat' $selected>$cat</option>";
            }
            ?>
        </select>

        <input type="text" name="volume" placeholder="Volume (ex: 300ml)" required
               value="<?= $bebidaEdit ? htmlspecialchars($bebidaEdit->getVolume()) : '' ?>"
               <?= $bebidaEdit ? 'readonly' : '' ?>>

        <input type="number" name="valor" step="0.01" placeholder="Valor R$"
               value="<?= $bebidaEdit ? htmlspecialchars($bebidaEdit->getValor()) : '' ?>" required>

        <input type="number" name="qtde" placeholder="Quantidade"
               value="<?= $bebidaEdit ? htmlspecialchars($bebidaEdit->getQtde()) : '' ?>" required>

        <button type="submit"><?= $bebidaEdit ? 'Salvar Alterações' : 'Cadastrar' ?></button>

        <?php if ($bebidaEdit): ?>
            <a href="index.php" style="margin-left:10px; text-decoration:none; color:#0077ff;">Cancelar Edição</a>
        <?php endif; ?>
    </form>

    <h2>Bebidas Cadastradas</h2>
    <table>
        <thead>
        <tr>
            <th>Nome</th>
            <th>Categoria</th>
            <th>Volume</th>
            <th>Valor (R$)</th>
            <th>Quantidade</th>
            <th>Ações</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($lista) > 0): ?>
            <?php foreach ($lista as $bebida): ?>
                <tr>
                    <td><?= htmlspecialchars($bebida->getNome()) ?></td>
                    <td><?= htmlspecialchars($bebida->getCategoria()) ?></td>
                    <td><?= htmlspecialchars($bebida->getVolume()) ?></td>
                    <td><?= htmlspecialchars(number_format($bebida->getValor(), 2, ',', '.')) ?></td>
                    <td><?= htmlspecialchars($bebida->getQtde()) ?></td>
                    <td class="actions">
                        <form method="GET" style="display:inline;">
                            <input type="hidden" name="edit" value="<?= htmlspecialchars($bebida->getNome()) ?>">
                            <button type="submit">Editar</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="acao" value="deletar">
                            <input type="hidden" name="nome" value="<?= htmlspecialchars($bebida->getNome()) ?>">
                            <button type="submit" onclick="return confirm('Deseja excluir esta bebida?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="6" class="no-data">Nenhuma bebida cadastrada ainda</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
