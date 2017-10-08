<?php
if(isset($_POST["username"])){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $DBname = "logindb";
    $tablename = "users";

    $connection = new mysqli($servername,$username,$password,$DBname);
    $username = $_POST["username"];
    $sql = "SELECT email, resetkey FROM $tablename WHERE username = '$username' OR email = '$username'";
    //echo $sql;
    $result = $connection->query($sql);
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            echo "Send mail to: " . $row["email"] . "<br/>";
            echo "http://localhost/Database2/reset.php?key=" . $row["resetkey"];
        }
    }else{
        echo "I don't even understand all these errors anymore...";
    }
}else{
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Forgot Password</title>
        <script>
            function pwControll()
            {
                var username = document.getElementById("username").value;
                var xmlhttp = new XMLHttpRequest();
                xmlhttp.onreadystatechange = function()
                                                {
                                                    if(this.readyState==4 && this.status==200)
                                                        {
                                                            var allowed = this.responseText.split(" ").every(isTrue);
                                                            if(allowed == false && username != ""){
                                                                document.getElementById("username").style = "box-shadow: 0 0 10px #00cc28;";
                                                            }else if(allowed && username != ""){
                                                                document.getElementById("username").style = "box-shadow: 0 0 10px #CC0000;";
                                                            }else{
                                                                document.getElementById("username").style = "";
                                                            }
                                                            if(username != "" && allowed == false)
                                                                {
                                                                    document.getElementById("submit").disabled = false;
                                                                }
                                                            else
                                                                {
                                                                    document.getElementById("submit").disabled = true;
                                                                }
                                                        }
                                                }
                
                xmlhttp.open("GET","./ajaxmethod.php?username=" + username + "&email=" + username, true);
                xmlhttp.send();
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
        <form action="forgot.php" method="post">
            Username / Email: <input type="text" name="username" oninput="pwControll()" id="username"><br>
            <input type="submit" id="submit">
         </form>
    </body>
</html>
    <?php
}
?>