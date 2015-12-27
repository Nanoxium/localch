<?php
/********************
 * Auteurs : Jérôme Chételat / Philippe Ku
 * Ecole/Classe : CFPT Informatique
 * Date : 02.12.15
 * Programme : Local.ch
 * Fichier : signup.php
 * Version : 1.0
 *******************/
session_start();
require_once 'user.php';

$e_passwd = false;
$e_insert = false;

if(isset($_REQUEST['valider']))
{
    if($_REQUEST['password'] == $_REQUEST['confirmpass'])
    {
        foreach($_REQUEST as $key => $value)
        {
            $infos[$key] = filter_var($value, FILTER_SANITIZE_SPECIAL_CHARS);
        }

        $u = new User();
        $isRegistered = $u->InsertUserIntoDataBase($infos['firstname'], $infos['lastname'], $infos['username'], $infos['email'], $infos['password'], $infos['location'], $infos['address']);
        if($isRegistered)
            header("Location: index.php?registered");
        else
            $e_passwd = true;
    }
    else
        $e_insert = true;
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Local.ch - Sign In</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/localchstyle.css"/>
    <script type="text/javascript" src="./js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="./js/localch-script.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
</head>

<body onload="initializeMap('mapDiv')">
<div id="content">
    <div class="center">
        <?php include 'header.php'; ?>
        <h1>Enregistrement</h1>
        <?= ($e_passwd) ? '<p class="error">Erreur lors de la création de l\'utilisateur, le nom d\'utilisateur est déjà pris. </p>' : ""; ?>
        <?= ($e_insert) ? '<p class="error">Les mots de passe ne correspondent pas</p>' : ""; ?>
        <form name="register" action="#" method="post">
            <table>
                <tr>
                    <td><p>Nom : </p></td>
                    <td><input type="text" name="lastname" value="<?= (isset($_REQUEST['lastname'])) ? $_REQUEST['lastname'] : ""; ?>" required="" maxlength="20"/></td>
                </tr>
                <tr>
                    <td><p>Prénom : </p></td>
                    <td><input type="text" name="firstname" value="<?= (isset($_REQUEST['firstname'])) ? $_REQUEST['firstname'] : ""; ?>" required="" maxlength="20"/></td>
                </tr>
                <tr>
                    <td><p>Nom d'utilisateur : </p></td>
                    <td><input type="text" name="username" value="<?= (isset($_REQUEST['username'])) ? $_REQUEST['username'] : "" ;?>" required="" maxlength="20"/></td>
                </tr>
                <tr>
                    <td><p>Email : </p></td>
                    <td><input type="email" name="email" value="<?= (isset($_REQUEST['email'])) ? $_REQUEST['email'] : "" ;?>" required="" maxlength="60"/></td>
                </tr>
                <tr>
                    <td><p>Mot de passe : </p></td>
                    <td><input type="password" name="password" required="" maxlength="20"/></td>
                </tr>
                <tr>
                    <td><p>Confirmer le mot de passe : </p></td>
                    <td><input type="password" name="confirmpass" required="" maxlength="20"/></td>
                </tr>
                <tr>
                    <td><p>Adresse : </p></td>
                    <td>
                        <p id="errors" class="error"></p>
                        <input type="text" id="address" name="address" required="" value="<?= (isset($_REQUEST['address'])) ? $_REQUEST['address'] : "" ;?>" maxlength="100"/><br/>
                        <input type="button" name="search" onclick="geocodeAddress($('#address').val());"
                               value="Recherche l'address"/>
                        <input type="hidden" id="location" name="location" value=""/>
                    </td>
                </tr>
                <tr>
                    <td><input id="send" type="submit" name="valider" value="S'inscrire" disabled="true"/></td>
                    <td>
                    </td>
                </tr>
            </table>
            <!-- where the map goes -->
        </form>
        <div id="mapDiv"></div>
    </div>
</div>
</body>

</html>

