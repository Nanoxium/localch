<!------------------
Auteurs : Jérôme Chételat / Philippe Ku
Ecole/Classe : CFPT Informatique
Date : 02.12.15
Programme : Local.ch
Fichier : index.php
Version : 1.0
------------------->
<?php
session_start();

if(isset($_SESSION['logout']))
    session_destroy();

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Local.ch</title>
        <link rel="stylesheet" href="./css/geolocalisation.css" />
        <script type="text/javascript" src="js/jquery-2.1.4.min.js" ></script>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
        <script type="text/javascript" src="js/script.js" ></script>
    </head>
    <body onload="initMap()">
        <div id="content">

        </div>
    </body>
</html>