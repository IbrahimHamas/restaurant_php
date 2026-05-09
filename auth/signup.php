<?php

include "../connect.php";
require_once 'mail.php';

$username = filterRequest("username");
$password = sha1($_POST['password']);
$email = filterRequest("email");
$phone = filterRequest("phone");
$verifycode = rand(10000, 99999);

$stmt = $con->prepare("SELECT * FROM users WHERE users_email = ? OR users_phone = ?");
$stmt->execute(array($email, $phone));

$count = $stmt->rowCount();

$response = []; // Use an array to store the response

if ($count > 0) {
    $response = ["status" => "error", "message" => "Phone or Email already exists"];
} else {
    $data = array(
        "users_name" => $username,
        "users_password" => $password,
        "users_email" => $email,
        "users_phone" => $phone,
        "users_verifycode" => $verifycode,
    );

    insertData("users", $data);
/*
    try {
        // Disable SMTP Debugging
        $mail->SMTPDebug = 0;

        $mail->setFrom("your-email@example.com", "Your App Name"); // Use a fixed sender email
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Verification Code';
        $mail->Body = "<b>Verify Code:</b> $verifycode";

        if ($mail->send()) {
         //   $response = ["status" => "success"];
        } else {
          //  $response = ["status" => "error", "message" => "Mail not sent"];
        }
    } catch (Exception $e) {
       // $response = ["status" => "error", "message" => "Mail sending failed: " . $mail->ErrorInfo];
    }
    */
}

// Ensure only one JSON output
/*header('Content-Type: application/json');
echo json_encode($response);*/
//exit(); // Prevent any further output

?>
