<?php
/**
 * Created by IntelliJ IDEA.
 * User: nanox
 * Date: 25.12.15
 * Time: 16:34
 */
require_once 'user.php';

$u = new User();
echo json_encode($u->selectAllUsers());