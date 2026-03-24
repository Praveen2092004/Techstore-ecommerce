<?php
include 'db.php';
$id = $_GET['id'];
$conn->query("DELETE FROM cart WHERE id = $id");
header("Location: view_cart.php");
?>