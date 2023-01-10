<?php 
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/connection/connection.php");
include($_SERVER['DOCUMENT_ROOT'] . "/connection/functions.php");
if (isset($con)) {
    $user_data = check_login($con);
}
    
    
    if(isset($_GET['id'])){
        $sql = 'delete from cart_product where (customer_id='.$_SESSION['customer_id'].' and product_id='.$_GET['id'].' )';
        mysqli_query($con, $sql);
		header("Location: cart.php");
		die;
    }
    else{
        header("Location: cart.php");
		die;
    }
?>