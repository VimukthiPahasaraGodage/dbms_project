<?php 
session_start();

	include("connection.php");
	include("functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
        $email = $_POST['email'];
		$password = $_POST['password'];
        $customer_name = $_POST['customer_name'];
        $address = $_POST['address'];
        $phone_number = $_POST['phone_number'];

		if(!empty($customer_name) && !empty($password))
		{

			//save to database

			$query = "insert into customer (email,password,customer_name,address,phone_number) values ('$email','$password','$customer_name','$address','$phone_number')";
            
			mysqli_query($con, $query);
			header("Location: login.php");
			die;
		}else
		{
			echo "Please enter some valid information!";
		}
	}


?>

