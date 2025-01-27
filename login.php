<?php
session_start();
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['pswd']);

    $sql = "SELECT * FROM user WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if ($password == $user['password']) {
            $_SESSION['email'] = $user['email'];
            $_SESSION['username'] = $user['username'];

            setcookie('logged_in', 'true', time() + (86400 * 30), "/"); // expires in 30 days
            header("Location: index.php");
            exit();
        } else {
            $message =  'Incorrect Credentials';
        }
    } else {
        $message =  'User not found';
    }
    $conn->close();
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
        content="Welcome to FinalLap. create an account to check out the latest F1 news, F1 calendar, and buy from merch!!">
    <title>FinalLap - Sign up </title>
    <link rel="icon" type="image/png" href="assets/logo/Image__4_-removebg.png">
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <header>
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

                <li class="nav-item active">
                    <li class="nav-item">
                    <a class="nav-link" href="index.php" target="_self">Home </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="drivers.php">Drivers</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="calendar.php">Calendar</a>
                </li>
                <li class="nav-">
                    <a class="nav-link" href="merch.php">Merch</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">Cart</a>
                </li>
                    <a class="nav-link active" href="login.php">Log In <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Sign Up</a>
                </li>
            </ul>
        </div>
    </nav>
    <header\>

    <section class="signup-form">
        <h1 class="heading1">Log In</h1>
        <form action="login.php" method="post">
        <div>
            <?php 
                if(isset($message)){
                    echo  "<div class='alert alert-danger'>".$message. "</div>";
                }
           ?>
        </div>
            <div>
                <label for="email">Email:</label><br>
                <input type="email" name="email" id="email" placeholder="Email" required>
            </div>
            <div>
                <label for="pswd">Password:</label><br>
                <input type="password" name="pswd" id="pswd" minlength="6" maxlenghth="10"
                    placeholder="Password" required>
            </div>
            <div class="button">
                <input type="submit" name="submit" id="register" value=" Log In">
            </div>
        </form>
    </section>
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
    <script src="main.js"></script>
</body>
</html>
