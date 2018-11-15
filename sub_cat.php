<?php
require_once "session.php";

include __DIR__ . "/d_connect.php";

if (!isset($_SESSION['admin'])) {
    header("location:.");
    exit();
}

//Select id specific user name from admin table
$sql_select = "SELECT user_name FROM admin WHERE id='{$_SESSION['admin']}'";
//get the user name
try {
    $user_name = $db->query($sql_select);
    $user_name = $user_name->fetch();
    $user_name_book = $user_name['user_name'];
    if (!isset($user_name_book)) {
        $_SESSION['msg'] = "User not found!";
        header("location:.");
        exit();
    }
} catch (PDOException $ex) {
    exit($ex);
}
?>

<?php

$parent_id = filter_input(INPUT_POST, 'cat_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$output = "<option value=''>Select Sub Category</option>";
//Select all from categories where parent id is parent_id
$sql_select_sub = <<<SQL
SELECT * FROM categories WHERE parent_id = '{$parent_id}'
SQL;
try{
    $result = $db->query($sql_select_sub);
    $result = $result->fetchAll();
}catch(PDOException $ex){
    exit($ex);
}

foreach ($result as $row) {
    $output .= "<option value='{$row['id']}'>{$row['name']}</option>";
}

echo "$output";

?>