<?php
    include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/config/db_connect.php');
    require($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/vendor/autoload.php');
    use Rakit\Validation\Validator;

    $validation_errors = null;
    $customer_id = $email = $password = $confirm_password = $name = $phone_number = $address = $discount = $type = $mode = '';

    if(array_key_exists('mode', $_GET) and ($mode = $_GET['mode']) == 'update'){
        $customer_id = $_GET['customer_id'];
        $sql = "SELECT * FROM customer WHERE customer_id = '$customer_id';";
        $result = mysqli_query($connection, $sql);
        $customer_record = mysqli_fetch_array($result, MYSQLI_ASSOC);

        $email = $customer_record['email'];
        $password = $customer_record['password'];
        $confirm_password = $password;
        $name = $customer_record['customer_name'];
        $phone_number = $customer_record['phone_number'];
        $address = $customer_record['address'];
        $discount = $customer_record['discount'];
        $type = $customer_record['type'];
    }

    if(array_key_exists('mode', $_POST)){
        $mode = $_POST['mode'];
        if($mode == 'update' or $mode == 'insert'){
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
                $customer_id = $_POST['customer_id'];
                if($validation->passes()){
                    if($mode == 'update'){
                        $sql = "UPDATE customer SET email = '$email', password = '$password', customer_name = '$name', phone_number = '$phone_number', address = '$address', discount = '$discount', type = '$type' WHERE customer_id = '{$_POST['customer_id']}';";
                        if(mysqli_query($connection, $sql)){
                            $redirect = 'index.php?mode=update&success=true';
                        }else{
                            $redirect = 'index.php?mode=update&success=false';
                        }
                    }
                    if($mode == 'insert'){
                        $sql = "INSERT INTO customer (email, password, customer_name, phone_number, address, discount, type) VALUES ('$email', '$password', '$name', '$phone_number', '$address', '$discount', '$type');";
                        if(mysqli_query($connection, $sql)){
                            $redirect = 'index.php?mode=insert&success=true';
                        }else{
                            $redirect = 'index.php?mode=insert&success=false';
                        }
                    }
                    Header('Location: '.$redirect);
                    exit();
                }else{
                    $validation_errors = $validation->errors();
                }
            }
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

    <div class="container">
        <?php include ('customer_info_form.php') ?>
    </div>

    <?php include($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/templates/footer.php') ?>
    <script>
        $(document).ready(function () {
            $('select').formSelect();
        });
    </script>
</html>