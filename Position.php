<?php

/**
 * Created by IntelliJ IDEA.
 * User: nanox
 * Date: 18.11.15
 * Time: 15:42
 */
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