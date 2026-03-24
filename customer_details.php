<?php
session_start();
include 'db.php';

$payment_method = isset($_POST['payment_method']) ? $_POST['payment_method'] : 'COD';

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
    <title>Customer Details - TechStore</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f7f6; margin: 0; padding: 20px; }
        .container { 
            max-width: 550px; margin: 30px auto; background: white; 
            padding: 40px; border-radius: 20px; box-shadow: 0 8px 32px rgba(0,0,0,0.1); 
        }
        /* Enhanced UPI Box with QR Code styling */
        .upi-info { 
            background: #f0f9ff; border: 2px dashed #3498db; padding: 20px; 
            border-radius: 12px; text-align: center; margin-bottom: 25px; 
        }
        .qr-image {
            width: 180px; height: 180px; margin: 15px auto;
            border: 5px solid white; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #333; }
        input, textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn-submit {
            width: 100%; background: #27ae60; color: white; border: none;
            padding: 15px; border-radius: 10px; font-weight: bold; cursor: pointer; transition: 0.3s;
        }
        .btn-submit:hover { background: #219150; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Shipping & Details</h2>
        
        <?php if($payment_method == 'UPI'): ?>
            <div class="upi-info">
                <h3 style="color:#2980b9; margin-top:0;">Scan & Pay</h3>
                <p>Scan the QR code below to pay:</p>
                
                <img src="images/upi_qr.png" alt="UPI QR Code" class="qr-image">
                
                <p>UPI ID: <strong>praveen@upi</strong></p>
                <p style="font-size: 0.8em; color: #666; margin-top: 10px;">After payment, please fill in your delivery details below.</p>
            </div>
        <?php else: ?>
             <p style="text-align:center; color:#7f8c8d;">Payment Method: <strong>Cash on Delivery (COD)</strong></p>
        <?php endif; ?>

        <form action="process_checkout.php" method="POST">
            <input type="hidden" name="payment_method" value="<?php echo $payment_method; ?>">

            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="customer_name" required placeholder="Enter your name">
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="tel" name="customer_phone" required placeholder="10-digit mobile number">
            </div>
            <div class="form-group">
                <label>Full Delivery Address</label>
                <textarea name="customer_address" rows="3" required placeholder="House No, Area, Landmark, Pincode"></textarea>
            </div>

            <button type="submit" class="btn-submit">Confirm Order →</button>
        </form>
    </div>
</body>
</html>