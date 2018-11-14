<?php
require_once "session.php";
header("Content-Type: application/json");
//Database connection
require_once "d_connect.php";

// Execute only if logged in
if (!isset($_SESSION['admin'])) {
    header("location:.");
    exit();
}

//Selecting all top category

$sql_select_all_top = <<<SQL
SELECT name FROM categories WHERE parent_id = 0
SQL;

try {
    $result = $db->query($sql_select_all_top);
    $result_top = $result->fetchAll();
} catch (PDOException $ex) {
    exit($ex);
}
foreach ($result_top as $key => $value) {
    $result_a[$key] = $value;    
}

echo json_encode($result_a);

exit();