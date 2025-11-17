<?php

namespace Aula_16;

require_once __DIR__ . '\..\controller\BebidaController.php';
$controller = new BebidaController();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $acao = $_POST['acao'] ?? null;
    if ($acao == 'criar') {
        $controller->criar(
            $_POST['nome'],
            $_POST['categoria'],
            $_POST['volume'],
            $_POST['valor'],
            $_POST['qtde']
        );
    } elseif ($acao === 'deletar') {
        $controller->excluir($_POST['nome']);
    } elseif ($acao === 'editar') {
        $controller->atualizar(
            $_POST['nome'],
            $_POST['novoNome'],
            $_POST['novaCategoria'],
            $_POST['novoVolume'],
            $_POST['novoValor'],
            $_POST['novaQtde']
        );
    }
}
?>

<!DOCTYPE html>
<html lang="UTf-8">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Barzin do Zézin</title>

</head>
<body>

    <main>
        <h1>Formulário cadastro de bebidas</h1>
        <form action="" method="POST">
            <input type="hidden" name="acao" value="criar">
            <label for="">Nome:</label>
            <input type="text" name="nome" required>
            <label for="cat">Categoria:</label>
            <select name="categoria" id="cat" required>
                <option value="">Selecione uma categoria</option>
                <option value="cerveja">Cerveja</option>
                <option value="vinho">Vinho</option>
                <option value="destilado">Destilado</option>
                <option value="refrigerante">Refrigerante</option>
                <option value="suco">Suco</option>
                <option value="agua">Água</option>
            </select>

            <label for="">Volume:</label>
            <input type="number" name="volume" step="0.01" required>

            <label for="">Valor:</label>
            <input type="number" name="valor" step="0.01" required>

            <label for="">Quantidade:</label>
            <input type="number" name="qtde" required>
            <button type="submit">Cadastrar</button>
        </form>

        <div class="ler">
            <table>
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Categoria</th>
                        <th>Volume</th>
                        <th>Valor</th>
                        <th>Quantidade</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $bebidas = $controller->ler();
                    foreach ($bebidas as $bebida) {
                        echo "<tr>";
                        echo "<td>{$bebida->getNome()}</td>";
                        echo "<td>{$bebida->getCategoria()}</td>";
                        echo "<td>{$bebida->getVolume()}</td>";
                        echo "<td>{$bebida->getValor()}</td>";
                        echo "<td>{$bebida->getQtde()}</td>";
                        echo "<td>
                                <button onclick=\"abrirModal('{$bebida->getNome()}', '{$bebida->getCategoria()}', {$bebida->getVolume()}, {$bebida->getValor()}, {$bebida->getQtde()})\" class=\"btn-editar\">Editar</button>
                                <form action=\"\" method=\"POST\" style=\"display:inline;\">
                                    <input type=\"hidden\" name=\"acao\" value=\"deletar\">
                                    <input type=\"hidden\" name=\"nome\" value=\"{$bebida->getNome()}\">
                                    <button type=\"submit\" class=\"btn-deletar\">Deletar</button>
                                </form></td>";
                        echo "</tr>";
                    }
                    ?>
                    <form action="" method="POST">
                     <input type="hidden" name="acao" value="deletar">
                    </form>
                <tbody>
                </tbody>
            </table>
    </main>

    <!-- Modal de Edição -->
    <div id="modalEditar" class="modal">
        <div class="modal-content">
            <span class="fechar">&times;</span>
            <h2>Editar Bebida</h2>
            <form action="" method="POST" id="formEditar">
                <input type="hidden" name="acao" value="editar">
                <input type="hidden" name="nome" id="nome_original">
                
                <label for="nome_edit">Nome:</label>
                <input type="text" name="novoNome" id="nome_edit" required>
                
                <label for="categoria_edit">Categoria:</label>
                <select name="novaCategoria" id="categoria_edit" required>
                    <option value="">Selecione uma categoria</option>
                    <option value="cerveja">Cerveja</option>
                    <option value="vinho">Vinho</option>
                    <option value="destilado">Destilado</option>
                    <option value="refrigerante">Refrigerante</option>
                    <option value="suco">Suco</option>
                    <option value="agua">Água</option>
                </select>

                <label for="volume_edit">Volume:</label>
                <input type="number" name="novoVolume" id="volume_edit" step="0.01" required>

                <label for="valor_edit">Valor:</label>
                <input type="number" name="novoValor" id="valor_edit" step="0.01" required>

                <label for="qtde_edit">Quantidade:</label>
                <input type="number" name="novaQtde" id="qtde_edit" required>
                
                <button type="submit">Salvar Alterações</button>
            </form>
        </div>
    </div>

    <script>
        // Função para abrir o modal
        function abrirModal(nome, categoria, volume, valor, qtde) {
            document.getElementById('modalEditar').style.display = 'block';
            document.getElementById('nome_original').value = nome;
            document.getElementById('nome_edit').value = nome;
            document.getElementById('categoria_edit').value = categoria;
            document.getElementById('volume_edit').value = volume;
            document.getElementById('valor_edit').value = valor;
            document.getElementById('qtde_edit').value = qtde;
        }

        // Fechar o modal quando clicar no X
        document.querySelector('.fechar').onclick = function() {
            document.getElementById('modalEditar').style.display = 'none';
        }

        // Fechar o modal quando clicar fora dele
        window.onclick = function(event) {
            if (event.target == document.getElementById('modalEditar')) {
                document.getElementById('modalEditar').style.display = 'none';
            }
        }
    </script>
</body>
</html>