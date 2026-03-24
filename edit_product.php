<?php
session_start();
include 'db.php';

// Admin security check
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Get the product details based on the ID passed from the table
if (isset($_GET['id'])) {
    $id = $conn->real_escape_string($_GET['id']);
    $result = $conn->query("SELECT * FROM products WHERE id = $id");
    
    if ($result && $result->num_rows > 0) {
        $product = $result->fetch_assoc();
    } else {
        echo "Product not found.";
        exit();
    }
} else {
    header("Location: admin_products.php");
    exit();
}

// Handle the update form submission
if (isset($_POST['update_product'])) {
    $id = $_POST['id'];
    $name = $conn->real_escape_string($_POST['name']);
    $price = $_POST['price'];
    $image = $_POST['image_name'];

    $sql = "UPDATE products SET name='$name', price='$price', image='$image' WHERE id=$id";
    if ($conn->query($sql)) {
        header("Location: admin_products.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product - Admin</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; padding: 20px; }
        .container { max-width: 500px; margin: 50px auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; color: #2c3e50; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        .btn-update { width: 100%; background: #3498db; color: white; border: none; padding: 12px; border-radius: 5px; cursor: pointer; font-weight: bold; font-size: 1em; }
        .btn-update:hover { background: #2980b9; }
        .preview-img { display: block; margin: 10px auto; border-radius: 8px; max-height: 150px; border: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="text-align: center;">Edit Product Details</h2>
        
        <img src="images/<?php echo $product['image']; ?>" class="preview-img" alt="Current Image">

        <form method="POST">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Price ($)</label>
                <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Image Filename</label>
                <input type="text" name="image_name" value="<?php echo htmlspecialchars($product['image']); ?>" required>
                <small style="color: #666;">(e.g., mouse.jpg - must exist in /images/ folder)</small>
            </div>
            
            <button type="submit" name="update_product" class="btn-update">Save Changes</button>
            <p style="text-align:center;"><a href="admin_products.php" style="color:#e74c3c; text-decoration:none; font-size:0.9em;">Cancel and Go Back</a></p>
        </form>
    </div>
</body>
</html>