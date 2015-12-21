<?php
/********************
 * Auteurs : Jérôme Chételat / Philippe Ku
 * Ecole/Classe : CFPT Informatique
 * Date : 02.12.15
 * Programme : Local.ch
 * Fichier : User.php
 * Version : 1.0
 *******************/
require './DatabaseConnector.php';


class User
{
    const SALT = "salt";

    public $firstname = null;
    public $lastname = null;
    public $username = null;
    public $email = null;
    public $group = null;
    public $position = null;

    private $prp_selectUser = null;
    private $prp_insertUser = null;
    private $prp_checkLogin = null;

    private $dbc = null;

    public function __construct()
    {

        $this->dbc = new DatabaseConnector("localhost", "geolocation", "m151admin", "m151admin");

        $this->prp_selectUser = $this->dbc->prepare("select firstname, lastname, email, username, group, latlng from usersinfo where email = :email");
        $this->prp_insertUser = $this->dbc->prepare("insert into " . $this->dbc->getDbName() . ".users (`firstname`, `lastname`, `username`, `email`, `password`, `id_pos`) values (:firstname, :lastname, :username, :email, :password, :id_pos) ");
        $this->prp_checkLogin = $this->dbc->prepare("select id from " . $this->dbc->getDbName() . ".users where username = :username and password = :password");
    }

    public function selectUser($email)
    {
        $isok = false;
        try {
            $this->prp_selectUser->bindParam(':email', $email, PDO::PARAM_STR);
            $isok = $this->prp_selectUser->execute();
            if ($isok) {
                $infos = $this->prp_selectUser->fetch(PDO::FETCH_OBJ);
                $this->firstname = $infos->firstname;
                $this->lastname = $infos->lastname;
                $this->username = $infos->username;
                $this->group = $infos->id_group;
                $this->position = new Position();
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $isok;
    }

    public function InsertUserIntoDataBase($firstname, $lastname, $username, $email, $password, $latlng, $address)
    {
        $password = sha1($password . SALT);
        $position = new Position();
        $position->InsertPosition($latlng, $address);
        $isok = false;
        try {
            $this->prp_insertUser->bindParam(':firstname', $firstname);
            $this->prp_insertUser->bindParam(':lastname', $lastname);
            $this->prp_insertUser->bindParam(':username', $username);
            $this->prp_insertUser->bindParam(':email', $email);
            $this->prp_insertUser->bindParam(':password', $password);
            $this->prp_insertUser->bindParam(':id_pos', $position->GetPositionId($latlng));
            $isok = $this->prp_insertUser->execute();
        } catch (PDOException $e) {
            echo $e->getCode() . " \n";
            echo $e->getMessage();
            $isok = false;
        }
        return $isok;
    }

    public function CheckLogin($username, $password)
    {
        $password = sha1($password . SALT);
        try {
            $this->prp_checkLogin->bindParam(':username', $username);
            $this->prp_checkLogin->bindParam(':password', $password);
            $isok = $this->prp_checkLogin->execute();

            if($isok)
            {
                if($this->prp_checkLogin->rowCount() > 0)
                {
                    return true;
                }
                else{
                    return false;
                }
            }

        } catch (PDOException $e) {
            die($e->getCode() . ", " . $e->getMessage());
        }
    }
}
