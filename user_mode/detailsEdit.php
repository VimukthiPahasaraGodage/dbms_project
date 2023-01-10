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
        $customer_id = $_SESSION['customer_id'];
		
        $address = $_POST['address'];
        $phone_number = $_POST['phone_number'];


		if(!empty($address) && !empty($phone_number))
		{

			//save to database

            $query= "UPDATE `customer` SET `address`='$address',`phone_number`='$phone_number' WHERE customer_id='$customer_id'";
            if (isset($con)) {
                mysqli_query($con, $query);
            }
            $_SESSION['address'] = $address;
            $_SESSION['phone_number'] = $phone_number;
			header("Location: orderDetailsGet.php");
			die;
		}else
		{
			echo "Please enter some valid information!";
		}
	}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Signup</title>
    <link rel="stylesheet" href="../guest_mode/style/style_login.css">
    <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
    <meta charset="UTF-8" >
    <meta name="keywords" content="HTML, Css, JS, For Search Engines" >
    <meta name="description" content="Supply-Chain">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body style="padding-bottom: 0; margin-bottom: 0;" >

<?php
echo ('
<div class="middle"  style="margin:50px 5px 10px 5px">
    <div class="container-sm border" style="max-width: 650px;padding:10px 50px;background: linear-gradient(rgba(21, 51, 2, 0.8),rgba(42, 53, 43, 0.8)); border-radius: 9px;">
        <h2 style="text-align: center; color: #3ce811; font-weight: bolder;">Please Fill With Your Details</h2>
        <form style="color: #3ce811; font-size: 20px;" method="post" class="was-validated">
            <div class="mb-3 mt-3">
                <label for="customer_name" class="form-label">Username:</label>
                <input disabled type="text" value="'.$_SESSION['customer_name'].'" class="form-control" id="customer_name" placeholder="Enter name" name="customer_name" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input value="'.$_SESSION['email'].'" disabled type="email" class="form-control" id="email" placeholder="Enter Email" name="email" required>
                <div  class="invalid-feedback">Fill With Correct Email Address</div>
            </div>
        
            <div class="mb-3">
                <label for="password" class="m-label">Password:</label>
                <input value="'.$_SESSION['password'].'" disabled type="password" minlength="5" maxlength="20" class="form-control" id="password" placeholder="Enter Password" name="password" required>
            </div>
            
        
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone No:</label>
                <input value="'.$_SESSION['phone_number'].'" type="text" pattern="^\d{10}$" class="form-control" id="phone_number" placeholder="Enter Phone No" name="phone_number" required>
            </div>
        
            <div class="mb-3">
                <label for="address" class="form-label">Residance Address:</label>
                <input value="'.$_SESSION['address'].'" type="text" class="form-control" id="address" placeholder="Enter Address" name="address" required>
            </div>');
?>



            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" id="myCheck"  name="remember" required>
                <label class="form-check-label" for="myCheck">Checked</label>
                
            </div>
            <button value="Signup" name="signup" type="submit" class="btn btn-primary">Save</button>
            <a class="btn btn-primary" style="float: right; text-decoration: none;"  href="orderDetailsGet.php" >Continue</a>
		</form>
        
	</div>
</div>');
?>
</body>
</html>