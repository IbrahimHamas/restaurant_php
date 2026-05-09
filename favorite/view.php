<?php

include "../connect.php";

$id =  filterRequest("id");

getAllData("myfavorite","favorite_usersid = ?",array($id));


// لو يوجد اكثر من متجر او اي شئ اخر  نضيف ال id للجدول لمتجر معين