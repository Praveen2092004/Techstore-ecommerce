<?php
include 'db.php';
$id = $_GET['id'];
$action = $_GET['action'];

if ($action == 'plus') {
    $conn->query("UPDATE cart SET quantity = quantity + 1 WHERE id = $id");
} elseif ($action == 'minus') {
    // Prevent quantity from going below 1
    $conn->query("UPDATE cart SET quantity = quantity - 1 WHERE id = $id AND quantity > 1");
}
header("Location: view_cart.php");
?>