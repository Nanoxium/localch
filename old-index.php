<!------------------
Auteurs : Jérôme Chételat / Philippe Ku
Ecole/Classe : CFPT Informatique
Date : 02.12.15
Programme : Local.ch
Fichier : index.php
Version : 1.0
------------------->
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Local.ch</title>
        <link rel="stylesheet" href="./css/geolocalisation.css" />
        <script type="text/javascript" src="js/jquery-2.1.4.min.js" ></script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="js/localch-script.js" ></script>
    </head>
    <body onload="initMap()">
        <div id="content">
            <table>
                <tr>
                    <td>Latitude : </td><td id="lat"></td>
                </tr>
                <tr>
                    <td>Longitude : </td><td id="long"></td>
                </tr>
                <tr>
                    <td>Précision : </td><td id="prec"></td>
                </tr>
                <tr>
                    <td>Altitude : </td><td id="alt"></td>
                </tr>
                <tr>
                    <td>Précision altitude : </td><td id="precalt"></td>
                </tr>
                <tr>
                    <td>Angle par rapport au nord : </td><td id="angle"></td>
                </tr>
                <tr>
                    <td>Vitesse de déplacement : </td><td id="speed"></td>
                </tr>
                <tr>
                    <td>Temps : </td><td id="time"></td>
                </tr>
            </table><br/>
            <button id="start" onclick="startWatch()">Commencer la géolocalisation</button>
            <button id="stop" onclick="stopWatch()" disabled="">Arrêter la géolocalisation</button><br/>
            <div id="mapDiv">
                <!--Div ou est affichée la carte-->
            </div>
        </div>
    </body>
</html>
