<?php

include "auth/signup.php";
require_once 'mail.php';


$mail ->setFrom('ibrahamas108@gmail.com','Ibrahim Hamas');
$mail ->addAddress('ibrahamas108@gmail.com');
$mail ->Subject ='رسالة تجريبية';
$mail ->Body ='Test From Ibrahim <b> Hello everyone </b>';
$mail ->send();
?>