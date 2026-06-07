<?php

include "../../connect.php";
//require_once 'mail.php';

$username = filterRequest("username");
$password = sha1($_POST['password']);
$email = filterRequest("email");
$phone = filterRequest("phone");
$verifycode = rand(10000, 99999);

$stmt = $con->prepare("SELECT * FROM delivery WHERE delivery_email = ? OR delivery_phone = ?");
$stmt->execute(array($email, $phone));

$count = $stmt->rowCount();

$response = []; // Use an array to store the response

if ($count > 0) {
    $response = ["status" => "error", "message" => "Phone or Email already exists"];
    echo json_encode($response);

} else {
    $data = array(
        "delivery_name" => $username,
        "delivery_password" => $password,
        "delivery_email" => $email,
        "delivery_phone" => $phone,
        "delivery_verifycode" => $verifycode,
    );

    insertData("delivery", $data);

 
}

// Ensure only one JSON output
/*header('Content-Type: application/json');
echo json_encode($response);*/
exit(); // Prevent any further output

?>
