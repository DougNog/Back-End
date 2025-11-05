<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
<title>Lista de Bebidas</title>
<style>body{font-family:Arial;padding:20px}table{border-collapse:collapse;width:100%}td,th{border:1px solid #ddd;padding:8px}th{background:#f2f2f2}</style>
</head>
<body>
<h1>Lista de Bebidas</h1>
<a href="/?action=form">+ Cadastrar nova</a>
<table>
<thead><tr><th>Nome</th><th>Categoria</th><th>Volume</th><th>Valor (R$)</th><th>Qtde</th><th>Ações</th></tr></thead>
<tbody>
<?php if(empty($bebidas)): ?>
<tr><td colspan="6">Nenhuma bebida cadastrada.</td></tr>
<?php else: foreach($bebidas as $b): ?>
<tr>
    <td><?= htmlspecialchars($b->getNome()) ?></td>
    <td><?= htmlspecialchars($b->getCategoria()) ?></td>
    <td><?= htmlspecialchars($b->getVolume()) ?></td>
    <td><?= number_format($b->getValor(), 2, ',', '.') ?></td>
    <td><?= htmlspecialchars($b->getQtde()) ?></td>
    <td>
        <form method="post" action="/" style="display:inline">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="nome" value="<?= htmlspecialchars($b->getNome()) ?>">
            <button type="submit" onclick="return confirm('Deletar <?= addslashes($b->getNome()) ?>?')">Deletar</button>
        </form>
    </td>
</tr>
<?php endforeach; endif; ?>
</tbody>
</table>
</body>
</html>
