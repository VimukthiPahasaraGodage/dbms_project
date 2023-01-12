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
    background: linear-gradient(rgba(115, 74, 2, 0.8),rgba(153, 98, 3, 0.8)), url(../guest_mode/style/background/back.jpg);
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
        <li><a href="../guest_mode/about.php">ABOUT</a></li>
        <li><a href="./cart.php">CART</a></li>
        <li><a href="./myOrders.php">My ORDERS</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">

          <?php
          echo ('<li><a href="#"><span class="glyphicon glyphicon-user"></span> '.$_SESSION['customer_name'].'</a></li>');
          ?>

        <li><a href="./logout.php"><span class="glyphicon glyphicon-log-in"></span> LOGOUT</a></li>
      </ul>
    </div>
  </div>
</nav>


<div class="container" style="max-width: 800px;padding:10px 50px; background: linear-gradient(#66ffff,#ccffff); border-radius: 9px;" >
			<h2 style="text-align: center;" ><u>Welcome To Your Cart</u></h2>
      
			<?php
            $sql = 'select * from cart_product where customer_id='.$_SESSION['customer_id'].'';
            $ress = $con->query($sql);
            $amount=0;
			if($ress->num_rows>0){
				while($row=$ress->fetch_assoc()){
          $pro = 'select * from product where product_id='.$row['product_id'].'';
          $pro = $con->query($pro);
          $pro = $pro->fetch_assoc();
         // $amount=$amount+$pro['price']*$row['quantity'] ;
          if($pro['quantity']>0 && $row['quantity']<=$pro['quantity']){
              $amount=$amount+$pro['price']*$row['quantity'] ;
              echo('
          <form method="post" action="save.php?id='.$pro['product_id'].'" >
          <div style="padding:5px;margin-bottom:10px;background: linear-gradient(#00cc00,#66ff66); border-radius: 9px;"   class="row">
					<h1>'.$pro['product_name'].'</h1>
          <p>'.$pro['price'].'.00LKR</p>
          
            <input disabled checked class="form-check-input" type="checkbox" id="myCheck"  name="select" >
            <label class="form-check-label" for="myCheck">Selected('.$row['quantity'].')</label>
            <input title="If you don\'t order now, leave it as zero" style="max-width:100px;margin-bottom:5px;"  max='.$pro['quantity'].' type="number" min=0 value='.$row['quantity'].' class="form-control" id="quantity_order" placeholder="Quantity" name="quantity_add" required>  
          
          

          <a href="view.php?id='.$pro['product_id'].'" class="btn btn-primary">View Details</a>
          <button value="Signup" name="signup" type="submit" class="btn btn-primary">Save</button>
          <a href="remove.php?id='.$pro['product_id'].'" class="btn btn-primary">Remove</a>
          </div>
          </form>
          

					');

          }
          else{
              $up_qu='UPDATE `cart_product` SET `quantity`='.$pro['quantity'].' WHERE `customer_id`='.$_SESSION['customer_id'].' and product_id='.$row['product_id'].'';
              mysqli_query($con,$up_qu);
              $row['quantity']=$pro['quantity'];
              $sente="Sorry Product Salled!";
              if($pro['quantity']!=0){
                  $sente='Available Quantity Reduced to '.$row['quantity'].'!(Please Save)';
              }
              echo('
          <form method="post" action="save.php?id='.$pro['product_id'].'" >
          <div style="padding:5px;margin-bottom:10px;background: linear-gradient(#00cc00,#66ff66); border-radius: 9px;"   class="row">
					<h1>'.$pro['product_name'].'</h1>
          <p>'.$pro['price'].'.00LKR</p>
          
            <input disabled checked class="form-check-input" type="checkbox" id="myCheck"  name="select" >
            <label style="color: red" class="form-check-label" for="myCheck">'.$sente.'</label>
            <input title="If you don\'t order now, leave it as zero" style="max-width:100px;margin-bottom:5px;"  max='.$pro['quantity'].' type="number" min=0 value='.$row['quantity'].' class="form-control" id="quantity_order" placeholder="Quantity" name="quantity_add" required>  
          
          

          <a href="view.php?id='.$pro['product_id'].'" class="btn btn-primary">View Details</a>
          <button value="Signup" name="signup" type="submit" class="btn btn-primary">Save</button>
          <a href="remove.php?id='.$pro['product_id'].'" class="btn btn-primary">Remove</a>
          </div>
          </form>
          

					');
          }

				}
        if($amount==0){
          echo('
        <h3 style="text-align:center;" >Not Selected Anything!!!</h3>
        <form class="row" style="padding: 0;" >
          <a style="width:100%;" href="index.php" name="signup" type="submit" class="btn btn-success">Add To Cart</a>
          </form>
        
        ');
        }
        else{
          echo ('
        <form class="row" style="padding: 0;" >
          <a style="width:100%;" href="orderDetailsGet.php" name="signup" type="submit" class="btn btn-success">Processed To Order</a>
          </form>
        ');
        }
        
			}
      else{
        echo('
        <h3>Empty!!!</h3>
        <form class="row" style="padding: 0;" >
          <a style="width:100%;" href="index.php" name="signup" type="submit" class="btn btn-success">Add To Cart</a>
          </form>
        
        ');
      }
			?>


</div>

<br>
<br>
<br>



<div class="footer">
                <p>&copy;2022 Powered By DBProjGroup39(University of Moratuwa)</p>
</div>
</body>
</html>



