<?php
session_start();
// Admin security check
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Customer Orders</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; margin: 0; padding: 20px; background-color: #f4f7f6; min-height: 100vh; }
        .container { 
            max-width: 1200px; margin: 30px auto; background: white; 
            padding: 30px; border-radius: 15px; border: 1px solid #ddd; 
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1); 
        }
        h1 { text-align: center; color: #2c3e50; margin-top: 10px; }
        
        /* Navigation Bar */
        .admin-nav { 
            display: flex; justify-content: space-between; align-items: center; 
            margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #eee;
        }
        .nav-links a { 
            text-decoration: none; color: #3498db; font-weight: bold; margin-right: 20px; 
            padding: 8px 15px; border-radius: 5px; transition: 0.3s;
        }
        .nav-links a:hover { background: #e8f4fd; }
        .nav-links a.active { background: #3498db; color: white; }

        .stats-container { display: flex; gap: 20px; margin-bottom: 30px; }
        .stat-card { flex: 1; background: #fff; padding: 20px; border-radius: 12px; text-align: center; border: 1px solid #eee; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 0.9em; }
        th { background: #34495e; color: white; padding: 12px; text-align: left; }
        td { padding: 12px; border-bottom: 1px solid #eee; color: #444; vertical-align: top; }
        tr:hover { background: #f9f9f9; }

        .cust-info { font-size: 0.85em; color: #555; line-height: 1.4; }
        .badge { background: #2ecc71; color: white; padding: 3px 8px; border-radius: 10px; font-weight: bold; }
        .pay-method { font-weight: bold; color: #2980b9; text-transform: uppercase; font-size: 0.8em; }
        .delete-btn { background: #e74c3c; color: white; border: none; padding: 6px 10px; cursor: pointer; border-radius: 4px; transition: 0.3s; }
        .delete-btn:hover { background: #c0392b; }
    </style>
</head>
<body>
    <div class="container">
        <div class="admin-nav">
            <div class="nav-links">
                <a href="view_orders.php" class="active">📦 View Orders</a>
                <a href="admin_products.php">🏷️ Manage Products</a>
                <a href="index.php">🏪 Visit Store</a>
            </div>
            <a href="logout.php" style="color:#e74c3c; text-decoration:none; font-weight:bold;">Logout 🚪</a>
        </div>

        <h1>Customer Order History</h1>

        <?php
        $grand_total = 0;
        $total_orders = 0;
        // Fetching orders including the customer details we added
        $sql = "SELECT * FROM orders ORDER BY order_date DESC";
        $result = $conn->query($sql);
        if ($result) { $total_orders = $result->num_rows; }
        ?>

        <div class="stats-container">
            <div class="stat-card"><h4>Total Orders</h4><p><?php echo $total_orders; ?></p></div>
            <div class="stat-card"><h4>Gross Revenue</h4><p id="total-stat">$0.00</p></div>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer & Address</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Payment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($total_orders > 0) {
                    while($row = $result->fetch_assoc()) {
                        $sub = $row['price'] * $row['quantity'];
                        $grand_total += $sub;
                        
                        echo "<tr>
                                <td>#{$row['id']}</td>
                                <td>
                                    <div class='cust-info'>
                                        <strong>" . htmlspecialchars($row['customer_name'] ?? 'N/A') . "</strong><br>
                                        📞 " . htmlspecialchars($row['customer_phone'] ?? 'N/A') . "<br>
                                        📍 " . htmlspecialchars($row['customer_address'] ?? 'N/A') . "
                                    </div>
                                </td>
                                <td>" . htmlspecialchars($row['product_name']) . "</td>
                                <td><span class='badge'>{$row['quantity']}</span></td>
                                <td>$" . number_format($sub, 2) . "</td>
                                <td class='pay-method'>" . ($row['payment_method'] ?? 'COD') . "</td>
                                <td>
                                    <form method='POST' action='delete_order.php'>
                                        <input type='hidden' name='order_id' value='{$row['id']}'>
                                        <button type='submit' class='delete-btn' onclick='return confirm(\"Permanently delete this order record?\")'>Delete</button>
                                    </form>
                                </td>
                              </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align:center;'>No orders found in the database.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div style="text-align:right; font-size:1.5em; margin-top:20px; font-weight:bold; color:#27ae60;">
            Total: $<?php echo number_format($grand_total, 2); ?>
        </div>
        
        <script>
            // Update the stat card with the final calculated total
            document.getElementById('total-stat').innerText = "$<?php echo number_format($grand_total, 2); ?>";
        </script>
    </div>
</body>
</html>