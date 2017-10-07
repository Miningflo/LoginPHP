<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>login</title>
        <link rel="stylesheet" href="register.css">
        <script>
            
        function pwControll()
            {
                var pw1 = document.getElementById("pw1").value;
                var pw2 = document.getElementById("pw2").value;
                var firstname = document.getElementById("firstname").value;
                var lastname = document.getElementById("lastname").value;
                var username = document.getElementById("username").value;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function()
                                                {
                                                    if(this.readyState==4 && this.status==200)
                                                        {
                                                            var allowed = this.responseText;
                                                            if(allowed == "true" && username != ""){
                                                                document.getElementById("username").style = "box-shadow: 0 0 10px #00cc28;";
                                                            }else if(allowed == "false" && username != ""){
                                                                document.getElementById("username").style = "box-shadow: 0 0 10px #CC0000;";
                                                            }else{
                                                                document.getElementById("username").style = "";
                                                            }
                                                            if(pw1==pw2 && pw1 != "" && firstname != "" && lastname != "" && username != "" && allowed == "true")
                                                                {
                                                                    document.getElementById("submit").disabled = false;
                                                                }
                                                            else
                                                                {
                                                                    document.getElementById("submit").disabled = true;
                                                                }
                                                        }
                                                }
                
                xmlhttp.open("GET","ajaxmethod.php?type=username&value=" + username, true);
                xmlhttp.send();
            }
            
        window.onload = function()
            {
                if(document.body.contains(document.getElementById("submit")))
                   {
                        document.getElementById("submit").disabled = true;
                   }  
            }
        </script>
    </head>
    <body>
        <?php
        
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
         
        $sql = "SELECT username FROM $tablename WHERE username = '$username'";
        $result = $connection->query($sql);
            if ($result->num_rows > 0)
                {
                    echo "username already exists";
                    
                }
            else
                {
                    $sql="INSERT INTO $tablename (firstname, lastname, username, password, activated, validate) 
                    VALUES ('$firstname', '$lastname', '$username', '$password', false, '" . rand(10000,99999) . "')";
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
        
        else
        {
        ?>
        <form action="register.php" method="post">
        First Name: <input type="text" name="firstname" oninput="pwControll()" id="firstname"><br>
        Last Name: <input type="text" name="lastname" oninput="pwControll()" id="lastname"><br>
        Username: <input type="text" name="username" oninput="pwControll()" id="username"><br>
        Password: <input type="password" name="password" oninput="pwControll()"  id="pw1"><br>
        Password Confirm: <input type="password" oninput="pwControll()" id="pw2"><br>
        <input type="submit" id="submit">
        </form>
        <?php } ?>
    </body>
</html>