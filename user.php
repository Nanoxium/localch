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

    //Sel d'encryption
    private $salt = "secret";

    private $prp_selectUser = null;
    private $prp_insertUser = null;
    private $prp_checkLogin = null;
    private $prp_selectAllUsers = null;

    private $dbc = null;

    //Constructeur
    public function __construct()
    {

        $this->dbc = new DatabaseConnector("localhost", "geolocation", "m151admin", "m151admin");

        //crée les prepare statement
        $this->prp_selectAllUsers = $this->dbc->prepare("select firstname, lastname, address, latlng from " . $this->dbc->getDbName() . ".userinfo");
        $this->prp_selectUser = $this->dbc->prepare("select firstname, lastname, email, username, name, latlng from userinfo where username = :username");
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

    /**
     * Met à jour les champs de l'objet user à partie d'un nom d'utilisateur
     * @param $username nom d'utilisateur
     * @return bool opération bien effectué
     */
    public function selectUser($username)
    {
        $isok = false;
        try {
            $this->prp_selectUser->bindParam(':username', $username, PDO::PARAM_STR);
            $isok = $this->prp_selectUser->execute();

            //Met à jour les champs si des valeurs ont été retournées
            if ($isok) {
                $infos = $this->prp_selectUser->fetch(PDO::FETCH_OBJ);
                $this->firstname = $infos->firstname;
                $this->lastname = $infos->lastname;
                $this->username = $infos->username;
                $this->group = $infos->name;
                $this->position = new Position();
                $this->position->GetPosition($infos->id_pos);
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $isok;
    }

    /**
     * Ajoute un utilisateur dans la base de données
     * @param $firstname le prénom
     * @param $lastname le nom
     * @param $username le nom d'utilisateur
     * @param $email l'adresse email
     * @param $password le mot de passe
     * @param $latlng la latitude et longitude sous le format : (lat,long)
     * @param $address l'adresse physique
     * @return bool opération bien effetué
     */
    public function InsertUserIntoDataBase($firstname, $lastname, $username, $email, $password, $latlng, $address)
    {
        //Encrypte le mot de passe avec le sel
        $password = sha1($password . $this->salt);
        $position = new Position();

        //Insert la nouvelle position dans la base de données
        $position->InsertPosition($latlng, $address);
        $username = strtolower($username);

        //Récupère l'id de la position à partir de l'adresse
        $pos = $position->GetPositionId($address);
        try {
            $this->prp_insertUser->bindParam(':firstname', $firstname);
            $this->prp_insertUser->bindParam(':lastname', $lastname);
            $this->prp_insertUser->bindParam(':username', $username);
            $this->prp_insertUser->bindParam(':email', $email);
            $this->prp_insertUser->bindParam(':password', $password);
            $this->prp_insertUser->bindParam(':id_pos', $pos->id, PDO::PARAM_INT);
            $isok = $this->prp_insertUser->execute();
        } catch (PDOException $e) {
            echo $e->getCode() . " \n";
            echo $e->getMessage();
            $isok = false;
        }
        return $isok;
    }

    /**
     * Vérifie la combinaison: nom d'utilisateur, mot de passe
     * @param $username nom d'utilisateur
     * @param $password mot de passe
     * @return bool utilisateur bien ajouté
     */
    public function CheckLogin($username, $password)
    {
        //Encrypte le mot de passe avec un sel
        $password = sha1($password . $this->salt);

        //Normalise le nom d'utilisateur
        $username = strtolower($username);
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
        return false;
    }
}
