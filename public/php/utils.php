<?php
function count_errors(array $errArray): int
{
    $res = count($errArray);
    foreach ($errArray as $value) {if (is_null($value)) {$res--;}}
    return $res;
}

function connecter()
{
    try {
        // Options de connection
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        $DATABASE_DNS = "mysql:host=jo.narukami-edition.fr;dbname=TW3;charset=utf8";
        $DATABASE_USERNAME = "jo";
        $DATABASE_PASSWORD = "20051805";
        
        $connection = new PDO($DATABASE_DNS, $DATABASE_USERNAME, $DATABASE_PASSWORD, $options);
        return($connection);


    } catch ( Exception $e ) {
        echo "Connection à MySQL impossible : ", $e->getMessage();
        die();
    }
}
