<?php
include_once "../session.php";
if(!isset($_SESSION['admin'])){
    header("location:../");
    exit();
}

require_once __DIR__."/header.html.php";
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
        <input id="top_cat" type="text" name="top_cat" value="">
    </label>
    <br><br>
    <label for="sub_cat">Sub Category:
        <input id="sub_cat" type="text" name="sub_cat" value="">
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
<!-- ---------------------------------------------------------------------------------------------- -->
<?php
require_once __DIR__."/footer.html.php";
?> 
