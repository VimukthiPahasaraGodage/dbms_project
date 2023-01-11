<html>
    <?php include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/templates/header.php') ?>

    <nav class="nav-wrapper indigo">
        <div class="container">
            <a href="index.php" class="brand-logo">Company A</a>
        </div>
    </nav>

    <div class="container center">
        <div class="row">
            <div class="col s12 l4">
                <div class="card small">
                    <div class="card-content">
                        <span class="card-title">Quarterly Sales Report</span>
                        <p></p>
                    </div>
                    <div class="card-action center">
                        <a href="quarterly_sales_report.php">Generate</a>
                    </div>
                </div>
            </div>
            <div class="col s12 l4">
                <div class="card small">
                    <div class="card-content">
                        <span class="card-title">Product Analytics</span>
                        <p></p>
                    </div>
                    <div class="card-action center">
                        <a href="product_report.php">Generate</a>
                    </div>
                </div>
            </div>
            <div class="col s12 l4">
                <div class="card small">
                    <div class="card-content">
                        <span class="card-title">City & Route Analytics</span>
                        <p></p>
                    </div>
                    <div class="card-action center">
                        <a href="sales_report_on_cities_and_routes.php">Generate</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 l4">
                <div class="card small">
                    <div class="card-content">
                        <span class="card-title">Customer Analytics</span>
                        <p></p>
                    </div>
                    <div class="card-action center">
                        <a href="customer_report.php">Generate</a>
                    </div>
                </div>
            </div>
            <div class="col s12 l4">
                <div class="card small">
                    <div class="card-content">
                        <span class="card-title">Employee Analytics</span>
                        <p></p>
                    </div>
                    <div class="card-action center">
                        <a href="employee_report.php">Generate</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include ($_SERVER['DOCUMENT_ROOT'].'/dbms_project/dashboard/templates/footer.php') ?>
</html>
