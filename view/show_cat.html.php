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

//Selecting all category from database
$sql_select_cat = <<<SQL
SELECT * FROM categories
SQL;

try{
$result = $db->query($sql_select_cat);
$result = $result->fetchAll();
}catch(PDOException $ex){
    exit($ex);
}


?>



<!-- --------------------------------Template------------------------------------------------------ -->

<style>
 table, th, td {
    border: 1px solid black;
    text-align: center;
}
.center{
    text-align:center;
}

</style>
<h1>The Catagory Page</h1>
<br><hr>
<a class="center" href="..">Book View</a>
<br><br>
<a class="center" href="./category.html.php">Add New Category</a>

<!-- --------------Catagory Table--------------------- -->
<table>
    <tr>
        <th>Category ID</th>
        <th>Category Name</th>
        <th>Category Type</th>
        <th>Description</th>
        <th>Action</th>
        
    </tr>
    <?php foreach ($result as $row): ?>
        <tr>
            <td><?=$row['id']?></td>
            <td><?=$row['name']?></td>
            <!-- ----------------------------- -->
            <?php if($row['parent_id'] != 0){
                $sql_select="SELECT name FROM  categories WHERE id= {$row['parent_id']} ";
                try{
                    $result = $db->query($sql_select); 
                    $result= $result->fetch();
                    $name = $result['name']; 
                }catch(PDOException $ex){
                    exit($ex);
                }
                echo "<td>$name</td>";
            }else{
                echo "<td>Parent</td>";
            }   
            ?>  
            <!-- -------------------------------------- -->
            
            <td><?=$row['descrip']?></td>
            <td><a onclick="return confirm('Do you want to delete the book?')" href="../delete_cat.php?parent=<?=$row['parent_id']?>&cat_id=<?=$row['id']?>">Delete Category</a> / <a href="./edit_cat.html.php?parent=<?=$row['parent_id']?>&cat_id=<?=$row['id']?>">Edit Category</a></td>

            
        </tr>
    <?php endforeach?>
</table>
<!-- =================================================================================================== -->

<?php
require_once __DIR__ . "/footer.html.php";
?>
