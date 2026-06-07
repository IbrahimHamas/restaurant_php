<?php

include "../../connect.php";
require_once 'mail.php';


$email=filterRequest("email");
$verifycode =rand(10000,99999);
$stmt =$con->prepare("SELECT * FROM delivery WHERE delivery_email = ? ");
$stmt->execute(array($email));

$count=$stmt->rowCount();



if($count > 0){

$data = array("delivery_verifycode" => $verifycode);  

updateData("delivery",$data,"delivery_email ='$email'",false);

    
try {
    //الايميل الموحود في setForm لازم يكون مطابق للايميل الموجود في mail.php
    $mail->setFrom("ibrahamas108@gmail.com", "Restaurant");
    $mail->addAddress($email);
    $mail->Subject = 'Verification Code';
    $mail->Body = '<b>Verify Code for check email:</b> ' . $verifycode;
    $mail->send();
    
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Mail not sent"]);
}

} else {
    echo json_encode(["status" => "error", "message" => "Email not found"]);
}
