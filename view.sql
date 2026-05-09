SELECT items1view.* FROM items1view INNER JOIN favorite ON favorite.favorite_itemsid = items1view.items_id AND favorite.favorite_usersid =25


//------------------------- 
SELECT items1view.* , 1 as favorite FROM items1view INNER JOIN favorite ON favorite.favorite_itemsid = items1view.items_id AND favorite.favorite_usersid = 25 UNION ALL SELECT * , 0 as favorite FROM items1view WHERE items_id != (SELECT items1view.items_id FROM items1view INNER JOIN favorite ON favorite.favorite_itemsid = items1view.items_id AND favorite.favorite_usersid = 25 );


//-------------------------
SELECT favorite.* , items.* , users.users_id FROM favorite INNER JOIN users ON
 users.users_id = favorite.favorite_usersid INNER JOIN items ON items.items_id = favorite.favorite_itemsid 



 //----------------------
 SELECT COUNT(cart.cart_id) as countitems FROM cart WHERE cart.cart_usersid = 37 AND cart.cart_itemsid = 1


 CREATE Or REPLACE VIEW cartview as 
SELECT (items.items_price - items.items_price * items.items_discount / 100) as itemsprice , COUNT(cart.cart_itemsid) as countitems ,
 cart.* , items.* From cart
INNER JOIN items ON items.items_id = cart.cart_itemsid 
WHERE cart_orders = 0
GROUP BY cart.cart_itemsid , cart.cart_usersid 

//----------------------------------
CREATE Or REPLACE VIEW cartview as SELECT (items.items_price - items.items_price * items.items_discount / 100) as itemsprice ,
 COUNT(cart.cart_itemsid) as countitems ,(items_price - (items_price * items_discount / 100 )) as afterdiscount ,
 cart.* , items.* From cart INNER JOIN items ON items.items_id = cart.cart_itemsid
WHERE cart_orders = 0
 GROUP BY cart.cart_itemsid , cart.cart_usersid , cart.cart_orders

 // GROUP BY cart.cart_itemsid , cart.cart_usersid , cart.cart_orders it means every order is separeted from another order

 // using GROUP BY because COUNT is found  or sum if it was found , GROUP BY cart.cart_usersid means fetching  data depending on specific users_id

 //---------------------------------

 // this is applied code
 
  CREATE Or REPLACE VIEW ordersdetailsview as 
SELECT (items.items_price - items.items_price * items.items_discount / 100) as itemsprice , COUNT(cart.cart_itemsid) as countitems ,
 cart.* , items.* From cart
INNER JOIN items ON items.items_id = cart.cart_itemsid 
WHERE cart_orders != 0
GROUP BY cart.cart_itemsid , cart.cart_usersid , cart.cart_orders

//-------------------------------------
CREATE or REPLACE view ordersview AS SELECT orders.* , address.* FROM orders RIGHT JOIN address ON address.address_id = orders.orders_address;


//-----------------------------------------
// that is meant code

CREATE or REPLACE view ordersview AS SELECT orders.* , address.* FROM orders LEFT JOIN address ON address.address_id = orders.orders_address;
 
 //-----------------------------------------
 CREATE Or REPLACE VIEW ordersdetailsview as SELECT (items.items_price - items.items_price * items.items_discount / 100) as itemsprice , COUNT(cart.cart_itemsid) as countitems , cart.* , items.* From cart INNER JOIN items ON items.items_id = cart.cart_itemsid
  WHERE cart_orders != 0
   GROUP BY cart.cart_itemsid , cart.cart_usersid , cart.cart_orders;

   //----------------------------------------

   SELECT COUNT(cart_id) as countitems , cart.* FROM cart WHERE cart_orders != 0 GROUP BY cart_itemsid;

   //---------------------------------------

   SELECT COUNT(cart_id) as countitems , cart.* , items.* ,  (items_price - (items_price * items_discount / 100 )) as itemspricediscount FROM cart INNER JOIN items ON items.items_id = cart.cart_itemsid WHERE cart_orders != 0 GROUP BY cart_itemsid;

//-------------------------------------------


CREATE or REPLACE VIEW itemstopselling AS SELECT COUNT(cart_id) as countitems , cart.* , items.* , (items_price - (items_price * items_discount / 100 )) as itemspricediscount FROM cart INNER JOIN items ON items.items_id = cart.cart_itemsid WHERE cart_orders != 0 GROUP BY cart_itemsid;

//----------------------
CREATE OR REPLACE VIEW itemsview as SELECT items.* , categories.* FROM items INNER JOIN categories ON categories.categories_id = items.items_cat
//----------------------
CREATE OR REPLACE VIEW myfavorite AS SELECT favorite.* , items.* , (items_price - (items_price * items_discount / 100 )) as itemspricediscount , users.users_id FROM favorite INNER JOIN users ON users.users_id = favorite.favorite_usersid INNER JOIN items ON items.items_id = favorite.favorite_itemsid;
//--------------------------------



CREATE Or REPLACE VIEW ordersdetailsview as SELECT (items.items_price - items.items_price * items.items_discount / 100) as itemsprice , COUNT(cart.cart_itemsid) as countitems , cart.* , items.* , ordersview.* From cart INNER JOIN items ON items.items_id = cart.cart_itemsid INNER JOIN ordersview ON ordersview.orders_id = cart.cart_orders WHERE cart_orders != 0 GROUP BY cart.cart_itemsid , cart.cart_usersid , cart.cart_orders;