<?php
/********************
 * Auteurs : Jérôme Chételat / Philippe Ku
 * Ecole/Classe : CFPT Informatique
 * Date : 02.12.15
 * Programme : Local.ch
 * Fichier : User.php
 * Version : 1.0
 *******************/

class User {

    public $firstname = null;
    public $lastname = null;
    public $email = null;
    public $group = null;
    public $position = null;
    private $password = null;

    private $prp_selectUser = null;
    private $prp_insertUser = null;

    public function __construct($email, $firstname, $lastname, $password) {
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;
        $this->password = $password;


        $this->prp_selectUser = DatabaseConnector::getDbc()->prepare("select surname, lastname, email from users where email = :email");
        $this->prp_insertUser = DatabaseConnector::getDbc()->prepare("insert into `users`");

    }

    public function selectUser($email){
        try{
            $this->prp_selectUser->bindParam(':email', $email, PDO::PARAM_STR);
            $isok = $this->prp_selectUser->execute();
            if($isok)
            {
                $infos = $this->prp_selectUser->fetch(PDO::FETCH_OBJ);

                $this->firstname = $infos->firstname;
                $this->lastname = $infos->lastname;
            }
        }catch (PDOException $e)
        {
        }
    }

    public function InsertUserIntoDataBase()
    {
        try{

        }catch(PDOException $e)
        {
            echo $e->getCode() . " \n";
            echo $e->getMessage();
        }
    }
}
