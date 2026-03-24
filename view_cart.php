<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart - TechStore</title>
    <style>
        /* Stable Professional Theme */
        body { 
            font-family: 'Segoe UI', Tahoma, sans-serif; 
            padding: 20px; 
            background-color: #f4f7f6; /* Stable light gray background */
            margin: 0;
        }
        
        .cart-container { 
            max-width: 1000px; 
            margin: 50px auto; 
            background: white; 
            padding: 40px; 
            border-radius: 20px; 
            box-shadow: 0 8px 32px rgba(0,0,0,0.1); 
        }

        h1 { color: #2c3e50; margin-bottom: 30px; border-bottom: 2px solid #eee; padding-bottom: 10px; }

        table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        th { text-align: left; padding: 15px; background-color: #34495e; color: white; border-radius: 4px; }
        td { padding: 15px; border-bottom: 1px solid #eee; vertical-align: middle; color: #444; }
        
        /* Product Info Styling */
        .product-info { display: flex; align-items: center; gap: 15px; }
        .product-info img { 
            width: 70px; height: 70px; object-fit: contain; 
            border-radius: 8px; background: #fafafa; border: 1px solid #eee; 
        }

        /* Quantity Controls */
        .qty-controls { display: flex; align-items: center; gap: 12px; }
        .qty-btn { 
            background: #f1f1f1; border: 1px solid #ddd; padding: 5px 12px; 
            border-radius: 6px; cursor: pointer; text-decoration: none; 
            color: #333; font-weight: bold; transition: 0.3s;
        }
        .qty-btn:hover { background: #e2e2e2; border-color: #ccc; }

        .delete-link { color: #e74c3c; text-decoration: none; font-weight: bold; font-size: 0.9em; transition: 0.3s; }
        .delete-link:hover { color: #c0392b; text-decoration: underline; }

        /* Totals and Buttons */
        .cart-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 30px; border-top: 2px solid #eee; padding-top: 20px; }
        .total { font-size: 1.8em; font-weight: bold; color: #27ae60; }
        
        .btn { display: inline-block; padding: 15px 35px; border-radius: 50px; text-decoration: none; font-weight: bold; transition: 0.3s; }
        .continue-btn { color: #3498db; }
        .continue-btn:hover { color: #2980b9; }
        
        .checkout-btn { 
            background: #27ae60; color: white; box-shadow: 0 4px 15px rgba(39, 174, 96, 0.3); 
        }
        .checkout-btn:hover { background: #219150; transform: translateY(-2px); }
    </style>
</head>
<body>
    <div class="cart-container">
        <h1>🛒 Your Shopping Cart</h1>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'db.php';
                $grand_total = 0;

                // Safety Check: Verify table exists
                $check = $conn->query("SHOW TABLES LIKE 'cart'");
                if ($check->num_rows > 0) {
                    // Fetch cart details and images from products table
                    $query = "SELECT cart.id, products.id as p_id, products.name, products.price, products.image, cart.quantity 
                              FROM cart 
                              JOIN products ON cart.product_id = products.id";
                    $result = $conn->query($query);

                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            $subtotal = $row['price'] * $row['quantity'];
                            $grand_total += $subtotal;
                            
                            $imagePath = 'images/' . $row['image'];
                            // Check if image exists in folder; otherwise use default
                            $imageFile = (!empty($row['image']) && file_exists($imagePath)) ? $imagePath : 'images/no-image.png';

                            echo "<tr>
                                    <td>
                                        <div class='product-info'>
                                            <img src='$imageFile' alt='".htmlspecialchars($row['name'])."'>
                                            <strong>" . htmlspecialchars($row['name']) . "</strong>
                                        </div>
                                    </td>
                                    <td>$" . number_format($row['price'], 2) . "</td>
                                    <td>
                                        <div class='qty-controls'>
                                            <a href='update_qty.php?id={$row['id']}&action=minus' class='qty-btn'>-</a>
                                            <span>" . $row['quantity'] . "</span>
                                            <a href='update_qty.php?id={$row['id']}&action=plus' class='qty-btn'>+</a>
                                        </div>
                                    </td>
                                    <td>$" . number_format($subtotal, 2) . "</td>
                                    <td>
                                        <a href='remove_item.php?id={$row['id']}' class='delete-link' onclick='return confirm(\"Remove this item?\")'>Delete</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5' style='text-align:center; padding: 40px; color: #7f8c8d;'>Your cart is empty.</td></tr>";
                    }
                }
                ?>
            </tbody>
        </table>

        <div class="cart-footer">
            <a href="index.php" class="continue-btn">← Continue Shopping</a>
            <div>
                <span style="font-size: 1.2em; color: #7f8c8d; margin-right: 15px;">Grand Total:</span>
                <span class="total">$<?php echo number_format($grand_total, 2); ?></span>
            </div>
        </div>
        
        <div style="text-align: right; margin-top: 30px;">
            <a href="payment.php" class="btn checkout-btn">Proceed to Payment Method →</a>
        </div>
    </div>
</body>
</html>