<!doctype html>
<html lang="pt-BR">
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="style.css">
<title>Formulário - Cadastrar Bebida</title>
<style>body{font-family:Arial;padding:20px}input,select{display:block;margin:8px 0;padding:8px;width:300px}</style>
</head>
<body>
<h1>Cadastrar / Atualizar Bebida</h1>
<form method="post" action="/">
    <input type="hidden" name="action" value="create">
    <label>Nome <input type="text" name="nome" required></label>
    <label>Categoria
        <select name="categoria" required>
            <option value="Refrigerante">Refrigerante</option>
            <option value="Cerveja">Cerveja</option>
            <option value="Vinho">Vinho</option>
            <option value="Destilado">Destilado</option>
            <option value="Água">Água</option>
            <option value="Suco">Suco</option>
            <option value="Energético">Energético</option>
        </select>
    </label>
    <label>Volume <input type="text" name="volume" placeholder="ex: 350ml" required></label>
    <label>Valor (R$) <input type="number" name="valor" step="0.01" required></label>
    <label>Quantidade <input type="number" name="qtde" required></label>
    <button type="submit">Salvar</button>
</form>
<p><a href="/">Voltar</a></p>
</body>
</html>
