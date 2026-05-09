<?php

include "../connect.php";

$couponName = filterRequest("couponname");

$now = date("Y-m-d H:i:s");

// ✅ تحديث الكوبون مباشرة
$stmt = $con->prepare("
UPDATE coupon 
SET coupon_count = coupon_count - 1 
WHERE coupon_name = ? 
AND coupon_expiredate > ? 
AND coupon_count > 0
");

$stmt->execute([$couponName, $now]);

// ✅ لو اتأثر صف → الكوبون شغال
if ($stmt->rowCount() > 0) {

    // نجيب بيانات الكوبون بعد التحديث
    $stmt2 = $con->prepare("SELECT * FROM coupon WHERE coupon_name = ?");
    $stmt2->execute([$couponName]);
    $data = $stmt2->fetch(PDO::FETCH_ASSOC);

    echo json_encode([
        "status" => "success",
        "data" => $data
    ]);

} else {

    echo json_encode([
        "status" => "fail",
    ]);
}