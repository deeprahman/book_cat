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

// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
if( isset($_POST['add_cat']) && !empty($_POST['sub'])){

    $add_top_cat = filter_input(INPUT_POST, 'top', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $add_sub_cat = filter_input(INPUT_POST, 'sub', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $desc = filter_input(INPUT_POST, 'des', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    include_once "../mics_include/cat_top_exist.php";
    header("location:./show_cat.html.php");
}



// +++++++++++++++++++fetching result for Top and Sub catagory++++++++++++++++++++

//Selecting all top category

$sql_select_all_top = <<<SQL
SELECT * FROM categories WHERE parent_id = 0
SQL;

try {
    $result = $db->query($sql_select_all_top);
    $result_top = $result->fetchAll();
} catch (PDOException $ex) {
    exit($ex);
}
// ++++++++++++++++++Select corresponding Sub category++++++++++++++++++++++++++++++++++

//Search database for id of the parent category

//Only run If $sel_top_cat is not empty
// if (!empty($sel_top_cat)) {
//     $sql_select_id_par = <<<SQL
// SELECT name FROM categories WHERE parent_id= $sel_top_cat
// SQL;
//     try {
//         $search_sub_cat = $db->query($sql_select_id_par);
//         $result_sub = $search_sub_cat->fetchAll();
//     } catch (PDOException $ex) {
//         exit($ex);
//     }

// }

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

<h1>Add Category Page</h1>
<a href="./show_cat.html.php">Back To Category Table</a>
<br><br><br>
<form action="" method="post">Sub Category name:
    <label for="sub_cat">
        <input type="text" name="sub" value="">
    </label>
    <br><br>
    <label for="cat_des">Category Description
        <input type="text" name="des" value>
    </label>
    <br><br>
    <label for="top">Top Category
        <select name="top" id="top">
        <option value="">No Category Selected</option>
        <?php if (!empty($result_top)): ?>
        <?php foreach ($result_top as $row): ?>
        <option value="<?=$row['id']?>"><?=$row['name']?></option>
    <?php endforeach?>
    <?php endif?>
        </select>
    </label>
    <br><br>
    <button name="add_cat" type="submit">Add Category</button>
</form>


<?php
require_once __DIR__ . "/footer.html.php";
?>
