    <?php 
        require_once "Produto.php";
        require_once "ProdutoDAO.php";
    // Objeto da classe 
    $dao = new ProdutoDAO();

    //Crie mais 8 objetos: Tomate, maca, queijo-brie,
    // Iogurte grego, Guarana Jesus, Bolacha Bono, Desinfetante Urca e Prestobarba Bic. 
    // Determine os precos por conta e os codigos de forma aleatoria.

    // Create
$dao->criarProdutos(new Produtos(1, "Tomate", 5.00));

$dao->criarProdutos(new Produtos(2, "Maçã", 2.86));

$dao->criarProdutos(new Produtos(3, "Queijo Brie", 20.90));

$dao->criarProdutos(new Produtos(4, "Iogurte Grego", 6.99));

$dao->criarProdutos(new Produtos(5, "Guaraná Jesus", 8.20));

$dao->criarProdutos(new Produtos(6, "Bolacha Bono", 5.35));

$dao->criarProdutos(new Produtos(7, "Desinfetante Urca", 7.99));

$dao->criarProdutos(new Produtos(8, "Prestobarba Bic", 14.90));

    

    //READ
    echo "Listagem inicial:\n   ";
    foreach($dao -> lerProdutos() as $produtos){
        echo "{$produtos -> getCodigo()} - {$produtos -> getNome()} - {$produtos -> getPreco()}\n";
    }


    // Modifique o Desinfetante Urca para Desinfetante Barbarex, e ao menos 2 valores dos 
    // Preços que voce determinou.

    // Update   
    $dao -> atualizarProdutos(7, "Desinfetante Barbarex", "5.50");

    $dao -> atualizarProdutos(8, "Prestobarba Bic", "9");

    $dao -> atualizarProdutos(5, "Guaraná Jesus", "7");




    echo "\nListagem após atualização:\n";
    foreach($dao -> lerProdutos() as $produtos){
        echo "{$produtos -> getCodigo()} - {$produtos -> getNome()} - {$produtos -> getPreco()}\n";
    }


    // Apague a maca e o tomate dos produtos (aqui nao somos saudaveis).

    //DELETE
    $dao -> excluirProdutos(1);
    $dao -> excluirProdutos(2);

    echo "\nListagem após exclusão:\n";
    foreach($dao -> lerProdutos() as $produtos){
        echo "{$produtos -> getCodigo()} - {$produtos -> getNome()} - {$produtos -> getPreco()}\n";
    }