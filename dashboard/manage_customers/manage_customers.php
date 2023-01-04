<?php
    include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/config/db_connect.php');
    require($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/vendor/autoload.php');

    use Rakit\Validation\Validator;

    $validation_errors = null;
    $email = $password = $confirm_password = $name = $phone_number = $address = $discount = $type = '';
    if(isset($_POST['submit'])){
        $validator = new Validator;
        $validation = $validator->make($_POST,[
            'email' => 'required|email|max:100',
            'password' => 'required|min:6|max:64',
            'confirm_password' => 'required|same:password',
            'name' => 'required|regex:/^[a-zA-Z\s.]+$/|max:50',
            'phone_number' => 'required|regex:/0{1,1}[1-9]{1,1}[0-9]{8,8}/|digits:10',
            'address' => 'required|regex:/^[0-9a-zA-Z\s,-\/]+$/|max:100',
            'discount' => 'required|min:0|max:99.99|regex:/^[0-9]{0,1}[0-9]\.{0,1}[0-9]{0,2}$/|numeric',
            'type' => 'required|in:WHOLESALER,RETAILER,END_CUSTOMER'
        ]);
        $validation->setMessages([
                'password:min' => 'Minimum length of password is 6',
                'password:max' => 'Maximum length of password is 64',
                'confirm_password:same' => 'Passwords does not match',
                'name:regex' => 'Name does not comply with the the pattern',
                'phone_number:regex' => 'Phone number does not comply with the pattern',
                'address:regex' => 'Address does not comply with the pattern'
            ]);
        $validation->validate();

        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $name = $_POST['name'];
        $phone_number = $_POST['phone_number'];
        $address = $_POST['address'];
        $discount = $_POST['discount'];
        if(array_key_exists('type', $_POST)){
            $type = $_POST['type'];
        }

        if($validation->passes()){
            $sql = "INSERT INTO customer (email, password, customer_name, phone_number, address, discount, type) VALUES ('$email', '$password', '$name', '$phone_number', '$address', '$discount', '$type');";
            if(!mysqli_query($connection, $sql)){
                // TODO: handle the error
                echo "<script>alert('Failed entering the customer record to database')</script>";
            }else{
                echo "<script>alert('Successfully entered the customer record to database')</script>";
            }
            $email = $password = $confirm_password = $name = $phone_number = $address = $discount = $type = '';
        }else{
            $validation_errors = $validation->errors();
        }
    }
?>
<html>
    <?php include($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/templates/header.php') ?>

    <nav class="nav-wrapper indigo">
        <div class="container">
            <a href="#" class="brand-logo">Company A</a>
        </div>
    </nav>

    <section class="container section">
        <div class="row">
            <div class="col s12">
                <ul class="tabs">
                    <li class="tab col s6">
                        <a href="#add_customer" class="pink-text text-darken-4">Add a new customer</a>
                    </li>
                    <li class="tab col s6">
                        <a href="#update_customer" class="pink-text text-darken-4">Update existing customer</a>
                    </li>
                </ul>
            </div>
        </div>
    </section>
    <div class="col s12" id="add_customer">
        <div class="container">

        </div>
        <div class="container">
            <?php include ('customer_info_form.php') ?>
        </div>
    </div>
    <div class="col s12" id="update_customer">
        <div class="container">

        </div>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/templates/footer.php') ?>
    <script>
        $(document).ready(function () {
            $('.tabs').tabs();
            $('select').formSelect();
        });
    </script>
</body>
</html>