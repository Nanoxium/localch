<?php

/**
 * Created by IntelliJ IDEA.
 * User: nanox
 * Date: 21.12.15
 * Time: 13:37
 */
class Group
{
    private $dbc =null;
    private $prp_getGroupId = null;
    private $prp_getGroupName = null;
    public function __construct()
    {
        $this->dbc = new DatabaseConnector("localhost", "geolocation", "m151admin", "m151admin");
        $this->prp_getGroupName = $this->dbc->prepare("select name from groups where id = :id");
        $this->prp_getGroupId = $this->dbc->prepare("select id from groups where name = :name");
    }

    /**
     * * Return the name of the group
     * @param $id the group identifier
     * @return mixed|null the group name if it exists
     */
    public function getGroupName($id)
    {
        $isok = false;
        try{
            $this->prp_getGroupName->bindParam(":id", $id);

            $isok = $this->prp_getGroupName->execute();
        }
        catch(PDOException $e)
        {
            die($e->getCode(). ", " . $e->getMessage());
        }
        return ($isok) ? $this->prp_getGroupName->fetch(PDO::FETCH_OBJ) : null;
    }

    /**
     *
     * @param $groupname
     * @return mixed|null
     */
    public function getGroupId($groupname)
    {
        $isok = false;
        try {
            $this->prp_getGroupId->bindParam(':name', $groupname);
            $isok = $this->prp_getGroupId->execute();
        } catch (PDOException $e)
        {
            die($e->getCode(). ", " . $e->getMessage());
        }
        return ($isok) ? $this->prp_getGroupId->fetch(PDO::FETCH_OBJ) : null;
    }
}