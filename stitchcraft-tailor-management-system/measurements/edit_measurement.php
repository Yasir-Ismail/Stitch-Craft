<?php
require_once '../config/db.php';
check_auth();

$customer_id = $_GET['customer_id'] ?? 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $chest = $_POST['chest'] ?: null;
    $shoulder = $_POST['shoulder'] ?: null;
    $sleeve = $_POST['sleeve'] ?: null;
    $shirt_length = $_POST['shirt_length'] ?: null;
    $waist = $_POST['waist'] ?: null;
    $shalwar_length = $_POST['shalwar_length'] ?: null;
    $bust = $_POST['bust'] ?: null;
    $hip = $_POST['hip'] ?: null;
    $dress_length = $_POST['dress_length'] ?: null;

    // Insert or Update
    $stmt = $conn->prepare("SELECT id FROM measurements WHERE customer_id = ?");
    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt = $conn->prepare("UPDATE measurements SET chest=?, shoulder=?, sleeve=?, shirt_length=?, waist=?, shalwar_length=?, bust=?, hip=?, dress_length=? WHERE customer_id=?");
        $stmt->bind_param("dddddddddi", $chest, $shoulder, $sleeve, $shirt_length, $waist, $shalwar_length, $bust, $hip, $dress_length, $customer_id);
    } else {
        $stmt = $conn->prepare("INSERT INTO measurements (chest, shoulder, sleeve, shirt_length, waist, shalwar_length, bust, hip, dress_length, customer_id) VALUES (?,?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param("dddddddddi", $chest, $shoulder, $sleeve, $shirt_length, $waist, $shalwar_length, $bust, $hip, $dress_length, $customer_id);
    }
    $stmt->execute();
    header("Location: ../customers/customers.php");
    exit;
}

$stmt = $conn->prepare("SELECT * FROM measurements WHERE customer_id = ?");
$stmt->bind_param("i", $customer_id);
$stmt->execute();
$meas = $stmt->get_result()->fetch_assoc();
if (!$meas) {
    // defaults
    $meas = ['chest'=>'', 'shoulder'=>'', 'sleeve'=>'', 'shirt_length'=>'', 'waist'=>'', 'shalwar_length'=>'', 'bust'=>'', 'hip'=>'', 'dress_length'=>''];
}

$stmt2 = $conn->prepare("SELECT name FROM customers WHERE id = ?");
$stmt2->bind_param("i", $customer_id);
$stmt2->execute();
$customer_name = $stmt2->get_result()->fetch_assoc()['name'] ?? 'Unknown';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Measurements - StitchCraft Tailors</title>
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
        <li class="nav-item"><a class="nav-link" href="../orders/orders.php">Orders</a></li>
      </ul>
      <a href="../public/logout.php" class="btn btn-sm btn-outline-light">Logout</a>
    </div>
  </div>
</nav>

<div class="container">
    <h2>Measurements for <?= htmlspecialchars($customer_name) ?></h2>
    
    <form method="POST" class="bg-white p-4 border rounded mt-4">
        <div class="row">
            <div class="col-md-6">
                <h4 class="mb-3">Men's Measurements</h4>
                <div class="mb-2"><label>Chest</label><input type="number" step="0.01" name="chest" class="form-control" value="<?= $meas['chest'] ?>"></div>
                <div class="mb-2"><label>Shoulder</label><input type="number" step="0.01" name="shoulder" class="form-control" value="<?= $meas['shoulder'] ?>"></div>
                <div class="mb-2"><label>Sleeve</label><input type="number" step="0.01" name="sleeve" class="form-control" value="<?= $meas['sleeve'] ?>"></div>
                <div class="mb-2"><label>Shirt Length</label><input type="number" step="0.01" name="shirt_length" class="form-control" value="<?= $meas['shirt_length'] ?>"></div>
                <div class="mb-2"><label>Waist</label><input type="number" step="0.01" name="waist" class="form-control" value="<?= $meas['waist'] ?>"></div>
                <div class="mb-2"><label>Shalwar Length</label><input type="number" step="0.01" name="shalwar_length" class="form-control" value="<?= $meas['shalwar_length'] ?>"></div>
            </div>
            
            <div class="col-md-6">
                <h4 class="mb-3">Women's Measurements</h4>
                <div class="mb-2"><label>Bust</label><input type="number" step="0.01" name="bust" class="form-control" value="<?= $meas['bust'] ?>"></div>
                <div class="mb-2"><label>Hip</label><input type="number" step="0.01" name="hip" class="form-control" value="<?= $meas['hip'] ?>"></div>
                <div class="mb-2"><label>Dress Length</label><input type="number" step="0.01" name="dress_length" class="form-control" value="<?= $meas['dress_length'] ?>"></div>
                <small class="text-muted d-block mt-3">Note: Feel free to leave unused fields empty.</small>
            </div>
        </div>
        
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Save Measurements</button>
            <a href="../customers/customers.php" class="btn btn-outline-secondary">Go Back</a>
        </div>
    </form>
</div>
</body>
</html>