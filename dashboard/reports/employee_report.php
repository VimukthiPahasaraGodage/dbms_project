<?php
    include($_SERVER['DOCUMENT_ROOT'] . '/dbms_project/dashboard/config/db_connect.php');
    require($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/vendor/autoload.php');
    use Rakit\Validation\Validator;

    $validation_errors = null;
    $year = '';
    $driver_records = null;
    $driver_assistant_records = null;

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
            $sql = 'SELECT NIC_driver, name, SUM(hours) AS total_hours
                    FROM driver_analytics
                    WHERE date >= "'.$start_date.'" AND date <= "'.$end_date.'"
                    GROUP BY NIC_driver
                    ORDER BY NIC_driver;';
            $driver_records = mysqli_fetch_all(mysqli_query($connection, $sql), MYSQLI_ASSOC);
            $sql = 'SELECT NIC_driver_assistant, name, SUM(hours) total_hours
                    FROM driver_assistant_analytics
                    WHERE date >= "'.$start_date.'" AND date <= "'.$end_date.'"
                    GROUP BY NIC_driver_assistant
                    ORDER BY NIC_driver_assistant;';
            $driver_assistant_records = mysqli_fetch_all(mysqli_query($connection, $sql), MYSQLI_ASSOC);
        } else {
            $validation_errors = $validation->errors();
        }
    }?>
<html>
    <?php include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/templates/header.php') ?>

    <nav class="nav-wrapper indigo">
        <div class="container">
            <a href="index.php" class="brand-logo">Company A - Employee Analytics</a>
        </div>
    </nav>
    <div class="container">
        <form action="employee_report.php" method="POST">
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
    <div class="report_driver_assistant">
        <table class="responsive-table stripped centered highlight">
            <caption>Driver Assistant Analytics for Year-<?php echo $year?></caption>
            <thead>
            <tr>
                <th>NIC</th>
                <th>Driver Assistant Name</th>
                <th>Total Hours Worked</th>
            </tr>
            </thead>
            <tboady>
                <?php
                if(is_array($driver_assistant_records) && count($driver_assistant_records) > 0){
                    foreach ($driver_assistant_records as $record){
                        echo '<tr>';
                        echo "<td>{$record['NIC_driver_assistant']}</td>";
                        echo "<td>{$record['name']}</td>";
                        echo "<td>{$record['total_hours']}</td>";
                        echo '</tr>';
                    }
                }else{
                    echo '<tr>';
                    echo "<td colspan='5'>No data to create the driver assistant analystics for year:$year</td>";
                    echo '</tr>';
                }
                ?>
            </tboady>
        </table>
    </div>
    <div class="report_driver">
        <table class="responsive-table stripped centered highlight">
            <caption>Driver Analytics for Year-<?php echo $year?></caption>
            <thead>
            <tr>
                <th>NIC</th>
                <th>Driver Name</th>
                <th>Total Hours Worked</th>
            </tr>
            </thead>
            <tboady>
                <?php
                if(is_array($driver_records) && count($driver_records) > 0){
                    foreach ($driver_records as $record){
                        echo '<tr>';
                        echo "<td>{$record['NIC_driver']}</td>";
                        echo "<td>{$record['name']}</td>";
                        echo "<td>{$record['total_hours']}</td>";
                        echo '</tr>';
                    }
                }else{
                    echo '<tr>';
                    echo "<td colspan='5'>No data to create the driver analystics for year:$year</td>";
                    echo '</tr>';
                }
                ?>
            </tboady>
        </table>
    </div>
    <?php include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/templates/footer.php') ?>
</html>
