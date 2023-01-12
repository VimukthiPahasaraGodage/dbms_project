<?php
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/dbms_project/connection/connection.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbms_project/connection/functions.php");
if(isset($con)){
    check_login($con);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>dashboard</title>
    <meta charset="UTF-8" >
    <meta name="keywords" content="HTML, Css, JS, For Search Engines" >
    <meta name="description" content="Supply-Chain">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        @media (max-width:460px){
            .footer{
                font-size: 12px;
            }
        }
        .footer p{
            text-align: center;
            padding-bottom: 0;
        }
        .footer{
            background: linear-gradient(rgb(0,0,0,0.6),rgb(0,0,0,0.6));
            width: 100%;
            position: fixed;
            bottom: 0;
            font-size: 14px;
            left: 0;
            color: #fff;
            padding: 2px;
            margin-bottom: 0;
            padding-bottom: 0;
            font-weight: bold;
        }
        body{
            background: linear-gradient(rgba(115, 74, 2, 0.8),rgba(153, 98, 3, 0.8)), url(../guest_mode/style/background/back.jpg);
            background-attachment: fixed;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            width: 100%;
            height: 100vh;
            overflow-x: hidden;
        }

         #change:hover{
             color: #5c5252;
             cursor: pointer;
         }
         #change{
             color: black;
         }
    </style>
</head>
<body>

<script>
    function myFunction1() {
        var ts = document.getElementById("ToShip");
        ts.style.display = "block";
        var tr = document.getElementById("ToReceive");
        tr.style.display = "None";
        var va = document.getElementById("ViewAll");
        va.style.display = "None";
    }

    function myFunction2() {
        var tr = document.getElementById("ToReceive");
        tr.style.display = "block";
        var ts = document.getElementById("ToShip");
        ts.style.display = "None";
        var va = document.getElementById("ViewAll");
        va.style.display = "None";
    }


    function myFunction3() {
        var va = document.getElementById("ViewAll");
        va.style.display = "block";
        var tr = document.getElementById("ToReceive");
        tr.style.display = "None";
        var ts = document.getElementById("ToShip");
        ts.style.display = "None";

    }
</script>




<nav class="navbar navbar-inverse fixed-top" style="font-size: large; background-color: rgba(115, 74, 2, 0.8); border: 0ch;"  >
    <div class="container-fluid" style="padding-left: 10px;padding-right: 10px;" >
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">CompanyName</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar" style="text-align: center;" >
            <ul class="nav navbar-nav">
                <li><a href="index.php">HOME</a></li>
                <li><a href="../guest_mode/about.php">ABOUT</a></li>
                <li><a href="./cart.php">CART</a></li>
                <li><a href="./myOrders.php">MY ORDERS</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                echo('<li><a href="#"><span class="glyphicon glyphicon-user"></span> '.$_SESSION['customer_name'].'</a></li>')
                ?>
                <li><a href="./logout.php"><span class="glyphicon glyphicon-log-in"></span> LOGOUT</a></li>
            </ul>
        </div>
    </div>
</nav>






