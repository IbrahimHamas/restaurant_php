<?php 

include "connect.php";

$usersid = filterRequest("usersid");
$addressid = filterRequest("addressid");
$orderstype = filterRequest("orderstype");
$pricedelivery = filterRequest("pricedelivery");
$ordersprice = filterRequest("ordersprice");
$couponid = filterRequest("couponid");
$paymentmethod = filterRequest("paymentmethod");
$coupondiscount = filterRequest("coupondiscount");
$userAccessToken = filterRequest("userAccessToken");

if($orderstype == "1"){

    $pricedelivery = 0;
}


$totalprice = $ordersprice + $pricedelivery ;


// check coupon

$now = date("Y-m-d H:i:s");

 $checkcoupon = getData("coupon","coupon_id = '$couponid' AND coupon_expiredate > '$now' AND coupon_count > 0" , null , false);

if($checkcoupon > 0){

// كتبنا ordersprice في العملية الحسابية بدلا من totalprice لكي لا يتم حساب الخصم مع سعر التوصيل

    $totalprice = $totalprice - $ordersprice * $coupondiscount / 100 ;
    
    $stmt = $con->prepare("UPDATE `coupon` SET `coupon_count` = `coupon_count` - 1 WHERE coupon_id = ?");
    $stmt->execute([$couponid]);


}


$data = array(
    "orders_usersid" => $usersid,
    "orders_address" => $addressid, 
    "orders_type" => $orderstype, 
    "orders_pricedelivery" => $pricedelivery, 
    "orders_price" => $ordersprice, 
    "orders_coupon" => $couponid,
    "orders_totalprice" => $totalprice,
    "orders_paymentmethod" => $paymentmethod, 
);

$count = insertData("orders",$data  ,false );

if($count > 0){

    $stmt = $con ->prepare("SELECT MAX(orders_id) from orders");

    $stmt->execute();

    $maxid = $stmt->fetchColumn();

   
   sendGCM("warning" , "A new order has been placed" , "admin" ,$userAccessToken ,"none" , "refreshPendingPage");


    $data = array("cart_orders" => $maxid);

    updateData("cart" , $data , " cart_usersid = $usersid AND cart_orders = 0 ");

    
$stmt2 = $con->prepare("SELECT cart_itemsid FROM cart WHERE cart_usersid = ? AND cart_orders = ?");
$stmt2->execute([$usersid, $maxid]);

$items = $stmt2->fetchAll(PDO::FETCH_ASSOC);

foreach ($items as $item) { 

 $stmt3 = $con->prepare("
    UPDATE items 
    SET items_count = items_count - 1
    WHERE items_id = ?
    AND items_count > 0
");
$stmt3->execute([$item['cart_itemsid']]);

$stmt4 = $con->prepare("
    UPDATE items 
    SET items_active = 0
    WHERE items_id = ?
    AND items_count = 0
");
$stmt4->execute([$item['cart_itemsid']]);         
         }

}


