<?php
require_once '../config/db.php';
check_auth();

// Fetch filter values
$status_filter = $_GET['status'] ?? '';

$sql = "SELECT orders.*, customers.name as customer_name FROM orders JOIN customers ON orders.customer_id = customers.id";
if ($status_filter) {
    $sql .= " WHERE orders.status = '" . $conn->real_escape_string($status_filter) . "'";
}
$sql .= " ORDER BY orders.delivery_date ASC";

$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Orders - StitchCraft Tailors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fdfbf7; color: #4a3b32; }
        .navbar { background-color: #8b7355; }
        .navbar-brand, .nav-link { color: #fff !important; }
        .btn-primary { background-color: #8b7355; border-color: #8b7355; }
        .badge-pending { background-color: #f0ad4e; }
        .badge-stitching { background-color: #17a2b8; }
        .badge-ready { background-color: #5cb85c; }
        .badge-delivered { background-color: #d9534f; }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-lg mb-4">
  <div class="container">
    <a class="navbar-brand" href="../public/dashboard.php">StitchCraft Tailors</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="../customers/customers.php">Customers</a></li>
        <li class="nav-item"><a class="nav-link" href="orders.php">Orders</a></li>
      </ul>
      <a href="../public/logout.php" class="btn btn-sm btn-outline-light">Logout</a>
    </div>
  </div>
</nav>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Orders List</h2>
        <a href="create_order.php" class="btn btn-primary">+ New Order</a>
    </div>
    
    <div class="mb-3">
        Filter: 
        <a href="orders.php" class="btn btn-sm <?= !$status_filter ? 'btn-secondary' : 'btn-outline-secondary' ?>">All</a>
        <a href="orders.php?status=Pending" class="btn btn-sm <?= $status_filter=='Pending' ? 'btn-secondary' : 'btn-outline-secondary' ?>">Pending</a>
        <a href="orders.php?status=In Stitching" class="btn btn-sm <?= $status_filter=='In Stitching' ? 'btn-secondary' : 'btn-outline-secondary' ?>">In Stitching</a>
        <a href="orders.php?status=Ready" class="btn btn-sm <?= $status_filter=='Ready' ? 'btn-secondary' : 'btn-outline-secondary' ?>">Ready</a>
        <a href="orders.php?status=Delivered" class="btn btn-sm <?= $status_filter=='Delivered' ? 'btn-secondary' : 'btn-outline-secondary' ?>">Delivered</a>
    </div>

    <table class="table table-bordered bg-white">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer</th>
                <th>Dress Type</th>
                <th>Delivery Date</th>
                <th>Price</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td>#<?= sprintf('%04d', $row['id']) ?></td>
                <td><?= htmlspecialchars($row['customer_name']) ?></td>
                <td><?= htmlspecialchars($row['dress_type']) ?></td>
                <td><?= date('d M Y', strtotime($row['delivery_date'])) ?></td>
                <td>$<?= number_format($row['price'], 2) ?></td>
                <td>
                    <?php
                        $badge = 'bg-secondary';
                        if($row['status']=='Pending') $badge='badge-pending';
                        if($row['status']=='In Stitching') $badge='badge-stitching';
                        if($row['status']=='Ready') $badge='badge-ready';
                        if($row['status']=='Delivered') $badge='badge-delivered';
                    ?>
                    <span class="badge <?= $badge ?>"><?= $row['status'] ?></span>
                </td>
                <td>
                    <a href="order_detail.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-info text-white">View/Update</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>