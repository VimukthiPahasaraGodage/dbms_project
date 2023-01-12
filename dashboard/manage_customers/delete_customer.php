<?php
    include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/config/db_connect.php');
    if(array_key_exists('mode', $_POST) and $_POST['mode'] == 'delete'){
        $sql = "DELETE FROM customer WHERE customer_id = {$_POST['customer_id']};";
        if(mysqli_query($connection, $sql)){
            echo 'Successfully deleted the customer:'.$_POST['customer_id'];
        }else{
            echo 'Error while deleting the customer:'.$_POST['customer_id'];
        }
    }