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
    private  $dbname = null;
    private  $host = null;
    private  $username = null;
    private  $password = null;

    private $dbc = null;

    /**
     * DatabaseConnector constructor.
     * @param $host the hostname
     * @param $dbname the database name
     * @param $username the user to connect with
     * @param $password the password of the user
     */
    public function __construct($host = "localhost", $dbname = "geolocation", $username = "m151admin", $password = "m151admin")
    {
        $this->host = $host;
        $this->dbname = $dbname;
        $this->username = $username;
        $this->password = $password;
        $this->getDbc();
    }

    /**
     * Return a pdo
     * @return null|PDO the pdo connector
     */
    public function getDbc()
    {
        if($this->dbc == null) {
            try{
                $this->dbc = new PDO("mysql:host=".$this->host .";dbname=". $this->dbname .";", $this->username, $this->password,
                    array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8", PDO::ATTR_PERSISTENT => true));
            }catch (Exception $e)
            {
                echo $e->getCode();
                echo $e->getMessage();
                die("could not connect to the database !");
            }
        }
        return $this->dbc;
    }

    public function getDbName()
    {
        return $this->dbname;
    }

    public function prepare($statement)
    {
        return $this->getDbc()->prepare($statement);
    }
}