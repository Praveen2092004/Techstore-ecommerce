<?php include 'db.php'; ?>
<h1>Customer Orders</h1>
<table border="1" cellpadding="10">
    <tr>
        <th>Order ID</th>
        <th>Product</th>
        <th>Quantity</th>
        <th>Price</th>
        <th>Date</th>
    </tr>
    <?php
    $result = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['product_name']}</td>
                <td>{$row['quantity']}</td>
                <td>${$row['price']}</td>
                <td>{$row['order_date']}</td>
              </tr>";
    }
    ?>
</table>