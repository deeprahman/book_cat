<?php
require_once "../session.php";
require_once __DIR__."/header.html.php";
require_once "../d_connect.php";



if(!isset($_SESSION['admin']) || $_GET['usr_id'] != $_SESSION['admin']){
    header("location:../");
    exit();
}


// Get the data from the boo.html.php page
$update = filter_input(INPUT_GET,'update',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$book_id = filter_input(INPUT_GET,'book_id',FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$user_id = filter_input(INPUT_GET,'usr_id',FILTER_SANITIZE_FULL_SPECIAL_CHARS);



//Select id specific user name from admin table
$sql_select = "SELECT user_name FROM admin WHERE id='$user_id'";
 //get the user name from admin table
 try{
    $user_name = $db->query($sql_select);
    $user_name = $user_name->fetch();
    $user_name = $user_name['user_name'];
 }catch(PDOException $ex){
    exit($ex);
 }

//Select book to be updated


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
    'c.name'
    
];


$fields = implode(",", $field_array);

$sql_select = <<<SQL
SELECT {$fields} FROM book b INNER JOIN categories c ON b.cat_id=c.id WHERE (b.id={$book_id} AND b.user_name = "{$user_name}")
SQL;
try{
    $result=$db->query($sql_select);
    $result = $result->fetch();
    if(empty($result)){
        $_SESSION['msg'] = "Book Not Found!";
        header("location:../");
        exit();
    }
}catch(PDOException $ex){
    exit($ex);
}


//Store the book id the session
$_SESSION['id'] = $book_id;

//Get the book cover name
$book_cover = $result['book_cover'];

//Select all top category

//Select all name and id from category table

$sql_select_all_cat = <<<SQL
SELECT id, name FROM categories WHERE parent_id = 0;
SQL;

try{
    $top_cat = $db->query($sql_select_all_cat);
    $top_cat = $top_cat->fetchAll();
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
<h1>Update about the book</h1>
<!-- Book information -->
<form action="../update.php" method="post" enctype="multipart/form-data">
    <label class="block" for="title">Book Title:
        <input type="text" name="title" value="<?=$result['title']?>">
    </label>
    <br>
    <label class="block" for="author">Author name
        <input type="text" name="author" value="<?=$result['author']?>">
    </label>
    <br>

    <label for="top_cat">Top Category:
        <select name="top" id="category">
        <option value="0">No Category Selected</option>
        <?php foreach($top_cat as $row):?>
        <option value="<?=$row['id']?>"><?=$row['name']?></option>
        <?php endforeach?>    
        </select>
    </label>

    <br><br>
    <label for="sub_cat">Sub Category:
        <select name="sub_cat" id="sub">
            <option value="0" selected>No Sub Category Seected</option>
        </select>
    </label>
    <br><br>

    <label class="block" for="date_pub">Date of publication:
        <input id="date_pub" type="date" name="date_pub" value="<?=$result['date_of_pub']?>" placeholder="EX @ 2018-11-04">
    </label>
    
    <label class="block" for="avl_copy">Number of available copy of book:
        <input id="avl_copy" type="text" name="avl_copy" value="<?=$result['copy_avl']?>">
    </label>
    <textarea class="block" name="summery" id="" cols="30" rows="10"><?=$result['summery']?></textarea>
    <label class="block" for="pic"><br><br>Current Book Cover<br>
        <img id="pic" src="<?="../thumb/".$result['book_cover']?>" alt="No Cover Pic avalilable">
        <button id="remove" type="button">Remove</button>
        <br><br>
    </label>
    <label for="file">
        <input id="file" type="file" name="image">
    </label>
    <button class="block" type="submit" name="update_book" value="submit">UPDATE THE BOOK</button>
</form>
<!-- make user id and  book cover hidden -->
<span id="user_id" hidden><?=$_SESSION['admin']?></span>
<span id="book_cover" hidden><?=$book_cover?></span>
<script src="./js/remove.js"></script>
<script src="./js/cat_ajax.js"></script>
<!-- ---------------------------------------------------------------------------------------------- -->
<?php
require_once __DIR__."/footer.html.php";
?> 
