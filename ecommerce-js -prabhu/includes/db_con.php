<?php

$host="localhost";
$username="root";
$pass="";
$db_name="mysql_learn";

$con= new mysqli($host, $username, $pass, $db_name);

if($con->connect_error){
    echo $con->connect_error;
    exit;
}

