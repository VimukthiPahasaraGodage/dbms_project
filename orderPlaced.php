<?php 
session_start();
	include("connection.php");
	include("functions.php");
	$user_data = check_login($con);
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
    background: linear-gradient(rgba(115, 74, 2, 0.8),rgba(153, 98, 3, 0.8)), url(back.jpg);
    background-attachment: fixed;
    background-repeat: no-repeat;
    background-size: cover;
    background-position: center;
    width: 100%;
    height: 100vh;
    overflow-x: hidden;
}

.row:hover{
 color: brown;
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
        <li><a href="about.php">ABOUT</a></li>
        <li><a href="card.php">CARD</a></li>
        <li><a href="signup.php">REGISTER</a></li>
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


<div class="container" style="max-width: 800px;padding:10px 50px; background: linear-gradient(#66ffff,#ccffff); border-radius: 9px;" >
			<h2 style="text-align: center;" ><u>Welcome To Your Card</u></h2>
      
			<?php
            $sql = 'select * from card_product where customer_id='.$_SESSION['customer_id'].'';
            $ress = $con->query($sql);
            $total_amount = 0;
			if($ress->num_rows>0){
				while($row=$ress->fetch_assoc()){
                    if($row['quantity']==0){
                        continue;
                    }
          $pro = 'select * from product where product_id='.$row['product_id'].'';
          $pro = $con->query($pro);
          $pro = $pro->fetch_assoc();
          //mention discount
          $total_amount=$total_amount+$pro['price']*$row['quantity'];
          echo('
          <form method="post" action="save.php?id='.$pro['product_id'].'" >
          <div style="padding:5px;margin-bottom:10px;background: linear-gradient(#00cc00,#66ff66); border-radius: 9px;"   class="row">
					<h1>'.$pro['product_name'].'</h1>
          <p>'.$pro['price'].'.00LKR</p>
          
            <input  disabled checked class="form-check-input" type="checkbox" id="myCheck"  name="select" >
            <label class="form-check-label" for="myCheck">Selected(Quantity '.$row['quantity'].')</label>
            
          
          </div>
          </form>
					');
          $proID= $pro['product_id'];
          $cus_id = $_SESSION['customer_id'];
          $del= "DELETE FROM `card_product` WHERE (product_id='$proID' and customer_id='$cus_id') ";
          mysqli_query($con, $del);
				}
			}
			?>
<?php 
echo('
<div class="detailsOfCustomer row">
    <ul>
        <li>Address:'.$_SESSION['address'].'</li>
        <li>Phone No:'.$_SESSION['phone_number'].'</li>
        <li>Total Amount:'.$total_amount.'.00LKR</li>
    </ul>
    <form>
    <div class="form-check">
    <input disabled class="form-check-input" type="radio" name="cashOnDelivery" id="flexRadioDefault2" required checked>
    <label class="form-check-label" for="cashOnDelivery">
      Cash On Delivery
    </label>
    </div>

    <div class="form-check">
    <input disabled  class="form-check-input" type="radio" name="cashOnDelivery" required id="flexRadioDefault2">
    <label class="form-check-label" for="ViaCard">
      Via Card
    </label>
    </div>
              
    </form>
</div>
')

?>
<form class="row" style="padding: 0;" >
<h3 style="text-align:center;">Order Placed!</h3>
<h3 style="text-align:center;">Thank You For Joing Us</h3>
<a style="width:100%;" href="index.php" name="signup" type="submit" class="btn btn-success">Buy More</a>

</form>

</div>

<br>
<br>
<br>



<div class="footer">
                <p>&copy;2022 Powered By DBProjGroup39(University of Moratuwa)</p>
</div>




</body>
</html>



