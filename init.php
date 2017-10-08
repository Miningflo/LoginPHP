<?php

$servername = "localhost";
$username = "root";
$password = "";
$DBname = "logindb";
$tablename = "users";

$connection = new mysqli($servername,$username,$password);
$sql = "CREATE DATABASE $DBname";
$connection->query($sql);
$connection = new mysqli($servername,$username,$password,$DBname);

$sql = "CREATE TABLE $tablename (
id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
firstname VARCHAR(30) NOT NULL,
lastname VARCHAR(30) NOT NULL,
username VARCHAR(30) NOT NULL,
password VARCHAR(60) NOT NULL,
activated BOOL NOT NULL,
validate INT(5) NOT NULL,
resetkey VARCHAR(128) NOT NULL,
email VARCHAR(254) NOT NULL,
time TIMESTAMP
)";
//$connection->query($sql);

if ($connection->query($sql) === TRUE) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . $connection->error;
}

$connection->close();
?>