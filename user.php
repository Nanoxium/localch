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
require './position.php';


class User
{
    public $firstname = null;
    public $lastname = null;
    public $username = null;
    public $email = null;
    public $group = null;
    public $position = null;

    private $salt = "secret";
    private $prp_selectUser = null;
    private $prp_insertUser = null;
    private $prp_checkLogin = null;
    private $prp_selectAllUsers = null;

    private $dbc = null;

    public function __construct()
    {

        $this->dbc = new DatabaseConnector("localhost", "geolocation", "m151admin", "m151admin");

        $this->prp_selectAllUsers = $this->dbc->prepare("select firstname, lastname, address, latlng from " . $this->dbc->getDbName() . ".userinfo");
        $this->prp_selectUser = $this->dbc->prepare("select firstname, lastname, email, username, group, latlng from usersinfo where username = :username");
        $this->prp_insertUser = $this->dbc->prepare("insert into " . $this->dbc->getDbName() . ".users (`firstname`, `lastname`, `username`, `email`, `password`, `id_pos`) values (:firstname, :lastname, :username, :email, :password, :id_pos) ");
        $this->prp_checkLogin = $this->dbc->prepare("select id from " . $this->dbc->getDbName() . ".users where username = :username and password = :password");
    }

    /**
     * Retourne la liste des utilisateurs du site internet et leur information
     * @return array|null la liste des utilisateurs
     */
    public function selectAllUsers($format = PDO::FETCH_OBJ)
    {
        try {
            $isok = $this->prp_selectAllUsers->execute();
        }
        catch(Exception $e)
        {
            $isok = false;
        }
        return ($isok) ? $this->prp_selectAllUsers->fetchAll($format) : null;
    }

    public function selectUser($username)
    {
        $isok = false;
        try {
            $this->prp_selectUser->bindParam(':username', $username, PDO::PARAM_STR);
            $isok = $this->prp_selectUser->execute();
            if ($isok) {
                $infos = $this->prp_selectUser->fetch(PDO::FETCH_OBJ);
                $this->firstname = $infos->firstname;
                $this->lastname = $infos->lastname;
                $this->username = $infos->username;
                $this->group = $infos->id_group;
                $this->position = new Position();
                $this->position->GetPosition($infos->id_pos);
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $isok;
    }

    public function InsertUserIntoDataBase($firstname, $lastname, $username, $email, $password, $latlng, $address)
    {
        $password = sha1($password . $this->salt);
        $position = new Position();
        $position->InsertPosition($latlng, $address);
        $username = strtolower($username);
        $pos = $position->GetPositionId($latlng);
        try {
            $this->prp_insertUser->bindParam(':firstname', $firstname);
            $this->prp_insertUser->bindParam(':lastname', $lastname);
            $this->prp_insertUser->bindParam(':username', $username);
            $this->prp_insertUser->bindParam(':email', $email);
            $this->prp_insertUser->bindParam(':password', $password);
            var_dump($pos);
            $this->prp_insertUser->bindParam(':id_pos', $pos->id, PDO::PARAM_INT);
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
        $password = sha1($password . $this->salt);
        try {
            $this->prp_checkLogin->bindParam(':username', $username);
            $this->prp_checkLogin->bindParam(':password', $password);
            $isok = $this->prp_checkLogin->execute();

            if($isok)
            {
                var_dump($this->prp_checkLogin->fetchAll());
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
        return false;
    }
}
