<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['product_id'])) {
    $p_id = (int)$_POST['product_id'];

    // Safety check to ensure the table is healthy
    $check = $conn->query("SHOW TABLES LIKE 'cart'");
    if ($check->num_rows > 0) {
        $res = $conn->query("SELECT * FROM cart WHERE product_id = $p_id");
        
        if ($res && $res->num_rows > 0) {
            $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE product_id = $p_id");
        } else {
            $conn->query("INSERT INTO cart (product_id, quantity) VALUES ($p_id, 1)");
        }

        // CHANGE THIS LINE: Redirect back to the store instead of the cart
        header("Location: index.php?message=Item Added");
    } else {
        die("Error: Cart table not found.");
    }
}
?>