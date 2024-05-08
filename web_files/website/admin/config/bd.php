<?php
$server="localhost";
$Database="smart-access";
$user="root";
$password="";

try {
    $conn=new PDO("mysql:host=$server;dbname=$Database",$user,$password);
    //echo "successful connection";
} catch (Exception $error) {
    echo $error->getMessage();
}

?>