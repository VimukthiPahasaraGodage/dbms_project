<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/dbms_project/dashboard/config/db_connect.php');
    require($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/vendor/autoload.php');
    use Rakit\Validation\Validator;

    $validation_errors = null;
    $year = '';
    $records = null;

    if(isset($_POST['submit'])) {
        $validator = new Validator;
        $validation = $validator->make($_POST, [
            'year' => 'required|digits:4',
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
            $sql = 'SELECT customer_id, customer_name, COUNT(DISTINCT order_id) AS num_orders, SUM(total_amount) AS total_amount
                    FROM customer_analytics
                    WHERE order_date >= "'.$start_date.'" AND order_date <= "'.$end_date.'"
                    GROUP BY customer_id
                    ORDER BY total_amount, num_orders;';
            $records = mysqli_fetch_all(mysqli_query($connection, $sql), MYSQLI_ASSOC);
            $sql = 'SELECT COUNT(DISTINCT order_id) AS total_orders
                    FROM customer_analytics
                    WHERE order_date >= "'.$start_date.'" AND order_date <= "'.$end_date.'";';
            $total_order_count = mysqli_fetch_all(mysqli_query($connection, $sql), MYSQLI_ASSOC);
            $sql = 'SELECT SUM(total_amount) AS total_amount
                        FROM customer_analytics
                        WHERE order_date >= "'.$start_date.'" AND order_date <= "'.$end_date.'";';
            $total_sales_amount = mysqli_fetch_all(mysqli_query($connection, $sql), MYSQLI_ASSOC);
        } else {
            $validation_errors = $validation->errors();
        }
    }?>
<html>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/templates/header.php') ?>

<nav class="nav-wrapper indigo">
    <div class="container">
        <a href="index.php" class="brand-logo">Company A - Customer Analytics</a>
    </div>
</nav>
<div class="container">
    <form action="customer_report.php" method="POST">
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
        <caption>Customer Analytics for Year-<?php echo $year?></caption>
        <thead>
        <tr>
            <th>Customer ID</th>
            <th>Customer Name</th>
            <th>Number of Orders</th>
            <th>Total Amount</th>
        </tr>
        </thead>
        <tboady>
            <?php
            if(is_array($records) && count($records) > 0){
                foreach ($records as $record){
                    echo '<tr>';
                    echo "<td>{$record['customer_id']}</td>";
                    echo "<td>{$record['customer_name']}</td>";
                    echo "<td>{$record['num_orders']}</td>";
                    echo "<td>{$record['total_amount']}</td>";
                    echo '</tr>';
                }
                echo '<tr>';
                echo "<td colspan='3'>Total number of orders in year:$year</td>";
                echo "<td>{$total_order_count[0]['total_orders']}</td>";
                echo '</tr>';
                echo '<tr>';
                echo "<td colspan='3'>Total sales amount in year:$year</td>";
                echo "<td>{$total_sales_amount[0]['total_amount']}</td>";
                echo '</tr>';
            }else{
                echo '<tr>';
                echo "<td colspan='5'>No data to create the customer analystics for year:$year</td>";
                echo '</tr>';
            }
            ?>
        </tboady>
    </table>
</div>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/templates/footer.php') ?>
</html>
