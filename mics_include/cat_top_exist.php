<?php

/**
 * top category(variable name):$add_top_cat
 * sub category(variable name):$add_sub_cat
 */

//Query into database, if the top category exists:
//Prepared statement


//If the top catecory is empty, enter as parent
if(empty($add_top_cat)){
    $sql_insert_top_cat = <<<SQL
INSERT INTO categories SET name='{$add_sub_cat}', descrip='{$desc}'
SQL;

    try {
        $prep = $db->prepare($sql_insert_top_cat);
        $prep->execute();
    } catch (PDOException $ex) {
        exit($ex);
    }
}else{
    $sql_insert_sub_cat =<<<SQL
INSERT INTO categories SET name= "{$add_sub_cat}",descrip='{$desc}', parent_id='{$add_top_cat}'
SQL;

try {
    $prep = $db->prepare($sql_insert_sub_cat);
    $prep->execute();
} catch (PDOException $ex) {
    exit($ex);
}


}



