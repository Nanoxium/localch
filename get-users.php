<?php
/********************
 * Auteurs : Jérôme Chételat / Philippe Ku
 * Ecole/Classe : CFPT Informatique
 * Date : 02.12.15
 * Programme : Local.ch
 * Fichier : get-users.php
 * Version : 1.0
 *******************/
require_once 'user.php';

$u = new User();
//Encode la liste des utilisateurs en json et les envoi dans le stream
echo json_encode($u->selectAllUsers());