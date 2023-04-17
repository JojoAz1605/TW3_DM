<?php
/**
 * Fonctions utiles au bon fonctionnement du site
 * @author Joris MASSON
 * @author Le cours
 */

/**
 * Compte les erreurs dans un array d'erreurs.
 * @param array $errArray un array d'erreurs
 * @return int le nombre d'erreurs
 */
function count_errors(array $errArray): int
{
    $res = count($errArray);
    foreach ($errArray as $value) {
        if (is_null($value)) {
            $res--;
        }
    }
    return $res;
}

/**
 * Se connecte à la base de données, et renvoie sa connexion.
 * @return PDO|void
 */
function connecter(): PDO
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
        return ($connection);


    } catch (Exception $e) {
        echo "Connection à MySQL impossible : ", $e->getMessage();
        die();
    }
}
