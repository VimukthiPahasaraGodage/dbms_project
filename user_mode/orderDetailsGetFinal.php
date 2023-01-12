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
        <li><a href="./myOrders.php">MY ORDERS</a></li>
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
			<h2 style="text-align: center;" ><u>Welcome To Your Cart</u></h2>
      
			<?php
            $sql = 'select * from cart_product where customer_id='.$_SESSION['customer_id'].'';
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
				}
			}
			?>
<?php

if($total_amount==0){
    header("Location: cart.php");
}
echo('
<div class="detailsOfCustomer row">
    <ul>
        <li>Address:'.$_SESSION['address'].'</li>
        <li>Phone No:'.$_SESSION['phone_number'].'</li>
        <li>Total Amount:'.$total_amount.'.00LKR</li>
    </ul>
    <form>
    <a  href="detailsEdit.php" name="edit"  class="btn btn-success">Edit Details</a>
    <div class="form-check">
    <input class="form-check-input" type="radio" name="cashOnDelivery" id="flexRadioDefault2" required checked>
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

<script>
    function leastDate() {
        var date = new Date();
        date.setDate(date.getDate()+7);
        return date.toISOString().split("T")[0];

    }
</script>


<form method="post" action="order.php" class=" was-validated" style="padding: 0;" >
<div class="mb-3">
    <label for="address" class="form-label">Expected Delivery Date:</label>
    <?php
    echo '
    
    <input style="width:40%;" href="cart.php" name="expectDate" value='.$_POST['expectDate'].' onfocus="this.min=leastDate()" type="date"  class="form-control" id="address"  required> ';
    ?>
</div>

<div class="mb-3">
    <label for="address" class="form-label">Nearby Store:</label>
    <select  required    class="form-control" id="sel2" id="sel2" name="nearStore">
        <?php
        $store= "SELECT `store_id`, `station` FROM store";
        if(isset($con)){
            $store=$con->query($store);
        }
        while ($row=$store->fetch_assoc()){
            if($_POST['nearStore']==$row['store_id']){
                echo ('
                        <option selected  value="'.$row['store_id'].'">'.$row['station'].'</option>
                        ');

            }

        }
        ?>
    </select>
</div>


    <div  id="route" class="mb-3">
        <label for="address" class="form-label">Route:</label>
        <select required   class="form-control"  id="sel2" name="route">
            <option disabled hidden="hidden" value="" selected >Select</option>
            <?php
            $route= "SELECT * FROM `route` WHERE store_id={$_POST['nearStore']};";
            if(isset($con)){
                $route=$con->query($route);
            }
            while ($row=$route->fetch_assoc()){
                echo ('
                        <option   value="'.$row['route_id'].'">'.$row['route_map'].'</option>
                        ');
            }
            ?>
        </select>
    </div>




    <br>
<a style="width:40%;" href="cart.php" name="signup"  class="btn btn-success">Cancel Order</a>
<button style="width:40%;float:right;" value="finalized" name="signup" type="submit" class="btn btn-success">Confirm Order</button>
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



