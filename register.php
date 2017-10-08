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
        
        if(isset($_POST["password"]))
        {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $DBname = "logindb";
        $tablename = "users";
        
        $connection = new mysqli($servername,$username,$password,$DBname);

        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $username = $_POST["username"];
        $password = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $email = $_POST["email"];
         
        $sql = "SELECT username FROM $tablename WHERE username = '$username'";
        $result = $connection->query($sql);
            if ($result->num_rows > 0){
                    echo "username already exists";
                    
            }else{  
                $sql = "SELECT username FROM $tablename WHERE email = '$email'";
                $result = $connection->query($sql);
                if($result->num_rows > 0){
                    echo "email already exists";
                }else{
                    $rand = rand(10000,99999);
                    $resetkey = $username . generateRandomString(128);
                    $sql="INSERT INTO $tablename (firstname, lastname, username, password, activated, validate, resetkey, email) 
                    VALUES ('$firstname', '$lastname', '$username', '$password', false, '" . $rand . "', '$resetkey', '$email')";
                    echo $sql . "<br/>";

                     if ($connection->query($sql) === TRUE) {
                        echo "New record created successfully";
                        session_start();
                        $_SESSION["username"] = $username;
                        header("Location: profile.php");
                    } 
                    else {
                        echo "Error: " . $sql . "<br>" . $connection->error;
                    }
                    echo "<br/>" . $sql;
                }
            }   
        }
        
        else
        {
        ?>
<!DOCTYPE html>
<html> 
    <head>
        <title>Register</title>
        <link rel="stylesheet" href="register.css">
        <script>
            
        function pwControll()
            {
                var pw1 = document.getElementById("pw1").value;
                var pw2 = document.getElementById("pw2").value;
                var firstname = document.getElementById("firstname").value;
                var lastname = document.getElementById("lastname").value;
                var email = document.getElementById("email").value;
                var username = document.getElementById("username").value;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function()
                                                {
                                                    if(this.readyState==4 && this.status==200)
                                                        {
                                                            var allowed = this.responseText.split(" ");
                                                            console.log(allowed);
                                                            //console.log("./ajaxmethod.php?username=" + username + "&email= " + email);
                                                            if(allowed[0] == "true" && username != ""){
                                                                document.getElementById("username").style = "box-shadow: 0 0 10px #00cc28;";
                                                            }else if(allowed[0] == "false" && username != ""){
                                                                document.getElementById("username").style = "box-shadow: 0 0 10px #CC0000;";
                                                            }else{
                                                                document.getElementById("username").style = "";
                                                            }
                                                            
                                                            if(allowed[1] == "true" && email != ""){
                                                                document.getElementById("email").style = "box-shadow: 0 0 10px #00cc28;";
                                                            }else if(allowed[1] == "false" && email != ""){
                                                                document.getElementById("email").style = "box-shadow: 0 0 10px #CC0000;";
                                                            }else{
                                                                document.getElementById("email").style = "";
                                                            }
                                                            
                                                            if(pw1==pw2 && pw1 != "" && firstname != "" && lastname != "" && username != "" && allowed.every(isTrue) && email != "")
                                                                {
                                                                    document.getElementById("submit").disabled = false;
                                                                }
                                                            else
                                                                {
                                                                    document.getElementById("submit").disabled = true;
                                                                }
                                                        }
                                                }
                
                xmlhttp.open("GET","./ajaxmethod.php?username=" + username + "&email=" + email, true);
                xmlhttp.send();
            }
            
        window.onload = function() {
                if(document.body.contains(document.getElementById("submit")))
                   {
                        document.getElementById("submit").disabled = true;
                   }  
        }
        function isTrue(val){
            return val == "true";
        }
        </script>
    </head>
    <body>
        <form action="register.php" method="post">
        First Name: <input type="text" name="firstname" oninput="pwControll()" id="firstname"><br>
        Last Name: <input type="text" name="lastname" oninput="pwControll()" id="lastname"><br>
        E-Mail: <input type="email" name="email" oninput="pwControll()" id="email"><br>
        Username: <input type="text" name="username" oninput="pwControll()" id="username"><br>
        Password: <input type="password" name="password" oninput="pwControll()"  id="pw1"><br>
        Password Confirm: <input type="password" oninput="pwControll()" id="pw2"><br>
        <input type="submit" id="submit">
        </form>
    </body>
</html>
        <?php } ?>

