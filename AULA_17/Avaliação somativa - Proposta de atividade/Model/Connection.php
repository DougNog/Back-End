<?php //* Inicia o código PHP

class Connection { //* Declara a classe responsável por criar e gerenciar a conexão com o MySQL
    private static $instance = null; //* Propriedade estática que guardará a INSTÂNCIA ÚNICA de PDO (padrão Singleton)

    public static function getInstance() { //* Método público/estático que retorna a conexão PDO
        if (!self::$instance) { //* Verifica se a instância ainda não foi criada (ou seja, é null)
            try { //* Inicia um bloco 'try' para capturar erros na conexão
                $host = 'localhost'; //* Endereço do servidor MySQL
                $dbname = 'biblioteca_escolar'; //* Nome DO BANCO que será criado/selecionado
                $user = 'root'; //* Usuário do MySQL
                $pass = ''; //* Senha do MySQL

                self::$instance = new PDO( //* Cria uma nova instância de PDO e armazena em $instance
                    "mysql:host=$host;charset=utf8", //* DSN: define o host e o charset da conexão
                    $user, //* Usuário da conexão
                    $pass  //* Senha da conexão
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                //* Configura o PDO para lançar exceções caso ocorra algum erro SQL

                self::$instance->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                //* Comando SQL para criar o banco se ele ainda não existir
                //* Define charset UTF-8 moderno (utf8mb4) e collation adequado

                self::$instance->exec("USE $dbname");
                //* Seleciona o banco recém-criado para iniciar o uso

            } catch (PDOException $e) { //* Captura erros relacionados ao PDO (conexão falhou, senha errada etc.)
                die("Erro ao conectar ao MySQL: " . $e->getMessage());
                //* Interrompe o script e mostra a mensagem de erro
            }
        }
        return self::$instance; //* Retorna SEMPRE a mesma conexão (padrão Singleton)
    }
}
?> //* Fim do código PHP
