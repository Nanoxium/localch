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
    public $host = null;
    public $dbname = null;
    public $username = null;

    private $password = null;
    private $dbc = null;

    public function __construct($host, $dbname, $username, $password)
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
    }

    public function getDbc()
    {
        try{
            if($this->dbc == null)
                $this->dbc = new PDO("mysql:host=localhost;dbname=geolocation;", "m151admin", "m151admin", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_PERSISTENT => true));
        }catch (Exception $e)
        {
            echo $e->getCode();
            echo $e->getMessage();
            die("could not connect to the database !");
        }

        return $this->dbc;
    }
}