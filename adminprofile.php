<?php
session_start();
if(isset($_SESSION["username"]) && $_SESSION["username"] == "Admin")
    {
        echo "welkom administrator"
        ?>
        <a href="logout.php">logout</a>
        <?php
    }
else
    {
        header("Location: login.php");
    }





?>