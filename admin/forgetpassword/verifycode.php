<?php

include "../../connect.php";

$email =filterRequest("email");
$verify =filterRequest("verifycode");

$stmt =$con->prepare("SELECT * FROM admin WHERE admin_email ='$email' AND admin_verifycode ='$verify'");

$stmt->execute();

$count =$stmt->rowCount();

result($count);

