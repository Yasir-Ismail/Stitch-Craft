<?php
require_once '../config/db.php';
check_auth();

// Fetch stats
$total_customers = $conn->query("SELECT count(*) as count FROM customers")->fetch_assoc()['count'];
$total_orders = $conn->query("SELECT count(*) as count FROM orders")->fetch_assoc()['count'];
$pending = $conn->query("SELECT count(*) as count FROM orders WHERE status='Pending'")->fetch_assoc()['count'];
$in_stitching = $conn->query("SELECT count(*) as count FROM orders WHERE status='In Stitching'")->fetch_assoc()['count'];
$ready = $conn->query("SELECT count(*) as count FROM orders WHERE status='Ready'")->fetch_assoc()['count'];
$today_deliveries = $conn->query("SELECT count(*) as count FROM orders WHERE delivery_date = CURDATE()")->fetch_assoc()['count'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - StitchCraft Tailors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fdfbf7; color: #4a3b32; }
        .navbar { background-color: #8b7355; }
        .navbar-brand, .nav-link { color: #fff !important; }
        .card { background-color: #fff; border: 1px solid #e0d8c8; color: #4a3b32; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg mb-4">
  <div class="container">
    <a class="navbar-brand" href="dashboard.php">StitchCraft Tailors</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="../customers/customers.php">Customers</a></li>
        <li class="nav-item"><a class="nav-link" href="../orders/orders.php">Orders</a></li>
      </ul>
      <a href="logout.php" class="btn btn-sm btn-outline-light">Logout</a>
    </div>
  </div>
</nav>

<div class="container">
    <h2 class="mb-4">Dashboard</h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <h5>Total Customers</h5>
                <h2><?= $total_customers ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <h5>Total Orders</h5>
                <h2><?= $total_orders ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <h5>Pending Orders</h5>
                <h2><?= $pending ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <h5>In Stitching</h5>
                <h2><?= $in_stitching ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <h5>Ready Orders</h5>
                <h2><?= $ready ?></h2>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card p-4 text-center">
                <h5>Today's Deliveries</h5>
                <h2><?= $today_deliveries ?></h2>
            </div>
        </div>
    </div>
</div>
</body>
</html>