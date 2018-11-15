<?php
include_once "../session.php";
if(!isset($_SESSION['admin'])){
    header("location:../");
    exit();
}

require_once __DIR__."/header.html.php";
require_once "../d_connect.php";
?> 

<?php
//Select all name and id from category table

$sql_select_all_cat = <<<SQL
SELECT id, name FROM categories WHERE parent_id = 0;
SQL;

try{
    $result = $db->query($sql_select_all_cat);
    $result = $result->fetchAll();
}catch(PDOException $ex){
    exit($ex);
}

?>
<!-- ---------------------------------------------------------------------------------------------- -->
<style>
 .block{
     display: block;
 }
</style>
<?php 
?>
<h1>Enter info about the book</h1>
<!-- Book information -->
<form action="../index.php" method="post" enctype="multipart/form-data">
    <label class="block" for="title">Book Title:
        <input type="text" name="title" value="" required>
    </label>
    <br>
    <label class="block"  for="author">Author name
        <input type="text" name="author" value="" required>
    </label>
    <br>
    <label for="top_cat">Top Category:
        <select name="top" id="category">
        <option value="0">No Category Selected</option>
        <?php foreach($result as $row):?>
        <option value="<?=$row['id']?>"><?=$row['name']?></option>
        <?php endforeach?>    
        </select>
    </label>
    <br><br>
    <label for="sub">Sub Category:
        <select name="sub_cat" id="sub">
            <option value="0" selected>No Sub Category Seected</option>
        </select>
    </label>
    <br><br>
    <label class="block"  class="block"  for="date_pub">Date of publication:
        <input id="date_pub" type="date" name="date_pub" value="" placeholder="EX@ 2018-11-04" required>
    </label>
    <br>
       <label class="block"  for="avl_copy">Number of available copy of book:
        <input id="avl_copy" type="text" name="avl_copy" required>
    </label>
    <br>
    <textarea class="block"  name="summery" id="" cols="30" rows="10">Add Book Description</textarea>
    <br>
    <label class="block" for="file"> 
        <input id="file" type="file" name="image">
    </label>
    <br>
    <button type="submit" name="add_book" value="submit">ADD THE BOOK</button>
</form>
<script src="./js/cat_ajax.js"></script>
<!-- ---------------------------------------------------------------------------------------------- -->
<?php
require_once __DIR__."/footer.html.php";
?> 
