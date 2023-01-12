<?php 
session_start();
include($_SERVER['DOCUMENT_ROOT'] . "/dbms_project/connection/connection.php");
include($_SERVER['DOCUMENT_ROOT'] . "/dbms_project/connection/functions.php");
if (isset($con)) {
    $user_data = check_login($con);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
   /* background: linear-gradient(rgba(115, 74, 2, 0.8),rgba(153, 98, 3, 0.8)), url(back.jpg);*/
   background-color: antiquewhite;
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    width: 100%;
    height: 100vh;
    overflow-x: hidden;
}

#userDetails {
    background-color: initial;
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


     <li>
         <?php
         echo ('<li><a href="#"><span class="glyphicon glyphicon-user"></span> '.$_SESSION['customer_name'].'</a></li>');
         ?>
     </li>

        <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span> LOGOUT</a></li>
      </ul>
    </div>
  </div>
</nav>


<div class="container" >
		<div class="row">
			<h2 style="text-align: center;" ><u>Mobile Phones</u></h2>
			<?php
            $sql = "select * from product";
            $ress = $con->query($sql);
			if($ress->num_rows>0){
				while($row=$ress->fetch_assoc()){
          if($row['quantity']==0){
            continue;
          }
                    echo(' 
          
                    <div style="height:650px;" class="col-sm-6 col-lg-3 col-md-4 text-center">
                    <img src="../'.$row['image'].'" alt="Cart image" class="img-fluid">
                    <h4 style="font-size:15px;" class="card-title">'.$row['product_name'].'</h4>
                    <p>'.$row['price'].'.00LKR</p>
                    <a href="addToCart.php?id='.$row['product_id'].'" class="btn btn-success">View Details</a>
                    </div>
					');
				}
			}
			?>
		</div>
	</div>
<div class="footer">
                <p>&copy;2022 Powered By DBProjGroup39(University of Moratuwa)</p>
</div>
</body>
</html>

