<?php

$dbhost = "localhost";
$dbuser = "root";
$dbpass = "";
$dbname = "demo1";

if(!$con = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
{
	die("failed to connect!");
}

/*
$qu="select schema_name from information_schema.schemata where schema_name = 'SupplyChain'";
$qu=$con->query($qu);
if($qu->num_rows==0){
    die();
}*/
?>