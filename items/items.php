

        <?php

include "../connect.php";

$categoryid = filterRequest("categoryid");
$userid = filterRequest("usersid");

$stmt = $con->prepare("
SELECT 
    itemsview.* , 
    1 as favorite , 
    (items_price - (items_price * items_discount / 100)) as itemspricediscount 
FROM itemsview
INNER JOIN favorite 
    ON favorite.favorite_itemsid = itemsview.items_id 
    AND favorite.favorite_usersid = ?
WHERE categories_id = ? AND items_active > 0

UNION ALL

SELECT 
    itemsview.* , 
    0 as favorite , 
    (items_price - (items_price * items_discount / 100)) as itemspricediscount 
FROM itemsview 
WHERE categories_id = ? AND items_active > 0
AND items_id NOT IN (
    SELECT itemsview.items_id 
    FROM itemsview 
    INNER JOIN favorite 
        ON favorite.favorite_itemsid = itemsview.items_id 
        AND favorite.favorite_usersid = ?
)
");

$stmt->execute([$userid, $categoryid, $categoryid, $userid]);

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
$count = $stmt->rowCount();

if ($count > 0) {
    echo json_encode(["status" => "success", "data" => $data]);
} else {
    echo json_encode(["status" => "failure"]);
}