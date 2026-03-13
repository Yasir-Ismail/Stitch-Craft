<?php
require_once '../config/db.php';
check_auth();

$customer_id = $_GET['customer_id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cust_id = $_POST['customer_id'];
    $dress_type = $_POST['dress_type'];
    $fabric_details = $_POST['fabric_details'];
    $delivery_date = $_POST['delivery_date'];
    $price = $_POST['price'];

    $stmt = $conn->prepare("INSERT INTO orders (customer_id, dress_type, fabric_details, delivery_date, price) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssd", $cust_id, $dress_type, $fabric_details, $delivery_date, $price);
    
    if ($stmt->execute()) {
        header("Location: orders.php");
        exit;
    }
}

$customers = $conn->query("SELECT id, name FROM customers ORDER BY name ASC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Order - StitchCraft Tailors</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #fdfbf7; color: #4a3b32; }
        .navbar { background-color: #8b7355; }
        .navbar-brand, .nav-link { color: #fff !important; }
        .btn-primary { background-color: #8b7355; border-color: #8b7355; }
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

<div class="container" style="max-width: 600px;">
    <h2>Create New Order</h2>
    
    <form method="POST" class="bg-white p-4 border rounded mt-4">
        <div class="mb-3">
            <label>Customer</label>
            <select name="customer_id" class="form-control" required>
                <option value="">-- Select Customer --</option>
                <?php while($c = $customers->fetch_assoc()): ?>
                <option value="<?= $c['id'] ?>" <?= $customer_id == $c['id'] ? 'selected' : '' ?>><?= htmlspecialchars($c['name']) ?></option>
                <?php endwhile; ?>
            </select>
            <small class="text-muted"><a href="../customers/add_customer.php">Add a new customer?</a></small>
        </div>
        
        <div class="mb-3">
            <label>Dress Type</label>
            <select name="dress_type" class="form-control" required>
                <option value="Shalwar Kameez">Shalwar Kameez</option>
                <option value="Suit">Suit</option>
                <option value="Kurta">Kurta</option>
                <option value="Wedding Dress">Wedding Dress</option>
                <option value="Custom">Custom</option>
            </select>
        </div>
        
        <div class="mb-3">
            <label>Fabric & Special Instructions</label>
            <textarea name="fabric_details" class="form-control" rows="3"></textarea>
        </div>
        
        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Delivery Date</label>
                <input type="date" name="delivery_date" class="form-control" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Total Price</label>
                <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" step="0.01" name="price" class="form-control" required>
                </div>
            </div>
        </div>
        
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Create Order</button>
            <a href="orders.php" class="btn btn-outline-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>