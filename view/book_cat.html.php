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

<h1 class ="center">BooK by Category</h1>
<!-- Add book -->
<br>


<!-- ---------------------------------------------------------------------------------- -->

<br>
<br>
<!-- =========================Showing Books Category wise============================ -->
<label for="top">Filter by
<select name="top" id="category">
        <option value="0">Top Category</option>
        <?php foreach ($top_cat as $row): ?>
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

<table>
    <tr>

        <th>Title</th>
        <th>Author</th>
        <th>Summery</th>
        <th>Date of Publication</th>
        <th>Book Added By</th>
        <th>Number of Available Copy</th>
        <th>Published At</th>
        <th>Cover Picture</th>
        <th>Action</th>
        <th>Category</th>

    </tr>
    <!-- Table body like book.html.php page -->
</table>
<script src="./js/cat_ajax.js"></script>



<!-- ====================================================================================================== -->

<?php
require_once __DIR__ . "/footer.html.php";
?>
