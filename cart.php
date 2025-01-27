<?php
session_start();

if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

include('db.php'); 

function fetchCartItems($conn, $userEmail) {
    $sql = "SELECT c.product_id, c.quantity, p.description, (c.quantity * p.price) AS total_price , p.image 
            FROM cart c 
            INNER JOIN product p ON c.product_id = p.id 
            WHERE c.user_email = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userEmail);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $cartItems = [];
    $cartTotalPrice = 0;

        while ($row = $result->fetch_assoc()) {
        $cartItems[] = $row;
        $cartTotalPrice += $row['total_price'];
    }
    $stmt->close();

    return [$cartItems, $cartTotalPrice];
}



$userEmail = $_SESSION['email'];
list($cartItems, $cartTotalPrice) = fetchCartItems($conn, $userEmail);
$orderConfirmed = isset($_GET['confirmed']) && $_GET['confirmed'] == 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
    <meta name="description" content="Add items to your cart and enjoy a seamless shopping experience!">
    <title>FinalLap - My Cart</title>
    <link rel="icon" href="assets/logo/Image__4_-removebg.png" type="image">
    <link rel="stylesheet" href="main.css">
    <link rel="stylesheet" href="login.css">
    <link rel="stylesheet" href="cart.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-light sticky-top bg-primary">
        <a class="navbar-brand" href="#">
            <img id="logo" src="assets/logo/white logo (3).png" alt="logo failed to load" class="img-fluid">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="drivers.php">Drivers</a></li>
                <li class="nav-item"><a class="nav-link" href="calendar.php">Calendar</a></li>
                <li class="nav-item"><a class="nav-link" href="merch.php">Merch</a></li>
                <li class="nav-item active"><a class="nav-link" href="cart.php">Cart <span class="sr-only">(current)</span></a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Log In</a></li>
                <li class="nav-item"><a class="nav-link" href="register.php">Sign Up</a></li>
                <li class="nav-item"><a class="nav-link" href="logout.php">Log Out</a></li>
            </ul>
        </div>
    </nav>

    <section>
        <div class="cart">
        <h1>Shopping Cart</h1>

        <?php if ($orderConfirmed): ?>
                <?php echo "<p>Your order has been successfully confirmed.</p>"; ?>
            <?php endif; ?>
        <div class="cartList">
        <?php
        if (!empty($cartItems)) {
            foreach ($cartItems as $item) {
                echo "<div class='item'>
                        <div class='image'>
                            <img src='{$item['image']}' alt='Product Image'>
                        </div>
                        <div class='name'>
                            <p>{$item['description']}</p>
                        </div>
                        <div class='totalPrice'>
                            <p>Total Price: {$item['total_price']}</p>
                        </div>
                        <div class='quantity'>
                            <span>{$item['quantity']}</span>
                            <button class='remove'><a href='removefromcart.php?id={$item['product_id']}'>Remove</a></button>
                        </div>
                    </div>";
            }
        echo "<div class='cart-total'>
                            <h3>Total Price: $cartTotalPrice
                            </h3>
                          </div>";
        } else {
            echo "<p>Your cart is empty.
            </p>";
        }
        ?>      
        </div>
    </div>
        <p class="note">
            <strong>Note:</strong> Cash payment is available upon delivery.
        </p>
        
        <?php if (!empty($cartItems)):?>
            
            <div class="confirm-order">
                <?php ?>
                
                <form action="confirmorder.php" method="post">
                    <button type="submit" class="btn btn-primary">Confirm Order</button>
                </form>
            </div>
        <?php endif; ?>
    </section>

    <footer class="text-center mt-5">
        <p>&copy; 2025 FinalLap. All rights reserved.</p>
    </footer>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"></script>
</body>

</html>
