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
    public $id = null;
    public $latlng = null;
    public $adress = null;

    private $dbc = null;
    private $prp_insertPosition = null;
    private $prp_selectPosition = null;
    private $prp_selectPositionId = null;
    public function __construct()
    {

        $this->dbc = new DatabaseConnector("localhost", "geolocation", "m151admin", "m151admin");
        $this->prp_insertPosition = $this->dbc->prepare("insert into " . $this->dbc->getDbName() . ".position (latlng, adress) values (:latlng, :address)");
        $this->prp_selectPosition = $this->dbc->prepare("select latlng from positions where id = :id");
        $this->prp_selectPositionId = $this->dbc->prepare("select id from positions where latlng = :latlng");
    }

    public function InsertPosition($latlng, $address)
    {
        $isok = false;
        try {
            $this->prp_insertPosition->bindParam(':latlng', $latlng);
            $this->prp_insertPosition->bindParam(':address', $address);
            $isok = $this->prp_insertPosition->execute();
        } catch (PDOException $e) {
            echo $e->getCode() . " \n";
            echo $e->getMessage();
            $isok = false;
        }
        return $isok;
    }

    public function GetPosition($id)
    {
        $isok = false;
        try {
            $this->prp_selectPosition->bindParam(':id', $id);
            $isok = $this->prp_selectPosition->execute();
        } catch (PDOException $e) {
            $isok = false;
        }
        return ($isok) ? $this->prp_selectPosition->fetch(PDO::FETCH_OBJ) : null;
    }

    public function GetPositionId($latlng)
    {
        $isok = false;
        try{
            $this->prp_selectPositionId->bindParam(':latlng', $latlng);
            $isok = $this->prp_selectPositionId->execute();
        }
        catch(PDOException $e)
        {
            $isok = false;
        }
        return $this->prp_selectPositionId->fetch(PDO::FETCH_OBJ);
    }
}