<?php

$host="localhost";
$user="root";
$password="";
$db_nome="newsletter";

$connection=new mysqli($host,$user,$password,$db_nome);

$mail=$_POST['mail'];
$nome=$_POST['nome'];

$sql= "INSERT INTO $users VALUES('$mail', '$nome');";

$connection->close();

?>