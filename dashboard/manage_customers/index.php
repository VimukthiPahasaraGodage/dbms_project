<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/dbms_project/dashboard/config/db_connect.php');
    if(array_key_exists('mode', $_REQUEST) and array_key_exists('success', $_REQUEST)){
        $mode = $_REQUEST['mode'];
        $result = $_REQUEST['success'];
        if($mode == 'update'){
            if($result == 'true'){
                echo '<script>alert("Successfully updated the customer information")</script>';
            }else{
                echo '<script>alert("Error while updating the customer information")</script>';
            }
        }elseif ($mode == 'insert'){
            if($result == 'true'){
                echo '<script>alert("Successfully added the customer to database")</script>';
            }else{
                echo '<script>alert("Error while adding the customer to database")</script>';
            }
        }
    } ?>
<html>
    <?php include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/templates/header.php') ?>
    <nav class="nav-wrapper indigo">
        <div class="container">
            <a href="index.php" class="brand-logo">Company A</a>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <div class="col s12 l5">
                <div class="input-field">
                    <select id="search_by" name="search_by">
                        <option value="" disabled selected>Choose attribute to search on</option>
                        <option value="customer_id">Customer ID</option>
                        <option value="customer_name">Name</option>
                        <option value="email">Email</option>
                        <option value="phone_number">Phone Number</option>
                        <option value="type">Customer Type</option>
                    </select>
                    <label for="type">Search By</label>
                </div>
            </div>
            <div class="col s12 l7">
                <div class="input-field">
                    <input id="search_box" name="search_box" type="text" placeholder="Search">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 l5">
                <div class="input-field">
                    <select id="order_by" name="order_by">
                        <option value="" disabled selected>Choose attribute to order on</option>
                        <option value="customer_id">Customer ID</option>
                        <option value="customer_name">Customer Name</option>
                    </select>
                    <label for="type">Order By</label>
                </div>
                <div class="input-field">
                    <select id="order" name="order">
                        <option value="" disabled selected>Choose an order</option>
                        <option value="ASC">Ascending Order</option>
                        <option value="DESC">Descending Order</option>
                    </select>
                    <label for="type">Order</label>
                </div>
            </div>
        </div>
        <div class="responsive-table" id="customers">
        </div>
        <div class="container">
            <form action="add_update_customer.php" method="POST">
                <input type="hidden" name="mode" value="insert">
                <button type="submit" value="insert" class="btn-floating btn-large waves-effect waves-light red right-align">
                    <i class="material-icons">add</i>
                </button>
            </form>
        </div>
    </div>
    <script>
        var search_by = '';
        var search_term = '';
        var order_by = '';
        var order = '';
        var page = 1;
        $(document).ready(function (){
            function load_data(page, search_by, search_term, order_by, order){
                $.ajax({
                    url:"fetch_customers.php",
                    method:"POST",
                    data:{page:page, search_by:search_by, search_term:search_term, order_by:order_by, order:order},
                    success:function (data) {
                        $('#customers').html(data);
                    }
                });
            }
            load_data(page, search_by, search_term, order_by, order);
            $('#search_by').change(function (){
                search_by = $(this).val();
                load_data(1, search_by, search_term, order_by, order);
            })
            $('#search_box').keyup(function(){
                if(search_by !== ''){
                    search_term = $(this).val();
                    load_data(1, search_by, search_term, order_by, order);
                }
            });
            $('#order_by').change(function (){
                order_by = $(this).val();
                load_data(1, search_by, search_term, order_by, order);
            })
            $('#order').change(function (){
                if(order_by !== ''){
                    order = $(this).val();
                    load_data(1, search_by, search_term, order_by, order);
                }
            })
            $(document).on('click', '.page-link', function(){
                page = $(this).data('page_number');
                load_data(page, search_by, search_term, order_by, order);
            });
            $(document).on('click', '.update_row_btn', function(){
                var customer_id = $(this).data('customer_id');
                var url = "add_update_customer.php?mode=update&customer_id=" + customer_id;
                window.location.href = url;
            });
            $(document).on('click', '.delete_row_btn', function(){
                var customer_id = $(this).data('customer_id');
                if(confirm("Are you sure you want to delete this?")){
                    $.ajax({
                        url:"delete_customer.php",
                        method:"POST",
                        data:{customer_id:customer_id, mode:'delete'},
                        dataType:"text",
                        success:function(data)
                        {
                            alert();
                            load_data(1, search_by, search_term, order_by, order);
                        }
                    });
                }
            });
        });
    </script>
    <?php include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/templates/footer.php') ?>
    <script>
        $(document).ready(function () {
            $('select').formSelect();
        });
    </script>
</html>

