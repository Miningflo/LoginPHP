<?php
session_start();
if(isset($_SESSION["username"]))
    {
        echo "hallo " . $_SESSION["username"];
        ?>
        <a href="logout.php">logout</a>
        <?php
    }
else
    {
        header("Location: login.php");
    }





?>