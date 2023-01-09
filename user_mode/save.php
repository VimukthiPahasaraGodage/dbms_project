<?php 
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/connection/connection.php");
include($_SERVER['DOCUMENT_ROOT'] . "/connection/functions.php");
if (isset($con)) {
    $user_data = check_login($con);
}
    
    
    if(isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] == "POST"){
        $sql = 'UPDATE cart_product
        SET quantity = '.$_POST['quantity_add'].'
        WHERE (customer_id='.$_SESSION['customer_id'].' and product_id='.$_GET['id'].')';
        mysqli_query($con, $sql);
        echo(''.$_POST['quantity_add'].'');
		header("Location: cart.php");
		die;
    }
    else{
        header("Location: cart.php");
		die;
    }
?>