<?php
require_once '../config/db.php';
check_auth();

$result = $conn->query("SELECT * FROM customers ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customers - StitchCraft Tailors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fdfbf7; color: #4a3b32; }
        .navbar { background-color: #8b7355; }
        .navbar-brand, .nav-link { color: #fff !important; }
        .btn-primary { background-color: #8b7355; border-color: #8b7355; }
        .btn-primary:hover { background-color: #6e5c44; border-color: #6e5c44; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg mb-4">
  <div class="container">
    <a class="navbar-brand" href="../public/dashboard.php">StitchCraft Tailors</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="customers.php">Customers</a></li>
        <li class="nav-item"><a class="nav-link" href="../orders/orders.php">Orders</a></li>
      </ul>
      <a href="../public/logout.php" class="btn btn-sm btn-outline-light">Logout</a>
    </div>
  </div>
</nav>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Customers</h2>
        <a href="add_customer.php" class="btn btn-primary">+ Add Customer</a>
    </div>
    
    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['phone']) ?></td>
                <td><?= htmlspecialchars($row['address']) ?></td>
                <td>
                    <a href="../measurements/edit_measurement.php?customer_id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Measurements</a>
                    <a href="../orders/create_order.php?customer_id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-success">New Order</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>