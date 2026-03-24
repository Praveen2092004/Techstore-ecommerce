<?php
include 'db.php';

// 1. Set the headers to tell the browser it is a file download
header('Content-Type: text/plain');
header('Content-Disposition: attachment; filename="Order_Report_' . date('Y-m-d') . '.txt"');

// 2. Fetch all orders
$sql = "SELECT * FROM orders ORDER BY order_date DESC";
$result = $conn->query($sql);

// 3. Create the Report Content
echo "==========================================\n";
echo "       ECOMMERCE ORDER REPORT             \n";
echo "       Generated on: " . date('Y-m-d H:i:s') . "\n";
echo "==========================================\n\n";

if ($result && $result->num_rows > 0) {
    $grand_total = 0;
    while($row = $result->fetch_assoc()) {
        $subtotal = $row['price'] * $row['quantity'];
        $grand_total += $subtotal;
        
        echo "Order ID: #" . $row['id'] . "\n";
        echo "Product:  " . $row['product_name'] . "\n";
        echo "Quantity: " . $row['quantity'] . "\n";
        echo "Price:    $" . number_format($row['price'], 2) . "\n";
        echo "Subtotal: $" . number_format($subtotal, 2) . "\n";
        echo "Date:     " . $row['order_date'] . "\n";
        echo "------------------------------------------\n";
    }
    echo "\nTOTAL REVENUE: $" . number_format($grand_total, 2) . "\n";
} else {
    echo "No orders found in the database.";
}

exit();
?>