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
            $sql = 'SELECT truck_registration_no, SUM(duration) AS total_duration
                    FROM truck_analytics
                    WHERE date >= "'.$start_date.'" AND date <= "'.$end_date.'"
                    GROUP BY truck_registration_no
                    ORDER BY truck_registration_no;';
            $records = mysqli_fetch_all(mysqli_query($connection, $sql), MYSQLI_ASSOC);
            $sql = 'SELECT SUM(duration) AS total_duration
                    FROM truck_analytics
                    WHERE date >= "'.$start_date.'" AND date <= "'.$end_date.'";';
            $total_delivery_duration = mysqli_fetch_all(mysqli_query($connection, $sql), MYSQLI_ASSOC);
        } else {
            $validation_errors = $validation->errors();
        }
    }?>
<html>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/templates/header.php') ?>

<nav class="nav-wrapper indigo">
    <div class="container">
        <a href="index.php" class="brand-logo">Company A - Truck Analytics</a>
    </div>
</nav>
<div class="container">
    <form action="truck_report.php" method="POST">
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
        <caption>Truck Analytics for Year-<?php echo $year?></caption>
        <thead>
        <tr>
            <th>Truck Registration No.</th>
            <th>Total Used Hours</th>
        </tr>
        </thead>
        <tboady>
            <?php
            if(is_array($records) && count($records) > 0){
                foreach ($records as $record){
                    echo '<tr>';
                    echo "<td>{$record['truck_registration_no']}</td>";
                    echo ($record['total_duration'] != null)? "<td>{$record['total_duration']}</td>":"<td>0</td>";
                    echo '</tr>';
                }
                echo '<tr>';
                echo "<td>Total hours trucks used in year:$year</td>";
                echo "<td>{$total_delivery_duration[0]['total_duration']}</td>";
                echo '</tr>';
            }else{
                echo '<tr>';
                echo "<td colspan='2'>No data to create the truck analystics for year:$year</td>";
                echo '</tr>';
            }
            ?>
        </tboady>
    </table>
</div>
<?php include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/templates/footer.php') ?>
</html>