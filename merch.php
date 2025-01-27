<?php
session_start();
include('db.php');

if (isset($_POST['submit'])) {
    if (isset($_SESSION['email'])) {
        $userEmail = $_SESSION['email']; 
        $productId = $_POST['product_id'];
        $sql = "SELECT id, price, description, status, image FROM product WHERE id = '$productId'";
        $result = mysqli_query($conn, $sql);

        if ($result && mysqli_num_rows($result) > 0) {
            $product = mysqli_fetch_assoc($result);
            $productPrice = $product['price']; 

            $cartCheckSql = "SELECT * FROM cart WHERE user_email = '$userEmail' AND product_id = '$productId'";
            $checkQuantity = mysqli_query($conn, $cartCheckSql);

            if ($checkQuantity && mysqli_num_rows($checkQuantity) > 0) {
                $updateCartSql = "UPDATE cart 
                                  SET quantity = quantity + 1, 
                                      total_price = total_price + $productPrice 
                                  WHERE user_email = '$userEmail' AND product_id = '$productId'";
                mysqli_query($conn, $updateCartSql);
            } else {
                $insertCartSql = "INSERT INTO cart (user_email, product_id, quantity, total_price) 
                                  VALUES ('$userEmail', '$productId', 1, $productPrice)";
                if (mysqli_query($conn, $insertCartSql)) {
                    //echo "Product added to the cart.";
                } else {
                    //echo "Error adding product to the cart: " . mysqli_error($conn);
              }
            }
        } else {
            echo "Product not found.";
        }
    } else {
        echo "You must log in to add products to your cart.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <meta name="description"
        content="Get your official Formula 1 merchandise for every Grand Prix of the World Championship season. fast delivery!">
    <meta name="keywords" content="F1 merchandise, Formula 1, F1 gear, Grand Prix merchandise, F1 gifts, F1 apparel, Formula 1 store, F1 shop, motorsport merchandise, F1 accessories, F1 official merchandise, F1 online store">
    <title>FinalLap - F1 Merch Store</title>
    <link rel="icon" href="assets/logo/Image__4_-removebg.png" type="image">
    <link rel="stylesheet" href="merch.css">
    <link rel="stylesheet" href="main.css">
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
            <ul class="navbar-nav ml-auto" style="margin-right: -10px;"> 
                <li class="nav-item">
                    <a class="nav-link" href="index.php" target="_self">Home </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="drivers.php">Drivers</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="calendar.php">Calendar</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="merch.php">Merch <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Log In</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Sign Up</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Log Out</a>
                </li>

            </ul>
        </div>
    </nav>

    <section>
    <h1>
        Shop official Formula 1 Model Cars and Merchandise – Perfect for Every F1 Fan! Online!
    </h1>
    <div class="items">
        <?php
        $sql = "SELECT * FROM product";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div>
                <img src="<?php echo $row['image']; ?>" alt="Product Image">
                <p class="item-description"><?php echo $row['description']; ?></p>
                <p class="status"><?php echo $row['status']; ?></p>
                <p class="price">Price: <?php echo $row['price']; ?>$</p>
                <form method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $row['id']; ?>">
                    <input class="buy-button" type="submit" name="submit" value="Add to Cart">
                </form>
                
            </div>
        <?php
            }
        } else {
            echo "<p>No products found.</p>";
        }
        ?>
    </div>
</section>

    <div class="login-signup-box">
        <h2>Please Log In or Sign Up</h2>
        <p>You need to log in to add items to your cart.</p>
        <input class="box-btn" id="login-btn" type="submit" name="login" value="Log In">
        <input class="box-btn" id="signup-btn" type="submit" name="signup" value="Sign Up">
    </div>

    <footer class="text-center mt-5">
        <p>&copy; 2025 FinalLap. All rights reserved.</p>
    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
    <script>
    var isLoggedIn = <?php echo isset($_SESSION['email']) ? 'true' : 'false'; ?>;

    var buttons = document.querySelectorAll('.buy-button');

    buttons.forEach(function (button) {
        button.onclick = function (event) {
            if (!isLoggedIn) {
                event.preventDefault();

                displayBox();
            }
        };
    });
    

    function displayBox() {
        var overlay = document.createElement('div');
        overlay.className = 'overlay';
        document.body.appendChild(overlay);

        var box = document.querySelector('.login-signup-box');
        box.style.display = 'inline-block';

        console.log('Login/Signup box displayed!');

        overlay.onclick = function () {
            box.style.display = 'none';
            overlay.remove();
            console.log('Login/Signup box hidden!');
        };
    }

    document.getElementById('login-btn').onclick = function () {
        window.location.href = 'login.php';
    };

    document.getElementById('signup-btn').onclick = function () {
        window.location.href = 'register.php';
    };
</script>


</body>

</html>