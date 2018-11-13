<?php

/**
 * top category(variable name):$cat
 * sub category(variable name):$sub_cat
 */

//Query into database, if the top category exists:
//Prepared statement
$sql_select_cat = <<<SQL
SELECT * FROM categories WHERE name ='{$cat}'
SQL;
try {
    $prep = $db->prepare($sql_select_cat);
    $prep->execute();
    $result = $prep->fetch();
} catch (PDOException $ex) {
    exit($ex);
}

//Top category not exists, create top category
if (!$result) {
    $sql_insert_top_cat = <<<SQL
INSERT INTO categories SET name='{$cat}'
SQL;

    try {
        $prep = $db->prepare($sql_insert_top_cat);

        $prep->execute();
        $parent_id = (int) $db->lastInsertId();
    } catch (PDOException $ex) {
        exit($ex);
    }
 
} else {
    $parent_id = (int) $result['id'];
}


//If the sub-category has not empty value, enter the sub-category with parent_id is equal to  the id of
//corresponding pparent category
if (!empty($sub_cat)) {
    $sql_insert_sub_cat = <<<SQL
INSERT INTO categories(name,parent_id) VALUES('{$sub_cat}','{$parent_id}')
SQL;

    try {
        $insert= $db->exec($sql_insert_sub_cat);
        $sub_cat_id = $db->lastInsertId();
    } catch (PDOException $ex) {
        exit($ex);
    }

}

exit("end");