<div style="background-color: #66ffff;border-radius: 10px;border: ridge #68beed 2px;max-width: 750px;" class="container">
    <div style="width: 100%;margin: 10px 0px;">
        <button onclick="myFunction1()"  style="width: 32.85%;" class="btn btn-primary">To Ship</button>
        <button onclick="myFunction2()"  style="width: 32.85%;" class="btn btn-primary">To Receive</button>
        <button onclick="myFunction3()"  style="width: 32.85%;" class="btn btn-primary">View All</button>
    </div>
    <div style="background-color: #2be6e6;border-radius: 10px;border: groove #ffffff 2px;max-width: 700px;" class="container">
        <div style="margin: 0px;padding: 0px;" id="ToShip" >
            <h3 style="text-decoration: underline;text-align: center;">Seeing To Ship</h3>
            <?php
            $query_stores_order="SELECT * FROM `order_` WHERE order_customer_id={$_SESSION['customer_id']} AND (order_status='CONFIRMED' OR order_status='TRANSPORTING_TO_STORE');";
            $query_stores_order=$con->query($query_stores_order);
            while($row=$query_stores_order->fetch_assoc()){


                $rN="SELECT `route_map`,`store_id` FROM `route` WHERE route_id={$row['route_id']};";
                $rN = $con->query($rN);
                $rN = $rN->fetch_assoc();
                $sN="SELECT `city_name` FROM `store` WHERE store_id={$rN['store_id']};";
                $sN = $con->query($sN);
                $sN = $sN->fetch_assoc();

                echo ('
            <div style="background-color: #858989;border-radius: 10px;border: groove #ffffff 2px;max-width: 650px;" class="container" >
            <h4 style="text-align: center;text-decoration: underline;">Order Id -'.$row['order_id'].'('.$row['order_status'].') </h4>
            <h6>Address:'.$row['delivery_address'].'</h6>
            <h6>Nearby Store:'.$sN['city_name'].'</h6>
            <h6>Route:'.$rN['route_map'].'</h6>
            <h6>Amount:'.$row['total_amount'].'.00LKR ('.$row['payment_status'].')</h6>
            <h6>Ordered Date:'.$row['order_date'].'</h6>
            <h6>Expected Delivery Date:'.$row['expected_delivery_date'].'</h6>
            <h6>Product:</h6>
            ');
                $qu_includes="SELECT `order_includes`.`order_id`, `order_includes`.`product_id`, `order_includes`.`quantity`,`product`.`product_name` 
FROM `order_includes`
INNER JOIN `product`
ON `order_includes`.`product_id`=`product`.`product_id` WHERE `order_includes`.`order_id`={$row['order_id']}";
                $qu_includes=$con->query($qu_includes);
                while($pro_row=$qu_includes->fetch_assoc()){
                    echo ('
                    <h6><a href="addToCart.php?id='.$pro_row['product_id'].'" id="change" style="text-decoration: none;">'.$pro_row['product_name'].'('.$pro_row['quantity'].')</a></h6>
                    ');

                }
                echo ('</div>');
            }
            ?>
        </div>

        <div hidden="hidden" style="margin: 0px;padding: 0px;" id="ToReceive" >
            <h3 style="text-decoration: underline;text-align: center;">Seeing To Receive</h3>
            <?php
            $query_stores_order="SELECT * FROM `order_` WHERE order_customer_id={$_SESSION['customer_id']} AND (order_status='IN_STORE' OR order_status='DELIVERING');";
            $query_stores_order=$con->query($query_stores_order);
            while($row=$query_stores_order->fetch_assoc()){

                $rN="SELECT `route_map`,`store_id` FROM `route` WHERE route_id={$row['route_id']};";
                $rN = $con->query($rN);
                $rN = $rN->fetch_assoc();
                $sN="SELECT `city_name` FROM `store` WHERE store_id={$rN['store_id']};";
                $sN = $con->query($sN);
                $sN = $sN->fetch_assoc();
                echo ('
            <div style="background-color: #858989;border-radius: 10px;border: groove #ffffff 2px;max-width: 650px;" class="container" >
            <h4 style="text-align: center;text-decoration: underline;">Order Id -'.$row['order_id'].'('.$row['order_status'].') </h4>
            <h6>Address:'.$row['delivery_address'].'</h6>
            <h6>Nearby Store:'.$sN['city_name'].'</h6>
            <h6>Route:'.$rN['route_map'].'</h6>
            <h6>Amount:'.$row['total_amount'].'.00LKR ('.$row['payment_status'].')</h6>
            <h6>Ordered Date:'.$row['order_date'].'</h6>
            <h6>Expected Delivery Date:'.$row['expected_delivery_date'].'</h6>
            <h6>Product:</h6>
            ');
                $qu_includes="SELECT `order_includes`.`order_id`, `order_includes`.`product_id`, `order_includes`.`quantity`,`product`.`product_name` 
FROM `order_includes`
INNER JOIN `product`
ON `order_includes`.`product_id`=`product`.`product_id` WHERE `order_includes`.`order_id`={$row['order_id']}";
                $qu_includes=$con->query($qu_includes);
                while($pro_row=$qu_includes->fetch_assoc()){
                    echo ('
                    <h6><a href="addToCart.php?id='.$pro_row['product_id'].'" id="change" style="text-decoration: none;" >'.$pro_row['product_name'].'('.$pro_row['quantity'].')</a></h6>
                    ');

                }
                echo ('</div>');
            }
            ?>
        </div>


        <div hidden="hidden" style="margin: 0px;padding: 0px;" id="ViewAll" >
            <h3 style="text-decoration: underline;text-align: center;">Seeing All</h3>
            <?php
            $query_stores_order="SELECT * FROM `order_` WHERE order_customer_id={$_SESSION['customer_id']};";
            $query_stores_order=$con->query($query_stores_order);
            while($row=$query_stores_order->fetch_assoc()){

                $rN="SELECT `route_map`,`store_id` FROM `route` WHERE route_id={$row['route_id']};";
                $rN = $con->query($rN);
                $rN = $rN->fetch_assoc();
                $sN="SELECT `city_name` FROM `store` WHERE store_id={$rN['store_id']};";
                $sN = $con->query($sN);
                $sN = $sN->fetch_assoc();
                echo ('
            <div style="background-color: #858989;border-radius: 10px;border: groove #ffffff 2px;max-width: 650px;" class="container" >
            <h4 style="text-align: center;text-decoration: underline;">Order Id -'.$row['order_id'].'('.$row['order_status'].') </h4>
            <h6>Address:'.$row['delivery_address'].'</h6>
            <h6>Nearby Store:'.$sN['city_name'].'</h6>
            <h6>Route:'.$rN['route_map'].'</h6>
            <h6>Amount:'.$row['total_amount'].'.00LKR ('.$row['payment_status'].')</h6>
            <h6>Ordered Date:'.$row['order_date'].'</h6>
            <h6>Expected Delivery Date:'.$row['expected_delivery_date'].'</h6>
            <h6>Product:</h6>
            ');
                $qu_includes="SELECT `order_includes`.`order_id`, `order_includes`.`product_id`, `order_includes`.`quantity`,`product`.`product_name` 
FROM `order_includes`
INNER JOIN `product`
ON `order_includes`.`product_id`=`product`.`product_id` WHERE `order_includes`.`order_id`={$row['order_id']}";
                $qu_includes=$con->query($qu_includes);
                while($pro_row=$qu_includes->fetch_assoc()){
                    echo ('
                    <h6><a href="addToCart.php?id='.$pro_row['product_id'].'" id="change" style="text-decoration: none;">'.$pro_row['product_name'].'('.$pro_row['quantity'].')</a></h6>
                    ');

                }
                echo ('</div>');
            }
            ?>
        </div>
        <br>
    </div>
    <br>
</div>


<br>
<br><br>
<div class="footer">
    <p>&copy;2022 Powered By DBProjGroup39(University of Moratuwa)</p>
</div>


</body>
</html>