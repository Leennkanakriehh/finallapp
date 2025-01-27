<?php
session_start();
include('db.php');

if(!isset($_SESSION['email']) || empty($_SESSION['email'])){
    header('location:login.php');
    exit();
}

if(isset($_GET['id'])){
    $product_id = $_GET['id'];
    $sql = "DELETE FROM cart WHERE product_id = ? AND user_email = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $product_id, $_SESSION['email']);
    $stmt->execute();
    $stmt->close();
    
    header('location:cart.php');
    exit();
}
?>
