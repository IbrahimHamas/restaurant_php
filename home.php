<?php 

include "connect.php";

$alldata =array();

$alldata['status'] ="success";
$categories = getAllData("categories",null,null,false);

$alldata['categories'] = $categories;




$items = getAllData("itemstopselling","1 = 1 ORDER BY countitems DESC",null,false);

$alldata['itemstopselling'] = $items;



echo json_encode($alldata);

?>