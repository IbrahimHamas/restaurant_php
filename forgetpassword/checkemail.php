<?php

include "../connect.php";
require_once 'mail.php';


$email=filterRequest("email");
$verifycode =rand(10000,99999);
$stmt =$con->prepare("SELECT * FROM users WHERE users_email = ? ");
$stmt->execute(array($email));

$count=$stmt->rowCount();

result($count);

if($count > 0){

$data = array("users_verifycode" => $verifycode);  

updateData("users",$data,"users_email ='$email'",false);

   /* 
try {
    $mail->setFrom($email, $username);
    $mail->addAddress($email);
    $mail->Subject = 'Verification Code';
    $mail->Body = '<b>Verify Code for check email:</b> ' . $verifycode;
    $mail->send();
    
    echo json_encode(["status" => "success"]);
} catch (Exception $e) {
    echo json_encode(["status" => "error", "message" => "Mail not sent"]);
}
*/
}
