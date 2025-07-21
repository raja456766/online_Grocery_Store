<?php
session_start();
$pin = $_POST['pin'];

// Optional: Simple mock PIN to 
$pin_to_state = [
    '761018' => 'Purushottampur',
    '400001' => 'Hinjilicut',
    '600001' => 'Tamil Nadu',
    '700001' => 'West Bengal',
    '560001' => 'Karnataka',
    // Add more mappings or use an API
];

if (isset($pin_to_state[$pin])) {
    $state = $pin_to_state[$pin];

    // Database connection
    $conn = new mysqli("localhost", "root", "", "groceryweb");
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $user = $_SESSION['user_name'];

    // Insert or update the pincode
    $stmt = $conn->prepare("INSERT INTO pincodes (user_id, pincode, block_name) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $user, $pin, $state);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    $_SESSION['user_pin'] = $pin;
    $_SESSION['user_state'] = $state;

    header("Location: index.php");
    exit();
} else {
    echo "<script>alert('Invalid PIN Code. Please try again.'); window.location.href='index.php';</script>";
}
?>
