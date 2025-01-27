<?php
session_start();
require 'db.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
     $dob = mysqli_real_escape_string($conn, $_POST['dob']);
     $email = mysqli_real_escape_string($conn, $_POST['email']);
    $country = mysqli_real_escape_string($conn, $_POST['country']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

       $checkEmailSql = "SELECT * FROM user WHERE email = '$email'";
    $result = $conn->query($checkEmailSql);

    if ($result->num_rows > 0) {
        $message =  'This email is already associated with another account. Please try a different email.';
    } else {
        $sql = "INSERT INTO user (username, dob, email, country, password) 
        VALUES ('$username', '$dob', '$email', '$country', '$password')";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['email'] = $email; 
        $_SESSION['username'] = $username; 
        header("Location: index.php");
        exit();
    } else {
        echo "Error: ". $sql. $conn->error;
    }
    $conn->close();
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
        content="Welcome to FinalLap. create an account to check out the latest F1 news, F1 calender, and get your tickets!">
    <title>FinalLap - Sign up </title>
    <link rel="icon" type="image/png" href="assets/logo/Image__4_-removebg.png">
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="main.css">
</head>

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
                    <li class="nav-item">
                    <a class="nav-link" href="index.php" target="_self">Home </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="drivers.php">Drivers</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="calendar.php">Calendar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="merch.php">Merch</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">Cart</a>
                </li>
                    <a class="nav-link" href="login.php">Log In</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="register.php">Sign Up <span class="sr-only">(current)</span></a>
                </li>
            </ul>
        </div>
    </nav>

    <section class="signup-form">
        <div>
            <?php 
                if(isset($message)){
                    echo  "<div class='alert alert-danger'>".$message. "</div>";
                }
           ?>
        </div>
        <h1 class="heading1">Sign Up</h1>

        <form action="register.php" method="POST">
            <div>
                <label for="username">Username</label><br>
                
                <input type="text" name="username" id="username" placeholder="Name" maxlength="30" required>
            </div>
            <div>
                <label for="DoB">Date of birth</label><br>
                <input type="date" name="dob" id="DoB" required>
            </div>
            <div>
                <label for="email">Email address:</label><br>
                <input type="email" name="email" id="email" placeholder="Email">
            </div>
            <div>
                <label for="countries">Country of residence</label><br>
                <input list="countries" id="country" name="country" placeholder="Country" required>
                <datalist id="countries">
                    <option value="Argentina">
                    <option value="Australia">
                    <option value="Brazil">
                    <option value="Canada">
                    <option value="China">
                    <option value="Egypt">
                    <option value="France">
                    <option value="Germany">
                    <option value="India">
                    <option value="Indonesia">
                    <option value="Italy">
                    <option value="Japan">
                    <option value="Jordan">
                    <option value="Kuwait">
                    <option value="Lebanon">
                    <option value="Mexico">
                    <option value="Monaco">
                    <option value="Netherlands">
                    <option value="New Zealand">
                    <option value="Poland">
                    <option value="Russia">
                    <option value="Saudi Arabia">
                    <option value="South Africa">
                    <option value="South Korea">
                    <option value="Spain">
                    <option value="Sweden">
                    <option value="Switzerland">
                    <option value="United Arab Emirates">
                    <option value="United Kingdom">
                    <option value="United States">
                </datalist>
            </div>
            <div>
                <label for="password">Password:</label><br>
                <input type="password" name="password" id="password" minlength="6" maxlenghth="10"
                    placeholder="Password">
            </div> <br>
            <div class="button">
                <input type="submit" name="submit" id="register" value="Sign Up">
            </div>
        </form>
        <div class="login-link">
            <p>Already a FinalLap Member?</p>
            <a href="login.php">Click here to log in </a>
        </div>
    </section>
    
<body>
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