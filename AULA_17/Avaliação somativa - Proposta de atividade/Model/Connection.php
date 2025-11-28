<?php //* Inicia o código PHP

class Connection { //* Declara a classe responsável pela conexão com o banco de dados
    private static $instance = null; //* Propriedade estática que armazenará a instância única de PDO (padrão Singleton)

    public static function getInstance() { //* Método estático para obter/criar a instância de conexão
        if (!self::$instance) { //* Se ainda não existe uma instância criada...
            try { //* Tenta executar o bloco de código que abre a conexão
                $host = 'localhost'; //* Endereço do servidor MySQL
                $dbname = 'biblioteca_escolar'; //* Nome do banco de dados que será usado/criado
                $user = 'root'; //* Usuário do MySQL
                $pass = 'senaisp'; //* Senha do MySQL

                self::$instance = new PDO( //* Cria um novo objeto PDO e o guarda em $instance
                    "mysql:host=$host;charset=utf8", //* DSN: define o host do MySQL e o charset de conexão
                    $user, //* Usuário para conexão
                    $pass  //* Senha para conexão
                );
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                //* Configura o PDO para lançar exceções em caso de erro

                self::$instance->exec("CREATE DATABASE IF NOT EXISTS $dbname CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
                //* Garante que o banco 'biblioteca_escolar' exista, criando-o se necessário, com charset/collation apropriados

                self::$instance->exec("USE $dbname");
                //* Seleciona o banco de dados que será utilizado nas próximas operações SQL

            } catch (PDOException $e) { //* Se ocorrer um erro de PDO (ex.: conexão falhou)
                die("Erro ao conectar ao MySQL: " . $e->getMessage());
                //* Encerra o script e exibe a mensagem de erro
            }
        }
        return self::$instance; //* Retorna sempre a mesma instância de conexão (Singleton)
    }
}
?> 
