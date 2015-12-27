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

        $this->dbc = new DatabaseConnector();
        $this->prp_insertPosition = $this->dbc->prepare("insert into " . $this->dbc->getDbName() . ".positions (latlng, address) values (:latlng, :address)");

        //Prepare statement
        $this->prp_selectPosition = $this->dbc->prepare("select latlng from positions where id = :id");
        $this->prp_selectPositionId = $this->dbc->prepare("select id from positions where address = :address");
    }

    /**
     * Insère une position
     * @param $latlng objet latitude longitude sous le format : (lat, long)
     * @param $address l'adress liée à la position
     * @return bool insertion bien éffectuée
     */
    public function InsertPosition($latlng, $address)
    {
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

    /**
     * Retourne la position selon un identifiant
     * @param $id identifiant de la position
     * @param int $format PDO::FETCH_
     * @return mixed|null la position ou rien
     */
    public function GetPosition($id, $format = PDO::FETCH_OBJ)
    {
        try {
            $this->prp_selectPosition->bindParam(':id', $id);
            $isok = $this->prp_selectPosition->execute();
        } catch (PDOException $e) {
            $isok = false;
        }
        return ($isok) ? $this->prp_selectPosition->fetch($format) : null;
    }

    /**
     * Retourne la position selon une adresse
     * @param $address l'adresse
     * @return mixed|null
     */
    public function GetPositionId($address)
    {
        try{
            $this->prp_selectPositionId->bindParam(':address', $address);
            $isok = $this->prp_selectPositionId->execute();
        }
        catch(PDOException $e)
        {
            $isok = false;
        }
        return ($isok) ? $this->prp_selectPositionId->fetch(PDO::FETCH_OBJ) : null;
    }
}