<?php
include 'db.php';

// Check if the database connection is healthy
if ($conn && !$conn->connect_error) {
    // This command empties the table and resets the Order ID counter to 1
    if ($conn->query("TRUNCATE TABLE orders")) {
        header("Location: view_orders.php?message=History Cleared");
    } else {
        echo "Error clearing orders: " . $conn->error;
    }
} else {
    echo "Database connection failed.";
}
?>