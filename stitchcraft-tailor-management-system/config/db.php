<?php
session_start();
$host = '127.0.0.1';
$db = 'stitchcraft';
$user = 'root';
$pass = '';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $conn = new mysqli($host, $user, $pass, $db);
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}

function check_auth() {
    if (!isset($_SESSION['admin_id'])) {
        header("Location: /stitchcraft-tailor-management-system/public/login.php");
        exit;
    }
}
?>