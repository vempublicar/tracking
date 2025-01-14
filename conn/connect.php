<?php
function db_connect()
{
    try {
        $dbhost = 'auth-db1184.hstgr.io'; // Host do banco de dados
        $dbname = 'u821650166_dataTracking'; // Nome do banco de dados
        $charset = 'utf8mb4'; // Conjunto de caracteres recomendado
        $username = 'u821650166_noreply'; // Usuário do banco de dados
        $password = 'Henrique**251251'; // Senha do banco de dados

        // Montando a DSN para conexão PDO
        $dsn = "mysql:host={$dbhost};dbname={$dbname};charset={$charset}";
        
        // Criando a conexão PDO
        $pdo = new PDO($dsn, $username, $password);

        // Configurando o modo de erro para exceções
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $pdo;

    } catch (Exception $e) {
        // Em caso de erro, você pode exibir uma mensagem personalizada ou redirecionar
        die('Erro ao conectar ao banco de dados: ' . $e->getMessage());
        // header('location:https://vemfacil.com/v_erro&tipo=access');
    }
}
?>
