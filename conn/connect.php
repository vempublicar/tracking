<?php
function db_connect()
{
    try {
        $dbhost = 'bdvemfacil.cosinrqg7wgt.us-east-2.rds.amazonaws.com';
        $dbport = '3306';
        $dbname = 'db_vemfacil';
        $charset = 'utf8' ;
    
        $dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname};charset={$charset}";
        $username = 'vempublicar';
        $password = 'Vemfacil**251251';
    
        $pdo = new PDO($dsn, $username, $password);
      
        return $pdo;

        } catch (Exception $e) {
          //  header('location:https://vemfacil.com/v_erro&tipo=access'); //retorna para página com erro de acesso ao banco de dados.
        }
}


?>