<?php
//Select all name and id from category table

$sql_select_all_cat = <<<SQL
SELECT id, name FROM categories WHERE parent_id = 0;
SQL;

try{
    $fetch_top = $db->query($sql_select_all_cat);
    $fetch_top = $fetch_top->fetchAll();
}catch(PDOException $ex){
    exit($ex);
}
