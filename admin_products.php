<?php
session_start();
include 'db.php';

// Admin security check
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

// Handle Adding a Product
if (isset($_POST['add_product'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $price = $_POST['price'];
    $image = $_POST['image_name']; 

    $conn->query("INSERT INTO products (name, price, image) VALUES ('$name', '$price', '$image')");
    header("Location: admin_products.php");
}

// Handle Deleting a Product
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM products WHERE id = $id");
    header("Location: admin_products.php");
}

// Handle Search Query Logic
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Products</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f4f7f6; padding: 20px; }
        .container { max-width: 900px; margin: auto; background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .form-box { background: #eef2f3; padding: 20px; border-radius: 10px; margin-bottom: 30px; }
        input { padding: 10px; margin-right: 10px; border: 1px solid #ddd; border-radius: 5px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; border-bottom: 1px solid #eee; text-align: left; }
        .btn-add { background: #27ae60; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; }
        .btn-edit { background: #3498db; color: white; text-decoration: none; padding: 5px 10px; border-radius: 4px; font-size: 0.8em; margin-right: 5px; }
        .btn-delete { background: #e74c3c; color: white; text-decoration: none; padding: 5px 10px; border-radius: 4px; font-size: 0.8em; }
        
        /* Search Bar Styling */
        .search-container { margin-bottom: 20px; display: flex; gap: 10px; }
        .search-input { flex-grow: 1; }
        .btn-search { background: #3498db; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .btn-clear { padding: 10px; color: #e74c3c; text-decoration: none; border: 1px solid #e74c3c; border-radius: 5px; font-size: 0.9em; }
    </style>
</head>
<body>

<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h1>Manage Store Items</h1>
        <a href="view_orders.php" style="text-decoration:none; color:#3498db; font-weight: bold;">View Orders →</a>
    </div>

    <div class="form-box">
        <h3>Add New Product</h3>
        <form method="POST">
            <input type="text" name="name" placeholder="Product Name (e.g. Keyboard)" required>
            <input type="number" step="0.01" name="price" placeholder="Price" required>
            <input type="text" name="image_name" placeholder="Image Filename (e.g. key.jpg)" required>
            <button type="submit" name="add_product" class="btn-add">Add to Store</button>
        </form>
        <p style="font-size: 0.8em; color: #666; margin-top: 10px;">Make sure the image file exists in your <strong>images</strong> folder.</p>
    </div>

    <div class="search-container">
        <form method="GET" style="width: 100%; display: flex; gap: 10px;">
            <input type="text" name="search" class="search-input" placeholder="Search by name or ID..." 
                   value="<?php echo htmlspecialchars($search); ?>">
            <button type="submit" class="btn-search">Search 🔍</button>
            <?php if($search != ''): ?>
                <a href="admin_products.php" class="btn-clear">Clear Filter</a>
            <?php endif; ?>
        </form>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Updated Query to support search
            if ($search != '') {
                $sql_query = "SELECT * FROM products WHERE name LIKE '%$search%' OR id LIKE '%$search%'";
            } else {
                $sql_query = "SELECT * FROM products";
            }
            
            $products = $conn->query($sql_query);
            
            if ($products && $products->num_rows > 0) {
                while($row = $products->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><img src="images/<?php echo $row['image']; ?>" width="50" style="border-radius:5px;"></td>
                    <td><?php echo $row['name']; ?></td>
                    <td>$<?php echo number_format($row['price'], 2); ?></td>
                    <td>
                        <a href="edit_product.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                        <a href="admin_products.php?delete=<?php echo $row['id']; ?>" 
                           class="btn-delete" onclick="return confirm('Are you sure?')">Remove</a>
                    </td>
                </tr>
                <?php endwhile; 
            } else {
                echo "<tr><td colspan='5' style='text-align:center;'>No products found matching your search.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>