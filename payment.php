<?php
session_start();
include 'db.php';

$cart_check = $conn->query("SELECT * FROM cart");
if (!$cart_check || $cart_check->num_rows == 0) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Method - TechStore</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .container { 
            max-width: 600px; margin: 50px auto; background: white; 
            padding: 40px; border-radius: 20px; box-shadow: 0 8px 32px rgba(0,0,0,0.1); 
        }
        h2 { text-align: center; color: #2c3e50; margin-bottom: 30px; }
        .payment-option {
            border: 2px solid #eee; border-radius: 12px; padding: 20px; margin-bottom: 15px;
            display: flex; align-items: center; cursor: pointer; transition: 0.3s;
        }
        .payment-option:hover { border-color: #3498db; background: #f9f9f9; }
        input[type="radio"] { margin-right: 15px; transform: scale(1.2); }
        .btn-confirm {
            width: 100%; background: #27ae60; color: white; border: none;
            padding: 15px; border-radius: 10px; font-weight: bold; font-size: 1.1em;
            cursor: pointer; margin-top: 20px; transition: 0.3s;
        }
        .btn-confirm:hover { background: #219150; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Select Payment Method</h2>
        <form action="customer_details.php" method="POST">
            <label class="payment-option">
                <input type="radio" name="payment_method" value="COD" checked>
                <div>
                    <strong>Cash on Delivery (COD)</strong>
                    <p style="margin:5px 0 0; font-size:0.9em; color:#666;">Pay when your items arrive.</p>
                </div>
            </label>

            <label class="payment-option">
                <input type="radio" name="payment_method" value="UPI">
                <div>
                    <strong>UPI / Scan to Pay</strong>
                    <p style="margin:5px 0 0; font-size:0.9em; color:#666;">Fast and secure digital payment.</p>
                </div>
            </label>

            <button type="submit" class="btn-confirm">Next: Enter Details →</button>
        </form>
    </div>
</body>
</html>