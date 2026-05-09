<?php

include "../connect.php";
//require_once 'mail.php';

$password=sha1($_POST['password']);
$email=filterRequest("email");

/*$verifycode =rand(10000,99999);
$stmt =$con->prepare("SELECT * FROM users WHERE users_email = ? AND users_password = ? AND users_approve = 1");
$stmt->execute(array($email,$password));

$count=$stmt->rowCount();

result($count);*/

getData("users","users_email = ? AND users_password = ?",array($email,$password));