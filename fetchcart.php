<?php
session_start();
include('db.php');

if (isset($_SESSION['email'])) {
    $user_email = $_SESSION['email'];

    $fetchCart = "
    SELECT c.id, pr.price, c.quantity 
    FROM cart c 
    JOIN product pr ON c.product_id = pr.id 
    WHERE c.user_email = '$user_email';
    ";

    $result = mysqli_query($conn, $fetchCart);

    if (!$result) {
        die('Error: ' . mysqli_error($conn));
    }

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div id='cart-item-{$row['id']}' class='cart-item'>
                    <img src='{$row['image']}' alt='{$row['name']}' class='cart-image'>
                    <p>{$row['name']}</p>
                    <p>\${$row['price']}</p>
                    <input type='number' class='cart-item-quantity' data-cart-id='{$row['id']}' value='{$row['quantity']}'>
                    <button class='remove-from-cart-btn' data-cart-id='{$row['id']}'>Remove</button>
                  </div>";
        }
    } else {
        echo "<p>Your cart is empty.</p>";
    }
}
?>
