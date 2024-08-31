<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>miniPOS</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        form label {
            font-weight: bold;
            color: ;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="index.php">miniPOS</a>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=products">สินค้า</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="index.php?page=sales">ขาย</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>
<div class="container">
    <?php
    $page = $_GET['page'] ?? false;
    if ($page === 'products') {
        include 'products.php';
        $script = 'product_script.php';
    } elseif ($page === 'sales') {
        include 'sales.php';
        $script = 'sale_script.php';
    } else {
        echo '<h2>Welcome</h2><p>Select a page from the menu.</p>';
        $script = false;
    }
    ?>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<?php
if ($script) {
    include "script/$script";
} ?>
</body>
</html>

