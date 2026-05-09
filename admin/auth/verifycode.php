<?php

include "../../connect.php";

$email =filterRequest("email");
$verify =filterRequest("verifycode");

$stmt = $con->prepare("SELECT * FROM admin WHERE admin_email = ? AND admin_verifycode = ?");
$stmt->execute(array($email, $verify));
$count = $stmt->rowCount();


if($count > 0){

    $data = array("admin_approve" => "1");

    updateData("admin",$data,"admin_email ='$email'");
}else{

    printFailure("verifyCode not correct ");
}
