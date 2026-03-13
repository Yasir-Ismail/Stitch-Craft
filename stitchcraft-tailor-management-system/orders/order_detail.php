<?php
require_once '../config/db.php';
check_auth();

$order_id = $_GET['id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['status_update'])) {
        $new_status = $_POST['status'];
        $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $order_id);
        $stmt->execute();
        header("Location: order_detail.php?id=$order_id&success=1");
        exit;
    }
}

$stmt = $conn->prepare("SELECT o.*, c.name, c.phone, c.address FROM orders o JOIN customers c ON o.customer_id = c.id WHERE o.id = ?");
$stmt->bind_param("i", $order_id);
$stmt->execute();
$order = $stmt->get_result()->fetch_assoc();

if (!$order) {
    die("Order not found!");
}

$stmt = $conn->prepare("SELECT * FROM measurements WHERE customer_id = ?");
$stmt->bind_param("i", $order['customer_id']);
$stmt->execute();
$meas = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Detail - StitchCraft Tailors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fdfbf7; color: #4a3b32; }
        .navbar { background-color: #8b7355; }
        .navbar-brand, .nav-link { color: #fff !important; }
        .btn-primary { background-color: #8b7355; border-color: #8b7355; }
        .card { border-color: #e0d8c8; }
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
        <h2>Order #<?= sprintf('%04d', $order['id']) ?> Details</h2>
        <a href="orders.php" class="btn btn-outline-secondary">Back to Orders</a>
    </div>

    <div class="row">
        <!-- Status Update -->
        <div class="col-md-12 mb-4">
            <div class="card p-3">
                <form method="POST" class="d-flex align-items-center">
                    <input type="hidden" name="status_update" value="1">
                    <label class="me-3 fw-bold">Current Status:</label>
                    <select name="status" class="form-select w-auto me-3">
                        <option <?= $order['status']=='Pending' ? 'selected':'' ?>>Pending</option>
                        <option <?= $order['status']=='In Stitching' ? 'selected':'' ?>>In Stitching</option>
                        <option <?= $order['status']=='Ready' ? 'selected':'' ?>>Ready</option>
                        <option <?= $order['status']=='Delivered' ? 'selected':'' ?>>Delivered</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Update Status</button>
                    <?php if(isset($_GET['success'])): ?><span class="ms-3 text-success">Updated!</span><?php endif; ?>
                </form>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100 p-4">
                <h4>Order Information</h4>
                <ul class="list-group list-group-flush mt-3">
                    <li class="list-group-item bg-transparent"><strong>Dress Type:</strong> <?= htmlspecialchars($order['dress_type']) ?></li>
                    <li class="list-group-item bg-transparent"><strong>Fabric Details:</strong> <?= htmlspecialchars($order['fabric_details']) ?></li>
                    <li class="list-group-item bg-transparent"><strong>Delivery Date:</strong> <?= date('d M Y', strtotime($order['delivery_date'])) ?></li>
                    <li class="list-group-item bg-transparent"><strong>Total Price:</strong> $<?= number_format($order['price'], 2) ?></li>
                </ul>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card h-100 p-4">
                <h4>Customer Details</h4>
                <ul class="list-group list-group-flush mt-3">
                    <li class="list-group-item bg-transparent"><strong>Name:</strong> <?= htmlspecialchars($order['name']) ?></li>
                    <li class="list-group-item bg-transparent"><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></li>
                    <li class="list-group-item bg-transparent"><strong>Address:</strong> <?= htmlspecialchars($order['address']) ?></li>
                </ul>
                <div class="mt-3">
                    <a href="../measurements/edit_measurement.php?customer_id=<?= $order['customer_id'] ?>" class="btn btn-sm btn-outline-primary">View/Edit Measurements</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-12 mb-4">
            <div class="card p-4">
                <h4>Saved Measurements</h4>
                <?php if ($meas): ?>
                <div class="row mt-3">
                    <div class="col-md-6">
                        <strong>Men's</strong><br>
                        Chest: <?= $meas['chest'] ?? 'N/A' ?> | Shoulder: <?= $meas['shoulder'] ?? 'N/A' ?> | Sleeve: <?= $meas['sleeve'] ?? 'N/A' ?> <br>
                        Shirt Length: <?= $meas['shirt_length'] ?? 'N/A' ?> | Waist: <?= $meas['waist'] ?? 'N/A' ?> | Shalwar Length: <?= $meas['shalwar_length'] ?? 'N/A' ?>
                    </div>
                    <div class="col-md-6">
                        <strong>Women's</strong><br>
                        Bust: <?= $meas['bust'] ?? 'N/A' ?> | Hip: <?= $meas['hip'] ?? 'N/A' ?> <br>
                        Dress Length: <?= $meas['dress_length'] ?? 'N/A' ?>
                    </div>
                </div>
                <?php else: ?>
                    <p class="text-danger mt-3">No measurements saved for this customer.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>