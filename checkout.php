<?php
include 'db.php';
session_start();

// 1. Fetch items from the cart to move them to the orders table
$cart_query = "SELECT products.name, products.price, cart.quantity 
               FROM cart 
               JOIN products ON cart.product_id = products.id";
$cart_items = $conn->query($cart_query);

echo "<div style='text-align:center; margin-top:50px; font-family:sans-serif; color: #2c3e50;'>";

if ($cart_items && $cart_items->num_rows > 0) {
    while($item = $cart_items->fetch_assoc()) {
        // Use real_escape_string to handle special characters in product names
        $p_name = $conn->real_escape_string($item['name']);
        $p_price = $item['price'];
        $p_qty = $item['quantity'];

        // 2. THE FIX: Actually insert the data into the 'orders' table
        $insert_sql = "INSERT INTO orders (product_name, price, quantity) 
                       VALUES ('$p_name', '$p_price', '$p_qty')";
        
        if (!$conn->query($insert_sql)) {
            die("Error saving order: " . $conn->error);
        }
    }

    // 3. Clear the cart table now that the order is saved
    $conn->query("TRUNCATE TABLE cart");
    
    echo "<h1>✅ Order Placed Successfully!</h1>";
    echo "<p>Redirecting you to your Order History in 3 seconds...</p>";
    echo "<a href='view_orders.php' style='color:#3498db; font-weight:bold;'>Click here if you are not redirected</a>";

    // 4. AUTOMATIC REDIRECT: This pushes the browser to the next page
    header("refresh:3; url=view_orders.php");

} else {
    echo "<h1>Your cart is empty!</h1>";
    echo "<a href='index.php' style='color:#3498db;'>Go back to Shopping</a>";
}
echo "</div>";
?>