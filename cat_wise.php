<?php
require_once "session.php";
require_once "./d_connect.php";

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
if (isset($_POST['cat_id'])) {

    $_SESSION['cat_id']= (int) filter_input(INPUT_POST, 'cat_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}


$cat_id = $_SESSION['cat_id'];

if(isset($_POST['page'])){
    $page = (int) filter_input(INPUT_POST, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
}else{
    $page = 1;
}

//Number of book per page
$record_per_page = 2;
//Offset from
$start_from = ($page -1) * $record_per_page;


//Select all books with that cat id
$sql_select = <<<SQL
SELECT * FROM book WHERE cat_id = {$cat_id} LIMIT $start_from,$record_per_page
SQL;
try {
    $result = $db->query($sql_select);
    $result = $result->fetchAll();
} catch (PDOException $ex) {
    exit($ex);
}




$output = <<<HTM
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
    </tr>
HTM;

foreach ($result as $row) {

    $img_add = ($row['book_cover'] !== "default.png") ? '../thumb/' . $row['book_cover'] : '../asset/' . $row['book_cover'];

    $output .= <<<HTM
    <tr>
        <td>{$row['title']}</td>
        <td>{$row['author']}</td>
        <td>{$row['summery']}</td>
        <td>{$row['date_of_pub']}</td>
        <td>{$row['user_name']}</td>
        <td>{$row['copy_avl']}</td>
        <td>{$row['published_at']}</td>

        <td><img src="{$img_add}" alt="No Cover Pic"></td>
    </tr>
HTM;

}

$output .= <<<HTM
</table>
<div id="p_div" align="center">
HTM;

// Total number of records
$sql_select_count = <<<SQL
SELECT COUNT(cat_id) FROM book WHERE cat_id = {$cat_id}
SQL;

try {
    $totl = $db->query($sql_select_count);
    $total_records = $totl->fetch();
} catch (PDOException $ex) {
    exit($ex);
}

$total_pages = ceil($total_records['COUNT(cat_id)']/$record_per_page);

//Page Buttons
for ($i=1; $i <= $total_pages ; $i++) { 
    $output .=<<<HTM
<span class="p_link" style="cursor:pointer; padding:6px;border:1px solid #ccc;" id="{$i}">
{$i}
</span>

HTM;

}

$output .= "</div>";



echo "$output";
?>