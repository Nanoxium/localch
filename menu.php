<?php
/**
 * Created by IntelliJ IDEA.
 * User: nanox
 * Date: 08.12.15
 * Time: 22:01
 */
?>
<nav>
    <ul>
        <li><a href="#?home">Acceuil</a></li>
        <li><a href="#?register">S'enregistrer</a></li>
        <li></li>
        <?php if(isset($_SESSION['admin'])){?><li><a href="#?administration"></a></li><?php } ?>
    </ul>
</nav>
