<?php

include "../../connect.php";
require_once 'mail.php';


$email=filterRequest("email");

$stmt =$con->prepare("SELECT * FROM admin WHERE admin_email = ? ");
$stmt->execute(array($email));

$count=$stmt->rowCount();



if($count > 0){

$verifycode = rand(10000,99999);
//تحديث الكود في قاعدة البيانات يجب ان يكون نوع المتغير في قاعدة البيانات  integer لو رقم
$data = array("admin_verifycode" => $verifycode);  

updateData("admin",$data,"admin_email ='$email'",false);

    
try {
    //الايميل الموحود في setForm لازم يكون مطابق للايميل الموجود في mail.php
    $mail->setFrom("abrahymhms909@gmail.com", "Restaurant");
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
