<?php
// Since user requirements only state add and edit, I will merge both functionalities logically into edit_measurement.php to handle them. Just redirecting add_measurement to edit_measurement.
header("Location: edit_measurement.php?customer_id=" . ($_GET['customer_id'] ?? ''));
exit;
?>