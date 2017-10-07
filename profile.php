<?php
session_start();
if(isset($_SESSION["username"])){
        echo "hallo " . $_SESSION["username"];
        ?>
        <a href="logout.php">logout</a>
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $DBname = "logindb";
        $tablename = "users";
        
        $connection = new mysqli($servername,$username,$password,$DBname);
        $username = $_SESSION["username"];
        $sql = "SELECT activated FROM $tablename WHERE username = '$username'";
        $result = $connection->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                if($row["activated"] == false){
                    if(isset($_POST["vc"])){
                        $sql = "SELECT validate FROM $tablename WHERE username = '$username'";
                        //echo $sql;
                        $result2 = $connection->query($sql);
                        if($result2->num_rows > 0) {
                            while($row = $result2->fetch_assoc()){
                                if($_POST["vc"] == $row["validate"]){
                                    $sql = "UPDATE $tablename SET activated=true WHERE username = '$username'";
                                    $connection->query($sql);
                                    header("Location: profile.php");
                                }else{
                                    echo "The validation code you provided is invalid";
                                }
                            }
                        }else{
                            echo "You fucked up again didn't you?";
                        }
                    }else{
                        echo "Please activate your account<br/>";
                        ?>
                        <form action="profile.php" method="post">
                            Verificationcode: <input type="text" name="vc">
                        </form>
                        <?php
                    }
                    
                }else{
                    echo "Very welcome";
                }
            }
        }else{
            echo "You broke it, are you happy now? :/";
        }
    }else{
        header("Location: login.php");
    }





?>