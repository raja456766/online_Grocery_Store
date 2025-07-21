<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header("Location: login.php");
    exit();
}

$order_id = $_GET['order_id'] ?? '';
$user = $_GET['user'] ?? 'Customer';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Order Success - G-Mart</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <style>
    body {
      background: #f0fff4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    .success-container {
      text-align: center;
      animation: fadeIn 1s ease-out;
    }

    .success-icon {
      font-size: 80px;
      color: #4BB543;
      animation: pop 0.5s ease-in-out;
    }

    .success-message {
      font-size: 32px;
      font-weight: bold;
      color: #333;
      margin-top: 20px;
      animation: bounce 1s ease;
    }

    .sub-message {
      font-size: 18px;
      margin-top: 10px;
      margin-bottom: 20px;
      color: #555;
    }

    @keyframes pop {
      0% {
        transform: scale(0.5);
        opacity: 0;
      }
      100% {
        transform: scale(1);
        opacity: 1;
      }
    }

    @keyframes bounce {
      0%   { transform: translateY(-30px); opacity: 0; }
      50%  { transform: translateY(10px); }
      100% { transform: translateY(0); opacity: 1; }
    }

    @keyframes fadeIn {
      from { opacity: 0; }
      to   { opacity: 1; }
    }

    .btn-home {
      margin-top: 30px;
      padding: 12px 30px;
      font-size: 16px;
      background-color: #4BB543;
      color: #fff;
      border: none;
      border-radius: 8px;
      cursor: pointer;
      transition: background 0.3s ease;
      text-decoration: none;
    }

    .btn-home:hover {
      background-color: #3da73d;
    }
  </style>
</head>
<body>
  <div class="success-container">
    <i class="fas fa-check-circle success-icon"></i>
    <div class="success-message">Order Placed Successfully!</div>
    <div class="sub-message">Thank you for shopping with G-Mart 🎉</div>
    <a href="index.php" class="btn-home">Continue Shopping</a>
  </div>
</body>
</html>
