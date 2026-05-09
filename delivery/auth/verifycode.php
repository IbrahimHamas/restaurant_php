<?php

include "../../connect.php";

$email =filterRequest("email");
$verify =filterRequest("verifycode");

$stmt = $con->prepare("SELECT * FROM delivery WHERE delivery_email = ? AND delivery_verifycode = ?");
$stmt->execute(array($email, $verify));
$count = $stmt->rowCount();


if($count > 0){

    $data = array("delivery_approve" => "1");

    updateData("delivery",$data,"delivery_email ='$email'");
}else{

    printFailure("verifyCode not correct ");
}
