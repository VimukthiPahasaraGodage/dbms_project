<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/dbms_project/dashboard/config/db_connect.php');
    require($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/vendor/autoload.php');
    use Rakit\Validation\Validator;

    $validation_errors = null;
    $year = $quarter = '';

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
            $sql = "SELECT o.order_date, o.order_id, o.order_customer_id, c.customer_name, o.total_amount FROM order_ AS o LEFT JOIN customer AS c ON o.order_customer_id = c.customer_id WHERE o.order_date => $start_date AND o.order_date <= $end_date AND o.payment_status = 'PAID' ORDER BY o.order_id ASC;";
            $result = mysqli_query($connection, $sql);
            if($result){
                $results = mysqli_fetch_all($result, MYSQLI_ASSOC);
                mysqli_free_result($result);
                $sql = "SELECT SUM(o.total_amount) AS total_amount FROM order_ AS o LEFT JOIN customer AS c ON o.order_customer_id = c.customer_id WHERE o.order_date => $start_date AND o.order_date <= $end_date AND o.payment_status = 'PAID';";
                $result = mysqli_query($connection,$sql);
                if($result){
                    $total_amount = mysqli_fetch_all($result, MYSQLI_ASSOC);
                }else{
                    //TODO: handle the error
                }
            }else{
                //TODO: handle the error
            }
        } else {
            $validation_errors = $validation->errors();
        }
    }
?>
<html>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/templates/header.php') ?>

<nav class="nav-wrapper indigo">
    <div class="container">
        <a href="index.php" class="brand-logo">Company A</a>
    </div>
</nav>
<div class="container">
    <form action="sales_report.php" method="post">
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
                if(count($results) > 0){
                    foreach ($results as $result){
                        echo '<tr>';
                        echo "<td>{$result['order_date']}</td>";
                        echo "<td>{$result['order_id']}</td>";
                        echo "<td>{$result['customer_id']}</td>";
                        echo "<td>{$result['customer_name']}</td>";
                        echo "<td>{$result['total_amount']}</td>";
                        echo '</tr>';
                    }
                    echo '<tr>';
                    echo "<td colspan='4'>Total sales done for quarter:$quarter of year:$year</td>";
                    echo "<td>{$total_amount['total_amount']}</td>";
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
