<?php
/*******************
* Auteurs : Jérôme Chételat / Philippe Ku
* Ecole/Classe : CFPT Informatique
* Date : 02.12.15
* Programme : Local.ch
* Fichier : Position.php
* Version : 1.0
*******************/


class Position
{
    public $lat = null;
    public $lng = null;
    public $adress = null;

    private $dbc = null;
    private $prp_selectPosition = null;

    public function __construct()
    {

    }
}