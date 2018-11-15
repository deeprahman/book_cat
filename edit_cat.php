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

if(!empty($_POST['edit_cat'])){

$name=filter_input(INPUT_POST, 'cat', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$des=filter_input(INPUT_POST, 'des', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
if(isset($_POST['top'])){
    $parent=(int)filter_input(INPUT_POST, 'top', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}
$id=(int)filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

//Information for current selected category
$sql_select_cat =<<<SQL
SELECT * FROM categories WHERE id='{$id}'
SQL;

try{
    $current_cat = $db->query($sql_select_cat);
    $current_cat = $current_cat->fetch();
}catch(PDOException $ex){
    exit($ex);
}
//changing the category name and descript tion when parent_id =0

if($current_cat['parent_id'] == 0){
    $sql_update=<<<SQL
    UPDATE categories SET name = '{$name}', descrip = '{$des}'
    WHERE id = {$id}
SQL;
}else{
    $sql_update=<<<SQL
    UPDATE categories SET name = '{$name}', descrip = '{$des}', parent_id='{$parent}'
    WHERE id = {$id}
SQL;
}

try{
    $update = $db->exec($sql_update);

}catch(PDOException $ex){
    exit();
}

exit();
}


?>