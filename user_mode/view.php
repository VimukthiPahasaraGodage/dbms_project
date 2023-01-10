<?php 
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/connection/connection.php");
include($_SERVER['DOCUMENT_ROOT'] . "/connection/functions.php");
if (isset($con)) {
    $user_data = check_login($con);
}

if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
        $customer_id=$_SESSION['customer_id'];
        $product_id = $_GET['id'];
        $sqlSt = 'select * from cart_product where (product_id='.$product_id.' and customer_id='.$customer_id.')';
        $sql='select * from product where product_id='.$product_id.'';
	    	$resul = $con->query($sqlSt);
        $resul1 = $con->query($sql);
        $roww= $resul1->fetch_assoc();
		if(!($resul->num_rows>0) && $resul1->num_rows>0){
      if($roww['quantity']>0){
        $query = 'insert into cart_product (customer_id,product_id,quantity) values ('.$customer_id.','.$product_id.')';

			  mysqli_query($con, $query);
			  header("Location: ../index.php");
			  die;
      }
      else{
        //make a page canNotAdd !missed
        header("Location: ../index.php");
			  die;
      } 
    }
    else{
      //make a page alreadyadded !missed
      header("Location: ../index.php");
      die;
    }
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

  </style>
    </head>
<body>


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
        <li><a href="cart.php">CART</a></li>
        <li><a href="myOrders.php">MY ORDERS</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php
        echo('<li><a href="#"><span class="glyphicon glyphicon-user"></span> '.$_SESSION['customer_name'].'</a></li>') 
        ?> 
        <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> LOGOUT</a></li>
      </ul>
    </div>
  </div>
</nav>


<?php 
		if(isset($_GET['id'])){
	    	$sqlSt = "select * from product where product_id={$_GET['id']}";
	    	$resul = $con->query($sqlSt);
			
			if($resul->num_rows>0){
		    $roww = $resul->fetch_assoc();
        
        
		    	echo ('

				<div   class="card container" style="max-width:700px;height:auto;background: linear-gradient(rgba(21, 51, 2, 0.8),rgba(185,220,188,0.8));border: white groove 10px; border-radius: 12px;padding-bottom:10px;color: #3fee14;">
				<h2 style="text-align: center; color: #3ce811; font-weight: bolder;">' .$roww['product_name'].'</h2>
				<center><img  class="card-img-top" src="../'.$roww['image'].'" alt="Card image" style="width:auto;"></center>
				<div class="card-body">
        <form action="'.$_SERVER['REQUEST_URI'].'"  method="post" class="was-validated">
				
				  <h3 class="card-title">Price: '.$roww['price'].'.00LKR</h3>
				  <h3 class="card-title">RAM: '.$roww['ram'].'GB</h3>
				  <h3 class="card-title">Storage: '.$roww['storage'].'GB</h3>
				  <h2 class="card-title">Description:</h2>
				  <h2 class="card-title">Available Quantity:'.$roww['quantity']. '</h2>
				  
				  
				  

				  <br>


				  <a href="cart.php" class="btn btn-primary">Go Back</a>
          <a style="float:right;" href="index.php" class="btn btn-primary">Go To Home</a>
				  
          
				  </form>
				</div>
			  </div>
			  </div>	
				');
			}

		}else{
	    	header("location:./index.php");
		}
?>
<br>
<br><br>
<div class="footer">
                <p>&copy;2022 Powered By DBProjGroup39(University of Moratuwa)</p>
</div>


</body>
</html>