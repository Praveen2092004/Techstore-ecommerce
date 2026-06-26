<?php
// 1. Enable Error Reporting (Helps catch hidden server crashes)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// 2. Include database first so $conn is defined before using real_escape_string
include 'db.php';

// Handle Search Query Logic
$search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to TechStore</title>
    <style>
        /* Modern Design Updates */
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0; background: #f4f7f6; }
        
        /* Sticky Navigation Bar */
        nav { 
            background: #2c3e50; padding: 15px 0; position: sticky; top: 0; 
            z-index: 1000; box-shadow: 0 2px 10px rgba(0,0,0,0.2); 
        }
        .nav-container { 
            max-width: 1100px; margin: auto; display: flex; 
            justify-content: space-between; align-items: center; padding: 0 20px; 
        }
        .nav-logo { color: white; text-decoration: none; font-size: 1.5em; font-weight: bold; }
        .nav-links a { color: #ecf0f1; text-decoration: none; font-weight: 500; margin-left: 20px; }

        /* Search Bar Styling */
        .search-container {
            max-width: 600px; margin: 30px auto; text-align: center;
        }
        .search-container form { display: flex; gap: 10px; justify-content: center; }
        .search-input { 
            padding: 12px 20px; width: 300px; border: 1px solid #ddd; 
            border-radius: 25px; outline: none; font-size: 1em;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
        }
        .search-btn {
            padding: 12px 25px; background: #3498db; color: white; border: none; 
            border-radius: 25px; cursor: pointer; font-weight: bold; transition: 0.3s;
        }
        .search-btn:hover { background: #2980b9; }
        .clear-btn { padding: 12px; color: #e74c3c; text-decoration: none; font-size: 0.9em; }

        /* Success Message Alert */
        .alert { 
            padding: 15px; background-color: #d4edda; color: #155724; 
            border: 1px solid #c3e6cb; border-radius: 8px; text-align: center; 
            max-width: 600px; margin: 20px auto; 
        }

        .product-list { display: flex; flex-wrap: wrap; gap: 25px; justify-content: center; padding: 20px 20px 40px 20px; }
        
        /* Glassmorphism Product Cards */
        .product-card { 
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 16px; 
            padding: 20px; 
            width: 260px; 
            text-align: center; 
            box-shadow: 0 8px 32px rgba(31, 38, 135, 0.1);
            transition: all 0.3s ease-in-out;
        }
        .product-card:hover { 
            transform: translateY(-10px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        }
        .product-card img { width: 100%; height: 200px; object-fit: contain; border-radius: 8px; background: #fafafa; margin-bottom: 15px; }
        
        .price { color: #2ecc71; font-weight: bold; font-size: 1.3em; margin: 10px 0; }
        h3 { color: #333; font-size: 1.1em; height: 2.4em; overflow: hidden; margin: 10px 0; }
        
        /* Gradient Buttons */
        button { 
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white; border: none; padding: 12px; 
            width: 100%; border-radius: 8px; cursor: pointer; 
            font-weight: bold; transition: transform 0.2s, background 0.3s;
        }
        button:hover { background: linear-gradient(135deg, #2980b9, #2471a3); }
        button:active { transform: scale(0.95); }

        .cart-link-container { text-align: center; margin-bottom: 50px; }
        .cart-link { 
            display: inline-block; padding: 12px 25px; background: #34495e; 
            color: white; text-decoration: none; border-radius: 30px; font-weight: bold;
            transition: background 0.3s;
        }
        .cart-link:hover { background: #2c3e50; }
    </style>
</head>
<body>

<nav>
    <div class="nav-container">
        <a href="index.php" class="nav-logo">🚀PRAVEEN STORE</a>
        <div class="nav-links">
            <a href="index.php">Home</a>
            <a href="view_cart.php">🛒 Cart</a>
        </div>
    </div>
</nav>

<div class="search-container">
    <form method="GET" action="index.php">
        <input type="text" name="search" class="search-input" 
               placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit" class="search-btn">Search 🔍</button>
        <?php if($search != ''): ?>
            <a href="index.php" class="clear-btn">Clear</a>
        <?php endif; ?>
    </form>
</div>

<h1 style="text-align:center; color: #2c3e50;">Featured Products</h1>

<?php if(isset($_GET['message'])): ?>
    <div class="alert">
        ✅ <?php echo htmlspecialchars($_GET['message']); ?>
    </div>
<?php endif; ?>

<div class="product-list">
    <?php
    if (!$conn || $conn->connect_error) {
        echo "<div style='text-align:center; width:100%; color:#e74c3c;'>
                <h3>Database Connection Failed</h3>
                <p>Please check your cloud database configuration settings inside db.php.</p>
              </div>";
    } else {
        // Updated Query to handle search filtering
        if ($search != '') {
            $sql = "SELECT * FROM products WHERE name LIKE '%$search%' ORDER BY id DESC";
        } else {
            $sql = "SELECT * FROM products ORDER BY id DESC";
        }
        
        $result = $conn->query($sql);
        
        if ($result && $result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $imagePath = 'images/' . $row['image'];
                $imageFile = (!empty($row['image']) && file_exists($imagePath)) ? $imagePath : 'images/no-image.png';
                
                echo '<div class="product-card">
                        <img src="' . $imageFile . '" alt="' . htmlspecialchars($row['name']) . '">
                        <h3>' . htmlspecialchars($row['name']) . '</h3>
                        <p class="price">$' . number_format($row['price'], 2) . '</p>
                        <form method="POST" action="add_to_cart.php">
                            <input type="hidden" name="product_id" value="' . $row['id'] . '">
                            <button type="submit">Add to Cart</button>
                        </form>
                      </div>';
            }
        } else {
            echo "<div style='text-align:center; width:100%; color:#7f8c8d;'>
                    <h3>No products found matching '" . htmlspecialchars($search) . "'.</h3>
                    <p>Try a different keyword or check back later!</p>
                  </div>";
        }
    }
    ?>
</div>

<div class="cart-link-container">
    <a href="view_cart.php" class="cart-link">🛒 View My Cart</a>
</div>

</body>
</html>