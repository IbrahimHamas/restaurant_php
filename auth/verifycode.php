<?php

include "../connect.php";

$email =filterRequest("email");
$verify =filterRequest("verifycode");

$stmt = $con->prepare("SELECT * FROM users WHERE users_email = ? AND users_verifycode = ?");
$stmt->execute(array($email, $verify));
$count = $stmt->rowCount();


if($count > 0){

    $data = array("users_approve" => "1");

    updateData("users",$data,"users_email ='$email'");
}else{

    printFailure("verifyCode not correct ");
}
