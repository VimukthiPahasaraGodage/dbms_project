<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/dbms_project/dashboard/config/db_connect.php');
    $validation_errors = null;
    $year = '';

    if(isset($_POST['submit'])) {
        $validator = new Validator;
        $validation = $validator->make($_POST, [
            'year' => 'required|digits:4'
        ]);
        // Set custom validation messages
        //$validation->setMessages([
        //    'password:min' => 'Minimum length of password is 6',
        //    'password:digits' => 'Maximum length of password is 64',
        //]);
        $validation->validate();
        $year = $_POST['year'];
        if ($validation->passes()) {
            $start_date = $year.'-01-01';
            $end_date = $year.'-12-31';
            // Query the table and generate a report
            $sql = "SELECT * FROM sales_on_routes_and_cities 
                    WHERE order_date => $start_date AND order_date <= $end_date;";
            $records = mysqli_fetch_all(mysqli_query($connection, $sql), MYSQLI_ASSOC);
            $sql = "SELECT route_id, SUM(total_amount) as route_amount 
                    FROM sales_on_routes_and_cities 
                    WHERE order_date => $start_date AND order_date <= $end_date 
                    GROUP BY route_id 
                    ORDER BY route_id;";
            $route_amounts = mysqli_fetch_all(mysqli_query($connection, $sql));
            $sql = "SELECT city_name, SUM(total_amount) as city_amount 
                    FROM sales_on_routes_and_cities 
                    WHERE order_date => $start_date AND order_date <= $end_date 
                    GROUP BY city_name 
                    ORDER BY city_name;";
            $city_amounts = mysqli_fetch_all(mysqli_query($connection, $sql));
            $sql = "SELECT SUM(total_amount) AS total_amount 
                    FROM sales_on_routes_and_cities 
                    WHERE order_date => $start_date AND order_date <= $end_date;";
            $total_amount = mysqli_fetch_all(mysqli_query($connection, $sql));
        } else {
            $validation_errors = $validation->errors();
        }
    }?>
<html>
    <?php include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/templates/header.php') ?>

    <nav class="nav-wrapper indigo">
        <div class="container">
            <a href="index.php" class="brand-logo">Company A</a>
        </div>
    </nav>
    <div class="container">
        <form action="sales_report_on_cities_and_routes.php" method="post">
            <div class="input-field">
                <input type="number" id="year" name="year" value="<?php echo $year; ?>">
                <label for="year">Year</label>
                <div class="red-text"><?php echo !is_null($validation_errors) ? $validation_errors->first('year') : null; ?></div>
            </div>
            <div class="center">
                <input type="submit" name="submit" value="GENERATE" class="btn brand">
            </div>
        </form>
    </div>
    <div class="report">
        <table class="responsive-table stripped centered highlight">
            <caption>Sales Report on Cities & Routes for Year-<?php echo $year?></caption>
            <thead>
            <tr>
                <th>City</th>
                <th>Route</th>
                <th>Date</th>
                <th>Order ID</th>
                <th>Customer ID</th>
                <th>Customer Name</th>
                <th>Order Amount</th>
                <th>Route Amount</th>
                <th>City Amount</th>
            </tr>
            </thead>
            <tboady>
                <?php
                if(count($records) > 0){
                    // count the number of routes for each city
                    $row_spans = array();
                    foreach ($records as $record){
                        if(array_key_exists($record['city_name'], $row_spans)){
                            $row_spans['city_name'] += 1;
                        }else{
                            $row_spans['city_name'] = 1;
                        }
                        if(array_key_exists($record['route_id'], $row_spans)){
                            $row_spans['route_id'] += 1;
                        }else{
                            $row_spans['route_id'] = 1;
                        }
                    }
                    $city_amount = array();
                    foreach ($city_amounts as $amount_city){
                        $city_amount[$amount_city['city_name']] = $amount_city['city_amount'];
                    }
                    $route_amount = array();
                    foreach ($route_amounts as $amount_route){
                        $route_amount[$amount_route['route_id']] = $amount_route['route_amount'];
                    }
                    $current_city = $current_route = '';
                    foreach ($records as $row){

                        echo '<tr>';
                        if($row['city_name'] != $current_city) {
                            echo "<td rowspan='{$row_spans[$row['city_name']]}'>{$row['city_name']}</td>";
                        }
                        if($row['route_id'] != $current_route) {
                            echo "<td rowspan='{$row_spans[$row['route_id']]}>{$row['route_id']}</td>";
                        }
                        echo "<td>{$row['order_date']}</td>";
                        echo "<td>{$row['order_id']}</td>";
                        echo "<td>{$row['customer_id']}</td>";
                        echo "<td>{$row['customer_name']}</td>";
                        echo "<td>{$row['total_amount']}</td>";
                        if($row['city_name'] != $current_city){
                            echo "<td rowspan='{$row_spans[$row['city_name']]}'>{$city_amount[$row['city_name']]}</td>";
                            $current_city = $row['city_name'];
                        }
                        if($row['route_id'] != $current_route) {
                            echo "<td rowspan='{$row_spans[$row['route_id']]}'>{$route_amount[$row['route_id']]}</td>";
                            $current_route = $row['route_id'];
                        }
                        echo '</tr>';
                    }
                    echo '<tr>';
                    echo "<td colspan='6'>Total sales amount for year:$year</td>";
                    echo "<td>{$total_amount['total_amount']}</td>";
                    echo '</tr>';
                }else{
                    echo '<tr>';
                    echo "<td colspan='9'>No data to create the sales report on cities and routes on year:$year</td>";
                    echo '</tr>';
                }
                ?>
            </tboady>
        </table>
    </div>
    <?php include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/templates/footer.php') ?>
</html>
