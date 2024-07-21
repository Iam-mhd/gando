<?php
$dbhost = 'localhost';
$dbname = 'mvc1';
$dbuser = 'root';
$dbpswd = '';

try {
    $database = new PDO('mysql:host='.$dbhost.';dbname='.$dbname, $dbuser, $dbpswd, [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
    ]);
} catch (PDOException $e) {
    die("Une erreur est survenue lors de la connexion à la base de données !");
}

?>
