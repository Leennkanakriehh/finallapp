<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include('db.php');

$userEmail = $_SESSION['email'];

$sql = "DELETE FROM cart WHERE user_email = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$stmt->close();
header("Location: cart.php?confirmed=1");
exit();
?>
