<?php
$servername = "localhost";
$username = "root";
$password = "";
$DBname = "logindb";
$tablename = "users";
        
$connection = new mysqli($servername,$username,$password,$DBname);
$type = $_REQUEST["type"];
$value = $_REQUEST["value"];

$sql = "SELECT $type FROM $tablename WHERE $type = '$value'";

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