<?php
$servername="localhost";
$username="root";
$password="";
$dbname="todolist_db";

$conn=new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die("Conexiunea a eșuat: ".$conn->connect_error);
}
?>
