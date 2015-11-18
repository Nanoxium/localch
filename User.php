<?php

/**
 * Created by IntelliJ IDEA.
 * User: nanox
 * Date: 18.11.15
 * Time: 15:50
 */
class User
{
    public $firstname = null;
    public $lastname = null;
    public $email = null;

    private $dbc = null;
    private $prp_selectUser = null;

    public function __construct()
    {
    }

    public function selectUser($email)
    {
        throw new Exception("Not implemented");
    }
}