<?php
/*******************
* Auteurs : Jérôme Chételat / Philippe Ku
* Ecole/Classe : CFPT Informatique
* Date : 02.12.15
* Programme : Local.ch
* Fichier : DatabaseConnector.php
* Version : 1.0
*******************/

class DatabaseConnector
{
    private static $host = "localhost";
    public static $dbname = "m152";
    private static $username = "m151admin";

    private static $password = "m151admin";
    private static $dbc = null;

    private function __construct($host, $dbname, $username, $password)
    {
        try{
            self::$dbc = new PDO("mysql:host=".$host .";dbname=". $dbname .";", $username, $password,
                array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_PERSISTENT => true));
        }catch (Exception $e)
        {
            echo $e->getCode();
            echo $e->getMessage();
            die("could not connect to the database !");
        }
    }

    public static function getDbc()
    {
        if(self::$dbc == null)
            new DBConnector(self::$host, self::$dbname,self::$username, self::$password);

        return self::dbc;
    }
}