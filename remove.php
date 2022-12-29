<?php 
session_start();
	include("connection.php");
	include("functions.php");
	$user_data = check_login($con);
    
    
    if(isset($_GET['id'])){
        $sql = 'delete from card_product where (customer_id='.$_SESSION['customer_id'].' and product_id='.$_GET['id'].' )';
        mysqli_query($con, $sql);
		header("Location: card.php");
		die;
    }
    else{
        header("Location: card.php");
		die;
    }
?>