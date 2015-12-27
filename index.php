<?php
/********************
 * Auteurs : Jérôme Chételat / Philippe Ku
 * Ecole/Classe : CFPT Informatique
 * Date : 02.12.15
 * Programme : Local.ch
 * Fichier : index.php
 * Version : 1.0
 *******************/
session_start();

if(isset($_REQUEST['logout']))
{
    session_destroy();
    session_start();
}
?>
<!DOCTYPE html>

<html>
<head>
    <title>Local.ch - Acceuil</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/localchstyle.css"/>
    <script type="text/javascript" src="./js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script type="text/javascript" src="./js/localch-script.js"></script>
</head>

<body">
<div id="content">
    <div class="center">
        <?php include 'header.php'; ?>
        <?= /*Affiche un message si l'utilisteur s'est bien enregistré*/ (isset($_REQUEST['registered'])) ? '<h1>Vous êtes bien enregistré</h1>' : ""  ?>
        <?php if(!isset($_SESSION['username'])) { ?>
            <h1>Bienvenue sur notre site!</h1>
            <h2>Pour profiter des fonctionalités, veuillez vous enregistrer ou vous connecter!</h2>
            <?php
        }else { ?>
            <h1>Bonjour <?= $_SESSION['username'] ?></h1>
            <h2>Position des utilisateurs du site</h2>
            <div id="mapIndex">

            </div>
            <script type="text/javascript">
                initializeMap("mapIndex");
                displayAllUsers();
            </script>
        <?php } ?>
    </div>
</div>
</body>
</html>

