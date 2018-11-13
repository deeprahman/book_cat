<?php
//Include the database connection
if (!isset($_SESSION['admin'])) {
    header("location:.");
    exit();
}
use classes\FileUplaod;
use classes\ImageResize;

require_once "d_connect.php";

//include the PHP file for classes
include "classes/Fileupload.php";
include "classes/ImageResize.php";
//Instantiate the FileUpload class
$file_uplaod = new FileUplaod($_SESSION['file'], true);

// Get the information from the form for adding the book
$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$author = filter_input(INPUT_POST, 'author', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$summery = filter_input(INPUT_POST, 'summery', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$date_pub = filter_input(INPUT_POST, 'date_pub', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$avs_copy = (int) filter_input(INPUT_POST, 'avl_copy', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$cat = filter_input(INPUT_POST, 'top_cat', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$sub_cat = filter_input(INPUT_POST, 'sub_cat', FILTER_SANITIZE_FULL_SPECIAL_CHARS);




$user_id = $_SESSION["admin"];
if ($_SESSION['file']['error'] == UPLOAD_ERR_OK) {
    $img_new_name = $file_uplaod->getUnique();
} else {
    $img_new_name = "default.png";
}


/**
 * Query into the database if the top category exists;
 * If the top category does not exists then create the top category using the given name with parent_id :0 and
 * get the id.
 * If the top category exists, get the id
 * 
 * If the sub category is not empty Enter the sub-catecory with  with the parent_id  equal to the id of the correnponsing
 * parent category
 */

include_once "mics_include/cat_top_exist.php";



//find the user name
$sql_select = "SELECT user_name FROM admin WHERE id='$user_id'";

//Insert query for the category table, get the lastInsertID
$sql_insert_cat = <<<SQL
INSERT INTO categories(name, status, parent_id) VALUES(:name, :status, :parent_id)
SQL;

//Insert query for book table, use the lastInsertId from the insert query for category table
$sql_insert_book = "INSERT INTO book (title,author,summery,date_of_pub,copy_avl,book_cover,user_name) VALUES (:title,:author,:summery,:date_of_pub,:copy_avl,:book_cover,:user_name)";
try {
    //get the user name
    $user_name = $db->query($sql_select);
    $user_name = $user_name->fetch();
    $user_name = $user_name['user_name'];

    //Enter Book info in the database
    $prep = $db->prepare($sql_insert_book);
    $params = [
        ':title' => $title,
        ':author' => $author,
        ':summery' => $summery,
        ':date_of_pub' => $date_pub,
        ':copy_avl' => $avs_copy,
        ':book_cover' => $img_new_name,
        ':user_name' => $user_name,
    ];
    $prep->execute($params);

} catch (PDOException $ex) {
    $_SESSION['msg'] = $ex->getMessage();
    exit();
}

// File upload section

//Check if the file is uploaded and the submit button is clicked
if ($_SESSION['file']['error'] == UPLOAD_ERR_OK) {
    //Limit upload file size
    if (filesize($_SESSION['file']['tmp_name']) > 4000000) {
        header("location:index.php");
        exit();
    }

    //Restrict MIME type
    $alowed_mime = ["image/jpeg", "image/png"];
    if (!in_array($file_uplaod->chkMime(), $alowed_mime)) {
        $_SESSION['msg'] = "Your Image couldnot be uploaded <br> Please upload image of JPEG or PNG type ";
        header('location:.');
        exit();
    }
    //Move file to specified directory
    $tar_dir = __DIR__ . "/files";
    $upload_status = $file_uplaod->moveFile($tar_dir);
    if (!$upload_status) {
        $_SESSION['msg'] = "Someting whent wrong when uploading pic!!!";
        header('location:.');
        exit();
    }
    /**
     * Image Resize
     */
    if ($img_new_name !== "default.png") {
        $target = $img_new_name;
        $destination = "./thumb";
        //Instantiatie ImageResize class
        $resize = new ImageResize($target, $destination);

        if (!$resize->thumbNail()) {
            $_SESSION['msg'] = "Image cannot be resized";
            header("location:.");
            exit();
        }

    }

}

header('location:.');
