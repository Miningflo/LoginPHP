<!DOCTYPE html>
<html>
    
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>login</title>
        <link rel="stylesheet" href="login.css">
        <script>
            function pwControll()
            {
                var pw1 = document.getElementById("pw1").value;
                var username = document.getElementById("username").value;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function()
                                                {
                                                    if(this.readyState==4 && this.status==200)
                                                        {
                                                            var allowed = this.responseText;
                                                            console.log(this.responseText); 
                                                            console.log(pw1); 
                                                            if(pw1 != "" && username != "" && allowed == "false")
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
        $DBname = "basedata";
        $tablename = "users";
        
        $connection = new mysqli($servername,$username,$password,$DBname);
        
        $username = $_POST["username"];
        $password = $_POST["password"];
            
            $sql="SELECT password FROM $tablename WHERE username = '$username'";
            $result = $connection->query($sql);
            if ($result->num_rows > 0)
                {
                    while ($row = $result->fetch_assoc())
                    {
                    if(password_verify($password, $row["password"]))
                        {
                            echo "login succesvol";
                            session_start();
                            $_SESSION["username"] = $username;
                            header("Location: profile.php");
                        }
                    else
                        {
                            echo "wrong password !!!!";
                        }
                    }
                }
            else
                {
                    echo "this username doesn't exist";
                }
        }
        else
        {
        ?>
        <form action="login.php" method="post">
        Username: <input type="text" name="username" oninput="pwControll()" id="username"><br>
        Password: <input type="password" name="password" oninput="pwControll()" id="pw1"><br>
        <input type="submit" id="submit">
        </form>
        <?php } ?>
    </body>
</html>