<?php 
session_start();
	include("connection.php");
	include("functions.php");
	$user_data = check_login($con);




$customer_id = $_SESSION['customer_id'];
$h1 = "Cash On Delivery";
$h2 = "WAITNG FOR PAYMENT";
$h3 = "Processing";
$queryy = "INSERT INTO `order`(`order_customer_id`, `payment_method`, `payment_status`,`status`) 
  VALUES ('$customer_id','$h1','$h2','$h3')";
if(mysqli_query($con, $queryy)){
  $last_id = mysqli_insert_id($con);

}

//----------------------------------------//
$sql = 'select * from card_product where customer_id='.$_SESSION['customer_id'].'';
$ress = $con->query($sql);
$total_amount = 0;
$retry = False;

if($ress->num_rows>0){
  while ($row = $ress->fetch_assoc()) {
    $pro_id = $row['product_id'];
    $qua = $row['quantity'];
    $pro = 'select * from product where product_id='.$row['product_id'].'';
    $pro = $con->query($pro);
    $pro = $pro->fetch_assoc();
    if ($qua > 0 && $qua<=$pro['quantity']) {
        $pro_qua=$pro['quantity'];
        $val=$pro_qua-$qua;
      $upda= "UPDATE `product` SET `quantity`='$val' WHERE product_id='$pro_id'";
      mysqli_query($con,$upda);
      $p = "INSERT INTO `includes`(`order_id`, `product_id`, `quantity`) VALUES ('$last_id','$pro_id','$qua')";
      mysqli_query($con, $p);
      //mention discount
      $total_amount=$total_amount+$pro['price']*$row['quantity'];
    }
    else{
        if($qua!=0){
         $retry=True;
         break;   
        }
        
    }
  }

if($retry){
    header("location: card.php");
    die; 
}  
  $sql = "UPDATE `order` SET `total_amount`='$total_amount' WHERE order_id='$last_id'";
  mysqli_query($con, $sql);

  header("location: orderPlaced.php");
    die;
}

//----------------------------------------//



?>