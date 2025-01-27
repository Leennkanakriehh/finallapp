<?php
require("connect.php");

if($_SERVER['REQUEST_METHOD']=='POST'){
$sql="INSERT INTO user (username,password) values (:username,:password)";
$statement=$pdo->prepare($sql);
$username=$_POST['username'];
$password=$_POST['password'];
$statement->bindParam(":username",$username,PDO::PARAM_STR);
$statement->bindParam(":password",$password,PDO::PARAM_STR);
$statement->execute();

}
?>