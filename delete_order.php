<?php
include 'db.php';

if (isset($_POST['order_id'])) {
    $order_id = $_POST['order_id'];
    
    // Deletes the row where the ID matches
    $sql = "DELETE FROM orders WHERE id = $order_id";
    
    if ($conn->query($sql) === TRUE) {
        header("Location: view_orders.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>