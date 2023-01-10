<?php 

session_start();

include($_SERVER['DOCUMENT_ROOT'] . "/connection/connection.php");
include($_SERVER['DOCUMENT_ROOT'] . "/connection/functions.php");


	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		//something was posted
        
		$email = $_POST['email'];
		$password = $_POST['password'];
        


		if(!empty($email) && !empty($password))
		{
			//read from database
			$query = "select * from customer where email = '$email' limit 1";
            if (isset($con)) {
                $result = mysqli_query($con, $query);
            }

			if($result)
			{
				if($result && mysqli_num_rows($result) > 0)
				{

					$user_data = mysqli_fetch_assoc($result);
					
					if($user_data['password'] === $password)
					{

						$_SESSION['email'] = $user_data['email'];
						header("Location: ../user_mode/index.php");
						die;
					}else{
                        header("Location: ./wrongpass.php");
                        die;
                    }
				}else{
                    header("Location: ./wrongpass.php");
                    die;
                }
			}
		}
	}
?>

<!--- ----------------------------------------------->

<!DOCTYPE html>
<html>
    <head>
        <title>login</title>
        <link rel="stylesheet" href="./style/style_login.css">
        <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
        <meta charset="UTF-8" >
        <meta name="keywords" content="HTML, Css, JS, For Search Engines" >
        <meta name="description" content="Supply-Chain">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        
        <style type="text/css">
            ::placeholder {
            color: red;
            opacity: 1; /* Firefox */
            }

            :-ms-input-placeholder { /* Internet Explorer 10-11 */
            color: red;
            }

            ::-ms-input-placeholder { /* Microsoft Edge */
            color: red;
            }
        </style>
    </head>
    <body>

            <!--container-->
        <div class="container">
                <!--main-->
            <div class="main">
                    <!--logo-->
                <div class="logo">
                    <p  class="log">Shopping With Us</p>  
                </div>

                <div class="unvisi">
                    <div id="myNav" class="overlay">
                        <a style="font-size: 50px;font-weight: bold;"  href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
                        <div class="overlay-content">
                          <p style="color: #3fee14;font-size: 35px;" class="log1">Learing With Lux</p>
                          <a href="../user_mode/index.php">HOME</a>
                          <a href="./about.php">ABOUT</a>
                          <a href="../user_mode/cart.php" aria-disabled="true" title="Please Login">CART</a>
                          <a href="./signup.php">REGISTER</a>
                          <a href="./contact.php">CONTACTS</a>
                        </div>
                      </div>
                    <div class="me">
                    <span class="hi" style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>
                    <p class="log1">Shopping With Us</p>  </div>
                    <script>
                        function openNav() {
                          document.getElementById("myNav").style.display = "block";
                        }
                        
                        function closeNav() {
                          document.getElementById("myNav").style.display = "none";
                        }
                        </script> </div>
                    <!--menu-->
                <div class="menu">
                    <ul>
                        
                        <li><a href="../user_mode/index.php" >HOME</a></li>
                        <li><a href="./about.php">ABOUT</a</li>
                        <li><a href="../user_mode/cart.php" aria-disabled="true" title="Please Login">CART</a></li>
                        <li><a href="./signup.php">REGISTER</a></li>
                        <li><a href="./contact.php">CONTACT</a></li>
    
                    </ul>
                </div>
            </div>
                <!--middle-->
            <div class="middle">
                    <!--left-->
                <div class="left">
                    <h2>
                        Company Name<br>
                        <span class="heading">Online Shopping</span><br>
                        (Low Price)
                    </h2>
                    <p class="par" >
                        For more than 10 years our company has provided online 
                        shopping for customers. We always make fast delivery and 
                        quality product for the price. If you like to buy, please join us 
                        by registering with your details.
                    </p>
                    <br>
                    <div class="offer">
                        <h3 style="color: #68beed;text-align: center;">Offers</h3>
                        <ul style="list-style-type:square;padding-left: 30px;">
                            <li>Big Year End Sale 30% Discount Until 30th December</li>
                            <li>Free Delivery (20th to 31th December)</li>
                            <li>You Can Get Vouchers</li>
                        </ul>
                    </div>
                    <br>
                    <a href="./signup.php" style="text-decoration: none;" ><button class="btnJ" style="border-color: #026e34;margin-bottom: 50px;" >JOIN US</button></a>
                </div>
                <br>
                <br>
                <br>
                    <!--right-->
                <div class="right">
                    <h2>Login Here</h2>
                    <form method="post">
                    <input class="wrongEm" type="email" name="email" placeholder="Enter Email Here"><br>
                    <input  type="password" name="password" placeholder="Enter Password Here"><br>
                    <button type="submit" name="login" value="Login" >Login</button>
                    </form>
                    <p class="forgot" ><a href="./forgotpassword.php">Forgotten</a> Your Password</p>
                    <p class="link" >Don't have an account<br>
                    <a href="./signup.php" >Sign up here </a></p>
                </div>
            </div>
                <!--footer-->
            <div class="footer">
                <p>&copy;2022 Powered By DBProjGroup39(University of Moratuwa)</p>
            </div>
        </div>
      
    </body>
</html>