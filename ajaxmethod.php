<?php
$servername = "localhost";
$username = "root";
$password = "";
$DBname = "logindb";
$tablename = "users";
        
$connection = new mysqli($servername,$username,$password,$DBname);
$username = $_REQUEST["username"];
$email = $_REQUEST["email"];

$sql = "SELECT username FROM $tablename WHERE username = '$username'";

$result = $connection->query($sql);

if ($result->num_rows > 0)
{
    echo "false ";
}
else
{
    echo "true ";
}

$sql = "SELECT email FROM $tablename WHERE email = '$email'";

$result = $connection->query($sql);

if ($result->num_rows > 0)
{
    echo "false";
}
else
{
    echo "true";
}
?>