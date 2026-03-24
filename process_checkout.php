<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pay_method = $_POST['payment_method'];
    $c_name = $conn->real_escape_string($_POST['customer_name']);
    $c_phone = $conn->real_escape_string($_POST['customer_phone']);
    $c_address = $conn->real_escape_string($_POST['customer_address']);

    $cart_items = $conn->query("SELECT products.name, products.price, cart.quantity FROM cart JOIN products ON cart.product_id = products.id");

    while($item = $cart_items->fetch_assoc()) {
        $p_name = $item['name'];
        $p_price = $item['price'];
        $p_qty = $item['quantity'];

        $conn->query("INSERT INTO orders (product_name, price, quantity, customer_name, customer_phone, customer_address, payment_method) 
                      VALUES ('$p_name', '$p_price', '$p_qty', '$c_name', '$c_phone', '$c_address', '$pay_method')");
    }

    $conn->query("TRUNCATE TABLE cart");
    header("refresh:3; url=view_orders.php");
    echo "<div style='text-align:center; margin-top:100px;'><h1>Order Placed!</h1><p>Moving to history...</p></div>";
}
?>