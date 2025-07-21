<?php
session_start();
include 'dbcon.php';

if (isset($_SESSION['user_id'])) {
    // Only allow admin to access adminpage.php
    if ($_SESSION['role'] === 'admin') {
        header('Location: adminpage.php');
    } else {
        header('Location: index.php');
    }
    exit();
}

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); // Sanitize input

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // Only allow one admin login
        if ($row['role'] === 'admin') {
            // Check if any admin is already logged in (by scanning sessions or a flag in DB)
            // For simplicity, let's check if any session is active for admin (not perfect, but works for single-user systems)
            if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
                $error = "Admin is already logged in from another session.";
            } elseif ($password === $row['password']) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['admin_logged_in'] = true;
                header('Location: adminpage.php');
                exit();
            } else {
                $error = "Incorrect password!";
            }
        } else {
            // Normal user login
            if ($password === $row['password']) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['user_name'] = $row['name'];
                $_SESSION['role'] = $row['role'];
                header('Location: index.php');
                exit();
            } else {
                $error = "Incorrect password!";
            }
        }
    } else {
        $error = "Email not found!";
    }
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Grocery Store</title>
    <style>
        body { background: #f0f0f0; font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; min-height: 100vh; margin: 0; }
        .container { background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 400px; }
        h2 { text-align: center; color: #333; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #555; }
        input { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { width: 100%; padding: 10px; background: #4CAF50; color: #fff; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #45a049; }
        .error { color: #ff0000; text-align: center; margin-bottom: 10px; }
        p { text-align: center; }
        a { color: #4CAF50; text-decoration: none; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form method="post">
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login">Login</button>
            <p>Don't have an account? <a href="register.php">Register</a></p>
        </form>
    </div>
</body>
</html>
