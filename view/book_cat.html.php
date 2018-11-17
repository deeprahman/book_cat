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


//Feth all top category
include_once "../mics_include/top_cat_fetch.php";


//Select all  uploaded books from the book table

// An array containing database fields
$field_array = ['b.id as book_id',
    'b.title',
    'b.author',
    'b.summery',
    'b.date_of_pub',
    'b.copy_avl',
    'b.book_cover',
    'b.published_at',
    'b.user_name',
    'b.cat_id',
    'c.id',
    'c.name',

];

$fields = implode(",", $field_array);

$sql_select = "SELECT $fields FROM book b LEFT JOIN categories c ON b.cat_id=c.id WHERE user_name='$user_name' ";
try {
    $result = $db->query($sql_select);
    $result = $result->fetchAll();
} catch (PDOExtension $ex) {
    exit($ex);
}




?>

<!-- ===============================Template========================================================== -->
<style>
 table, th, td {
    border: 1px solid black;
    text-align: center;
}
.center{
    text-align:center;
}

</style>

<!-- Show message when user name and password does not match -->
<?php if (isset($_SESSION['msg'])) {
    echo "<br>" . $_SESSION['msg'] . "<br><hr><br>";
    unset($_SESSION['msg']);
}?>

<h1 class ="center">Category-wise Book View</h1>
<!-- Add book -->
<br>


<!-- ---------------------------------------------------------------------------------- -->

<br>
<br>
<!-- =========================Showing Books Category wise============================ -->
<label for="top">Filter by
<select name="top" id="category">
        <option value="0">Top Category</option>
        <?php foreach ($fetch_top as $row): ?>
        <option value="<?=$row['id']?>"><?=$row['name']?></option>
        <?php endforeach?>
        </select>
</label>
<label for="sub">
        <select name="sub_cat" id="sub">
            <option value="0" selected>Sub Category</option>
        </select>
    </label>
<br><br>
<!-- ====================================================================== -->
<a href="./show_cat.html.php">Category Table</a>
<br>
<a href="../">Book View</a>
<br>
<br>
<hr>

<table id="show">
    
</table>
<script src="./js/cat_ajax.js"></script>
<script src="./js/top_sub_ajax.js"></script>


<!-- ====================================================================================================== -->

<?php
require_once __DIR__ . "/footer.html.php";
?>
