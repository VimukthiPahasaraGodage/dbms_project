<?php 
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/connection/connection.php");
include($_SERVER['DOCUMENT_ROOT'] . "/connection/functions.php");
if (isset($con)) {
    $user_data = check_login($con);
}




if(isset($_POST['expectDate'])){
    $expectDate=$_POST['expectDate'];
}
else{
    header("location: cart.php");
    die;
}


$sql = 'select * from cart_product where customer_id='.$_SESSION['customer_id'].'';
$ress = $con->query($sql);
$retry = False;
$total_amount = 0;

if($ress->num_rows>0){
    while ($row = $ress->fetch_assoc()) {
        $qua = $row['quantity'];
        $pro = 'select * from product where product_id='.$row['product_id'].'';
        $pro = $con->query($pro);
        $pro = $pro->fetch_assoc();
        if ($qua > 0 && $qua<=$pro['quantity']) {
            $total_amount=$total_amount+$pro['price']*$row['quantity'];
        }
        else{
            if($qua!=0){
                $retry=True;
            }

        }
    }

    if($retry || $total_amount==0){
        header("location: cart.php");
        die;
    }
}


$customer_id = $_SESSION['customer_id'];

$pay = "Waiting";
$sta = "To Ship";
$addes=$_SESSION['address'];

echo ("$customer_id,$addes,{$_POST['nearStore']},{$_POST['route']},$expectDate");



try {
    $con->begin_transaction();
    $queryy ="INSERT INTO `order`(`order_customer_id`, `expected_Delivery_Date`, `delivery_address`, `store_id`, `route_id`) 
VALUES ('$customer_id','$expectDate','$addes','{$_POST['nearStore']}','{$_POST['route']}')";



    if (mysqli_query($con, $queryy)) {
        $last_id = mysqli_insert_id($con);
    }

//----------------------------------------//
    $total_amount = 0;
    $retry = False;
    $ress = $con->query($sql);

    if ($ress->num_rows > 0) {
        while ($row = $ress->fetch_assoc()) {
            $pro_id = $row['product_id'];
            $qua = $row['quantity'];
            $pro = 'select * from product where product_id=' . $row['product_id'] . '';
            $pro = $con->query($pro);
            $pro = $pro->fetch_assoc();
            if ($qua > 0 && $qua <= $pro['quantity']) {
                $pro_qua = $pro['quantity'];
                $val = $pro_qua - $qua;
                $upda = "UPDATE `product` SET `quantity`='$val' WHERE product_id='$pro_id'";
                mysqli_query($con, $upda);
                $p = "INSERT INTO `order_includes`(`order_id`, `product_id`, `quantity`) VALUES ('$last_id','$pro_id','$qua')";
                mysqli_query($con, $p);
                //mention discount
                $total_amount = $total_amount + $pro['price'] * $row['quantity'];
                  $del= "DELETE FROM `cart_product` WHERE (product_id='$pro_id' and customer_id={$_SESSION['customer_id']}) ";
                 mysqli_query($con, $del);
            } else {
                if ($qua != 0) {
                    $retry = True;
                    break;
                }

            }
        }

        if ($retry || $total_amount == 0) {
            header("location: cart.php");
            die;
        }

        $sql = "UPDATE `order` SET `total_amount`='$total_amount' WHERE order_id='$last_id'";
        mysqli_query($con, $sql);


    }

   $con->commit();
}catch (Exception $e) {
// An exception has been thrown
// We must rollback the transaction
    $con->rollback();
}

 header("location: orderPlaced.php");
die;
//----------------------------------------//
?>