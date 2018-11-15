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

if (isset($_GET['parent'])) {

    $parent = (int) filter_input(INPUT_GET, 'parent', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cat_id = (int) filter_input(INPUT_GET, 'cat_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

//parent id is 0, delete that category and all corresponding sub category
    if ($parent === 0) {
        $sql_delete = <<<SQL
DELETE FROM categories WHERE (id = '{$cat_id}' OR parent_id= '{$cat_id}')
SQL;

    } else {
        $sql_delete = <<<SQL
    DELETE FROM categories WHERE id = '{$cat_id}'
SQL;

    }

    try {
        $delete = $db->exec($sql_delete);
    } catch (PDOException $ex) {
        exit($ex);
    }
}
header("location:./view/show_cat.html.php");
