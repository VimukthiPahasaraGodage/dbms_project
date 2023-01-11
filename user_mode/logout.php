<?php

session_start();

if(isset($_SESSION['email']))
{
	unset($_SESSION['email']);
}

header("Location: ../guest_mode/login.php");
die;

?>