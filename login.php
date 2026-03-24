<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Securely check credentials against the admin_users table
    $result = $conn->query("SELECT * FROM admin_users WHERE username='$user' AND password='$pass'");
    
    if ($result && $result->num_rows > 0) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: view_orders.php");
        exit();
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - TechStore</title>
    <style>
        body { 
            font-family: 'Segoe UI', sans-serif; margin: 0;
            background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
            background-size: 400% 400%; animation: gradientBG 15s ease infinite; min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
        }
        @keyframes gradientBG { 0% { background-position: 0% 50%; } 50% { background-position: 100% 50%; } 100% { background-position: 0% 50%; } }

        .login-card { 
            background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(15px);
            padding: 40px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.3);
            box-shadow: 0 8px 32px rgba(0,0,0,0.3); width: 350px; text-align: center; color: white;
        }
        input { 
            width: 100%; padding: 12px; margin: 10px 0; border-radius: 8px; border: none; 
            background: rgba(255,255,255,0.8); box-sizing: border-box;
        }
        button { 
            width: 100%; padding: 12px; background: #2980b9; color: white; 
            border: none; border-radius: 8px; cursor: pointer; font-weight: bold; margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="login-card">
        <h2>🔒 Admin Login</h2>
        <?php if(isset($error)) echo "<p style='color:#ff7675;'>$error</p>"; ?>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>