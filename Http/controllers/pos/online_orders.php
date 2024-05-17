<?php

use Core\App;
use Core\Database;

$db = App::resolve('Core\Database');

$online_orders = $db->query("SELECT o.*, e.*, p.*, COUNT(o.order_number) AS order_number_count
FROM tblorders o
JOIN tblemployees e ON o.customer_id = e.employeeID
JOIN tblproducts p ON o.base_coffee_id = p.product_id
WHERE order_status = 'notpayed'
GROUP BY o.order_number;
")->get();
// add WHERE position = 'guest' to fetch only guest 
//previous query SELECT DISTINCT * FROM tblorders JOIN tblemployees ON customer_id = employeeID WHERE 1 GROUP BY order_number;

$discount_codes = $db->query("SELECT * from tblpromo WHERE 1")->get();

view('pos/online_orders.view.php', [
   'online_orders' => $online_orders,
   'discount_codes' => $discount_codes
]);
