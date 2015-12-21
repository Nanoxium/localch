<?php
session_start();
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
    <body onload="initializeMap()">
        <?php include 'header.php'; ?>
        <div id="content">
        <h1>Enregistrement</h1>
        <form action="#" method="POST">
            <table>
                <tr>
                    <td><p>Nom : </p></td>
                    <td><input type="text" name="nom" required="" maxlength="20"/></td>
                </tr>
                <tr>
                    <td><p>Prénom : </p></td>
                    <td><input type="text" name="prenom" required="" maxlength="20"/></td>
                </tr>
                <tr>
                    <td><p>Pseudo : </p></td>
                    <td><input type="text" name="pseudo" required="" maxlength="20"/></td>
                </tr>
                <tr>
                    <td><p>Password : </p></td>
                    <td><input type="password" name="pass" required="" maxlength="20"/></td>
                </tr>
                <tr>
                    <td><p>Confirmer Password : </p></td>
                    <td><input type="password" name="confirmerpass" required="" maxlength="20"/></td>
                </tr>
                <tr>
                    <td><p>Adresse : </p></td>
                    <td>
                        <input type="text" id="adress" name="adresse" required="" maxlength="50"/>
                        <input type="button" name="search" onclick="geocodeAddress($('#adress').val());" value="Recherche l'address" />
                        <input type="hidden" id="location" name="location" value=""/>
                    </td>
                </tr>
                <tr>
                    <td><input type="submit" name="valider" value="Créer"/></td>
                </tr>
            </table>
            <!-- where the map goes -->
            <div id="mapDiv"></div>
        </form>
        </div>
    </body>
</html>

