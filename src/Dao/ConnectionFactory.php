<?php 

    class ConnectionFactory{
        static $connection;

        public static function getConnection(){
            if(!isset($connection)){
                $host = "localhost";
                $dbName = "livraria";
                $port = 3306;
                $user = "root";
                $pass = "";

                try{
                    $connection = new PDO("mysql:host=$host;dbname=$dbName;port=$port",$user,$pass);

                }catch(PDOException $ex){
                    echo"Erro ao conectar no banco de dados <p>$ex</p>";
                }
            }
            return $connection;
        }
    }

?>