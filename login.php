<?php
session_start();
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
        <?php include 'header.php'; ?>
        <h1>Connexion</h1>
        <form action="login.php" method="POST">
            <table>
                <tr>
                    <td><p>Login : </p></td>
                    <td><input type="text" name="login" required="" maxlength="20"/></td>
                </tr>
                <tr>
                    <td><p>Password : </p></td>
                    <td><input type="password" name="password" required="" maxlength="20"/></td>
                </tr>
                <tr>
                    <td><input type="submit" name="connexion" value="Connexion"/></td>
                </tr>
            </table>
        </form>
    </body>
</html>

