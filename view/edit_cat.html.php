<?php
require_once __DIR__ . "/header.html.php";
?>
<?php
// Select all from table book
require_once "../d_connect.php";

if (!isset($_SESSION['admin'])) {
    header("location:../");
    exit();
}

$user_id = $_SESSION["admin"];

//Select id specific user name from admin table
$sql_select = "SELECT user_name FROM admin WHERE id='$user_id'";
//get the user name
try {
    $user_name = $db->query($sql_select);
    $user_name = $user_name->fetch();
    $user_name = $user_name['user_name'];
} catch (PDOException $ex) {
    exit($ex);
}
?>


<?php

if (isset($_GET['parent'])) {

    $parent = (int) filter_input(INPUT_GET, 'parent', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $cat_id = (int) filter_input(INPUT_GET, 'cat_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

//Selecting all top category
    $sql_select_all_top = <<<SQL
SELECT * FROM categories WHERE parent_id = 0
SQL;

//Select category to be edited
    $sql_select_edit = <<<SQL
SELECT id, name, descrip FROM categories WHERE id= $cat_id;
SQL;

    try {
        $edit=$db->query($sql_select_edit);
        $edit = $edit->fetch();

        $result = $db->query($sql_select_all_top);
        $result = $result->fetchAll();
    } catch (PDOException $ex) {
        exit($ex);
    }
}


?>




<!-- -----------------TEMPLATE Begins------------------------------------------------------------------------------ -->
<style>
 table, th, td {
    border: 1px solid black;
    text-align: center;
}
.center{
    text-align:center;
}
</style>

<h1>Edit Category</h1>
<hr>

<form action="../edit_cat.php" method="post">Category name:
    <label for="sub_cat">
        <input type="text" name="cat" value="<?=$edit['name']?>">
    </label>
    <br><br>
    <label for="cat_des">Category Description
        <input type="text" name="des" value="<?=$edit['descrip']?>">
    </label>
    <br><br>
    <?php if($parent !== 0):?>
    <label for="top">Top Category
        <select name="top" id="top">
        <option value="0">No Category Selected</option>
        <?php foreach($result as $row):?>
        
        <option value="<?=$row['id']?>"><?=$row['name']?></option>
        <?php endforeach?>    
        </select>
    </label>
    <?php endif?>
    <input type="text" name="id" value="<?=$edit['id']?>" hidden>
    <br><br>
    <button name="edit_cat" value="edit" type="submit">Edit Category</button>
</form>

<?php
require_once __DIR__ . "/footer.html.php";
?>
