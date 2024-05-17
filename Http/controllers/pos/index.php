<?php

use Core\App;
use Core\Database;

$db = App::resolve('Core\Database');

$discount_codes = $db->query("SELECT * from tblpromo WHERE 1")->get();
$newOrder = $db->query("SELECT MAX(order_number) as last_order FROM tblorders")->find();
$newOrder = $newOrder['last_order'] + 1;

view('pos/index.view.php', [
    'discount_codes' => $discount_codes,
    'newOrder' => $newOrder,
]);
