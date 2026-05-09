<?php

include "../../connect.php";

$username = filterRequest("username");
$password = sha1($_POST['password']);
$email = filterRequest("email");
$phone = filterRequest("phone");
$verifycode = rand(10000, 99999);

$stmt = $con->prepare("SELECT * FROM admin WHERE admin_email = ? OR admin_phone = ?");
$stmt->execute(array($email, $phone));

$count = $stmt->rowCount();

$response = []; // Use an array to store the response

if ($count > 0) {
    $response = ["status" => "error", "message" => "Phone or Email already exists"];
} else {
    $data = array(
        "admin_name" => $username,
        "admin_password" => $password,
        "admin_email" => $email,
        "admin_phone" => $phone,
        "admin_verifycode" => $verifycode,
    );

    insertData("admin", $data);

   
}

// Ensure only one JSON output
/*header('Content-Type: application/json');
echo json_encode($response);*/
exit();
?>
