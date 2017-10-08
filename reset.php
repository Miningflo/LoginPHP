<?php

function generateRandomString($length) {
                $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
                $charactersLength = strlen($characters);
                $randomString = '';
                for ($i = 0; $i < $length; $i++) {
                    $randomString .= $characters[rand(0, $charactersLength - 1)];
                }
                return $randomString;
}

if(isset($_POST["password"])){
    if($_POST["password"] != ""){
        $servername = "localhost";
        $username = "root";
        $password = "";
        $DBname = "logindb";
        $tablename = "users";

        $connection = new mysqli($servername,$username,$password,$DBname);
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $resetkey = $_POST["resetkey"];
        $sql = "SELECT username FROM $tablename WHERE resetkey = '$resetkey'";
        //echo $sql;
        $result = $connection->query($sql);
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){
                echo "Key owner: " . $row["username"] . "<br/>";
                $newkey = $row["username"] . generateRandomString(128);
                $sql = "UPDATE $tablename SET resetkey='$newkey', password='$password' WHERE resetkey='$resetkey'";
                echo $sql;
                if($connection->query($sql) == TRUE){
                    echo "Password updated";
                }else{
                    echo "This place is burning down!";
                }
            }
        }else{
            echo "Your probably messed with the resetcode, or you already reset your password with this code";
        }
    }else{
        echo "Passwords can't be empty";
    }
    
}else{
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Reset Password</title>
        <script>
            function pwControll()
            {
                var pw1 = document.getElementById("pw1").value;
                var pw2 = document.getElementById("pw2").value;
                

                                                            if(pw1 == pw2)
                                                                {
                                                                    document.getElementById("submit").disabled = false;
                                                                }
                                                            else
                                                                {
                                                                    document.getElementById("submit").disabled = true;
                                                                }
                                                        
            }
                
             
            function isTrue(val){
                return val == "true";
            }
            window.onload = function() {
                    if(document.body.contains(document.getElementById("submit")))
                       {
                            document.getElementById("submit").disabled = true;
                       }  
            }
        </script>
    </head>
    <body>
        <form action="reset.php" method="post">
            Password: <input type="password" name="password" oninput="pwControll()" id="pw1"><br>
            Password Confirm: <input type="password" oninput="pwControll()" id="pw2"><br>
            <input type="hidden" name="resetkey" value="<?php echo $_REQUEST["key"] ?>">
            <input type="submit" id="submit">
         </form>
    </body>
</html>
    <?php
}
?>