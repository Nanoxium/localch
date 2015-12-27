<?php
/********************
 * Auteurs : Jérôme Chételat / Philippe Ku
 * Ecole/Classe : CFPT Informatique
 * Date : 02.12.15
 * Programme : Local.ch
 * Fichier : login.php
 * Version : 1.0
 *******************/
session_start();
require_once './user.php';

$e_login = false;
if(isset($_REQUEST['connexion']))
{
    $u = new User();
    if($u->CheckLogin($_REQUEST['username'], $_REQUEST['password']))
    {
        $u->selectUser($_REQUEST['username']);
        $_SESSION['username'] = $u->username;
        header("Location: index.php");
    }
    else
    {
        $e_login = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Local.ch - Login</title>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/localchstyle.css"/>
    <script src="./localch-script.js"></script>
</head>

<body>
<div id="content">
    <div class="center">
        <?php include 'header.php'; ?>
        <h1>Connexion</h1>
        <?= ($e_login) ? '<article class="error">Le mot de passe ou le nom d\'utilisateur est érroné !</article>' : '' ?>
        <form action="#" method="POST">
            <table>
                <tr>
                    <td><p>Nom d'utilisateur : </p></td>
                    <td><input type="text" name="username" required="" maxlength="20"/></td>
                </tr>
                <tr>
                    <td><p>Mot de passe : </p></td>
                    <td><input type="password" name="password" required="" maxlength="20"/></td>
                </tr>
                <tr>
                    <td><input type="submit" name="connexion" value="Connexion"/></td>
                </tr>
            </table>
        </form>
    </div>
</div>
</body>
</html>

