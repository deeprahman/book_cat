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

$cat_id =(int) filter_input(INPUT_POST, 'cat_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

//Select all books with that cat id
$sql_select = <<<SQL
SELECT * FROM book WHERE cat_id = {$cat_id}
SQL;
try{
    $result=$db->query($sql_select);
    $result = $result->fetchAll();
}catch(PDOException $ex){
    exit($ex);
}
$output = <<<HTM
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
echo "$output";
?>