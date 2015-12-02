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
    private $dbc = null;
    private $prp_selectUser = null;

    public function __construct() {
        
    }

    public function selectUser($email) {
        throw new Exception("Not implemented");
    }

}
