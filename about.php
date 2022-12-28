
<!DOCTYPE html>
<html>
    <head>
        <title>about</title>
        <link rel="stylesheet" href="style_login.css">  
        <script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
        <meta charset="UTF-8" >
        <meta name="keywords" content="HTML, Css, JS, For Search Engines" >
        <meta name="description" content="Free Web Tutorial">
        <meta name="author" content="LuxShan">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        

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
                          <a href="index.php">HOME</a>
                          <a href="about.php">ABOUT</a>
                          <a href="card.php" aria-disabled="true" title="Please Login">CARD</a>
                          <a href="signup.php">REGISTER</a>
                          <a href="contact.php">CONTACTS</a>
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
                        
                        <li><a href="index.php" >HOME</a></li>
                        <li><a href="about.php">ABOUT</a</li>
                        <li><a href="card.php" aria-disabled="true" title="Please Login">CARD</a></li>
                        <li><a href="signup.php">REGISTER</a></li>
                        <li><a href="contact.php">CONTACT</a></li>
    
                    </ul>
                </div>
            </div>
            <br>
                <!--middle-->
              
            
                
            <br>
            <br>

            <div class="footer">
                <p>&copy;2022 Powered By DBProjGroup39(University of Moratuwa)</p>
            </div>
        </div>
      
    </body>
</html>