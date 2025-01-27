<?php
session_start();
include('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cart_id = $_POST['cart_id'];
    $quantity = $_POST['quantity'];

    $cart_id = mysqli_real_escape_string($conn, $cart_id);
    $quantity = intval($quantity);

    $updateCart = "UPDATE cart SET quantity = $quantity WHERE id = $cart_id";
    if (mysqli_query($conn, $updateCart)){
        //echo "success";
    } else {
        //echo "error:failed";
    }
}
?>

