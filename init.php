<?php

$servername = "localhost";
$username = "root";
$password = "";
$DBname = "basedata";
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
time TIMESTAMP
)";
$connection->query($sql);

$connection->close();
?>