<html>
    <?php include ('config/db_connect.php')?>
    <?php include ('templates/header.php') ?>

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
                        <span class="card-title">Manage Customers</span>
                        <p>Add new customers and update the information of existing customers</p>
                    </div>
                    <div class="card-action center">
                        <a href="manage_customers">Checkout</a>
                    </div>
                </div>
            </div>
            <div class="col s12 l4">
                <div class="card small">
                    <div class="card-content">
                        <span class="card-title">Order</span>
                        <p>Place an order for an customer</p>
                    </div>
                    <div class="card-action center">
                        <a href="#">Checkout</a>
                    </div>
                </div>
            </div>
            <div class="col s12 l4">
                <div class="card small">
                    <div class="card-content">
                        <span class="card-title">Manage Products</span>
                        <p>Add new products and update the information of existing products</p>
                    </div>
                    <div class="card-action center">
                        <a href="#">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col s12 l4 offset-l2">
                <div class="card small">
                    <div class="card-content">
                        <span class="card-title">Add a Store</span>
                        <p>Add new store to the supply chain</p>
                    </div>
                    <div class="card-action center">
                        <a href="#">Checkout</a>
                    </div>
                </div>
            </div>
            <div class="col s12 l4">
                <div class="card small">
                    <div class="card-content">
                        <span class="card-title">Manage Stores</span>
                        <p>Add and update trucks, drivers and driver assistants to store. Manage orders by scheduling the orders.</p>
                    </div>
                    <div class="card-action center">
                        <a href="#">Checkout</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include ('templates/footer.php') ?>
</html>