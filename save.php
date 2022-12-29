<?php 
session_start();
	include("connection.php");
	include("functions.php");
	$user_data = check_login($con);
    
    
    if(isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] == "POST"){
        $sql = 'UPDATE card_product
        SET quantity = '.$_POST['quantity_add'].'
        WHERE (customer_id='.$_SESSION['customer_id'].' and product_id='.$_GET['id'].')';
        mysqli_query($con, $sql);
        echo(''.$_POST['quantity_add'].'');
		header("Location: card.php");
		die;
    }
    else{
        header("Location: card.php");
		die;
    }
?>