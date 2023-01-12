<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/dbms_project/dashboard/config/db_connect.php');
    require($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/vendor/autoload.php');
    use Rakit\Validation\Validator;

    $validation_errors = null;
    $year = $quarter = '';
    $records = null;

    if(isset($_POST['submit'])) {
        $validator = new Validator;
        $validation = $validator->make($_POST, [
            'year' => 'required|digits:4',
            'quarter' => 'required|digits:1|in:1,2,3,4',
        ]);
        // Set custom validation messages
        //$validation->setMessages([
        //    'password:min' => 'Minimum length of password is 6',
        //    'password:digits' => 'Maximum length of password is 64',
        //]);
        $validation->validate();
        $year = $_POST['year'];
        $quarter = $_POST['quarter'];
        if ($validation->passes()) {
            $start_date = $end_date = '';
            if($quarter == 1){
                $start_date = $year.'-01-01';
                $end_date = $year.'-03-31';
            }elseif ($quarter == 2){
                $start_date = $year.'-04-01';
                $end_date = $year.'-06-30';
            }elseif ($quarter == 3){
                $start_date = $year.'-07-01';
                $end_date = $year.'-09-30';
            }else{
                $start_date = $year.'-10-01';
                $end_date = $year.'-12-31';
            }
            // Query the table and generate a report
            $sql = 'SELECT *
                    FROM quarterly_sales
                    WHERE order_date >= "'.$start_date.'" AND order_date <= "'.$end_date.'"
                    ORDER BY order_id;';
            $records = mysqli_fetch_all(mysqli_query($connection, $sql), MYSQLI_ASSOC);
            $sql = 'SELECT SUM(total_amount) AS total_amount
                    FROM quarterly_sales
                    WHERE order_date >= "'.$start_date.'" AND order_date <= "'.$end_date.'";';
            $total_amount = mysqli_fetch_all(mysqli_query($connection, $sql), MYSQLI_ASSOC);
        } else {
            $validation_errors = $validation->errors();
        }
    }
?>
<html>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/templates/header.php') ?>

<nav class="nav-wrapper indigo">
    <div class="container">
        <a href="index.php" class="brand-logo">Company A - Quarterly Sales Report</a>
    </div>
</nav>
<div class="container">
    <form action="quarterly_sales_report.php" method="post">
        <div class="input-field">
            <input type="number" id="year" name="year" value="<?php echo $year; ?>">
            <label for="year">Year</label>
            <div class="red-text"><?php echo !is_null($validation_errors) ? $validation_errors->first('year') : null; ?></div>
        </div>
        <div class="input-field">
            <input type="number" id="quarter" name="quarter" value="<?php echo $quarter; ?>">
            <label for="quarter">Quarter</label>
            <div class="red-text"><?php echo !is_null($validation_errors) ? $validation_errors->first('quarter') : null; ?></div>
        </div>
        <div class="center">
            <input type="submit" name="submit" value="GENERATE" class="btn brand">
        </div>
    </form>
</div>
<div class="report">
    <table class="responsive-table stripped centered highlight">
        <caption>Sales Report for Quarter-<?php echo $quarter?> of Year-<?php echo $year?></caption>
        <thead>
        <tr>
            <th>Date</th>
            <th>Order ID</th>
            <th>Customer ID</th>
            <th>Customer Name</th>
            <th>Amount</th>
        </tr>
        </thead>
        <tboady>
            <?php
                if(is_array($records) && count($records) > 0){
                    foreach ($records as $record){
                        echo '<tr>';
                        echo "<td>{$record['order_date']}</td>";
                        echo "<td>{$record['order_id']}</td>";
                        echo "<td>{$record['order_customer_id']}</td>";
                        echo "<td>{$record['customer_name']}</td>";
                        echo "<td>{$record['total_amount']}</td>";
                        echo '</tr>';
                    }
                    echo '<tr>';
                    echo "<td colspan='4'>Total sales done for quarter:$quarter of year:$year</td>";
                    echo "<td>{$total_amount[0]['total_amount']}</td>";
                    echo '</tr>';
                }else{
                    echo '<tr>';
                    echo "<td colspan='5'>No data to create the sales report for quarter:$quarter of year:$year</td>";
                    echo '</tr>';
                }
            ?>
        </tboady>
    </table>
</div>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/templates/footer.php') ?>
</html>
