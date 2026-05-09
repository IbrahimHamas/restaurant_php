<?php 

include "../connect.php";

$usersid =filterRequest("usersid");
$itemsid = filterRequest("itemsid");
$archiveprice = filterRequest("archiveprice");

$count = getData("cart","cart_itemsid = $itemsid AND cart_usersid = $usersid AND cart.cart_orders = 0",null,false);

$data = array(
    "cart_usersid" => $usersid,
    "cart_itemsid" => $itemsid,
    "cart_archiveprice" => $archiveprice    
);

insertData("cart",$data);
