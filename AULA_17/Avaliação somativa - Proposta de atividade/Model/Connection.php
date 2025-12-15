<?php

class Connection {
    //* Declara a classe Connection, responsável por criar e gerenciar a conexão com o banco de dados.

    private static $instance = null;
    //* Propriedade estática privada que armazenará a única instância da conexão PDO (padrão Singleton).
    //* Inicia como null para indicar que a conexão ainda não foi criada.

    public static function getInstance() {
        //* Método público e estático que retorna a instância da conexão PDO.
        //* Por ser estático, pode ser chamado sem instanciar a classe.

        if (!self::$instance) {
            //* Verifica se a instância ainda não existe.
            //* Isso garante que apenas uma conexão seja criada durante toda a aplicação.

            try {
                //* Inicia um bloco try para capturar possíveis erros de conexão com o banco.

                $host = 'localhost';
                //* Define o endereço do servidor MySQL (localhost = servidor local).

                $dbname = 'biblioteca_escolar';
                //* Define o nome do banco de dados que será usado/criado.

                $user = 'root';
                //* Define o usuário do MySQL.

                $pass = '';
                //* Define a senha do MySQL (vazia no ambiente local).

                self::$instance = new PDO(
                    //* Cria uma nova instância de PDO e armazena na propriedade estática $instance.

                    "mysql:host=$host;charset=utf8",
                    //* DSN (Data Source Name): informa o driver MySQL, o host e o charset UTF-8.

                    $user,
                    //* Usuário do banco de dados.

                    $pass
                    //* Senha do banco de dados.
                );

                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //* Configura o PDO para lançar exceções quando ocorrerem erros de banco de dados.
                //* Isso facilita o tratamento e a identificação de falhas.

                self::$instance->exec(
                    "CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
                );
                //* Executa um comando SQL para criar o banco de dados caso ele ainda não exista.
                //* Define charset utf8mb4 para suportar acentos, emojis e caracteres especiais.

                self::$instance->exec("USE $dbname");
                //* Seleciona o banco de dados que será utilizado nas próximas operações SQL.

            } catch (PDOException $e) {
                //* Captura qualquer erro lançado pelo PDO durante a conexão ou execução dos comandos SQL.

                die("Erro ao conectar ao MySQL: " . $e->getMessage());
                //* Encerra a execução do script e exibe a mensagem de erro.
            }
        }

        return self::$instance;
        //* Retorna a instância única da conexão PDO.
        //* Se já existir, apenas retorna a mesma conexão.
    }
}
?>
