<?php

/**
 * Insert Data in Database
 * @param string $table
 * @param array $ data
 * @return array as assoc
 */

if(!function_exists('db_create')){
    function db_create($table ,array $data):array{
        $sql = "INSERT INTO ".$table;
        $columns = '';
        $values = '';

        foreach($data as $key=>$value){
            $columns .= $key.",";
            $values .= "'".$value."',";   
        }
        $columns = rtrim( $columns, ',' );
        $values  = rtrim( $values, "," );
        $sql .= "(".$columns.") VALUES (". $values .")";

        $id = mysqli_insert_id($GLOBALS['connect']);
        $first = mysqli_query($GLOBALS['connect'],"select * from  ".$table." where id=".$id);
        $GLOBALS['query'] = $first;
        $data = mysqli_fetch_assoc($first);
        return $data;
    }
}

/**
 * Updating Data In Database
 * @param string $table
 * @param int $id
 * @param array $data
 * @return array as assoc
 */

 if(!function_exists('db_update')){
    function db_update(string $table,array $data,int $id):array{
        $sql = "Update ".$table." set ";
        $column_value = '';

        foreach($data as $key=>$value){
            $column_value .= $key."='".$value."',";
        }
        $column_value = rtrim( $column_value, ',' );
        $sql .= $column_value." where id = ".$id;

        mysqli_query($GLOBALS['connect'],$sql);
        $first = mysqli_query($GLOBALS['connect'],"select * from  ".$table." where id=".$id);
        $GLOBALS['query']=$first;
        $data = mysqli_fetch_assoc($first);
        return $data;
    }
 }

 /**
  * Deleting Data From DB
  * @param string $table
  * @param  int $id
  */

if(!function_exists("db_delete")){
    function db_delete(string $table,int $id):mixed{
        $query = mysqli_query($GLOBALS['connect'],"delete from ".$table." where id = ".$id);
        $GLOBALS['query'] = $query;
        return $query;
    }
}


 /**
  * Get Single Row From DB
  * @param string $table
  * @param  int $id
  */

  if(!function_exists("db_find")){
    function db_find(string $table,int $id):mixed{
        $query = mysqli_query($GLOBALS['connect'],"select * from ".$table." where id = ".$id);
        $GLOBALS['query'] = $query;
        $data = mysqli_fetch_assoc($query);
        return $data;
    }
}



 /**
  * Search for a Single Row From DB
  * @param string $table
  * @param  string $query_str (email = "blabla@blabla.com") || (salary >= 70) || ...etc
  */

if(!function_exists("db_first")){
    function db_first(string $table,string $query_str):mixed{
        $query = mysqli_query($GLOBALS['connect'],"select * from ".$table." where ".$query_str);
        $GLOBALS['query'] = $query;
        $data = mysqli_fetch_assoc($query);
        return $data;
    }
}

 /**
  * Search for a multiple Row From DB
  * @param string $table
  * @param  string $query_str OPTIONAL (email = "blabla@blabla.com") || (salary >= 70) || ...etc
  */

if(!function_exists("db_get")){
    function db_get(string $table,string $query_str = "1"):mixed{
        $query = mysqli_query($GLOBALS['connect'],"select * from ".$table." where ".$query_str);
        $GLOBALS['query'] = $query;
        $num = mysqli_num_rows( $query );
        $data = [];
        if($num > 0){
            while($row = mysqli_fetch_assoc($query)){
                $data[] = $row; 
            }
        }
        return $data;
    }
}


 /**
  * Search for a multiple Row From DB and make pagination
  * @param string $table
  * @param int $limit
  * @param  string $query_str OPTIONAL (email = "blabla@blabla.com") || (salary >= 70) || ...etc
  */

if(!function_exists("db_paginate")){
    function db_paginate(string $table,string $query_str = "1",int $limit = 1):mixed{
        if(isset($_GET['page']) && is_numeric($_GET['page']) && $_GET['page'] > 0){
            $current_page = $_GET['page'] - 1;
        }
        else{
            $current_page = 0;
        }
        $count_query = mysqli_query($GLOBALS['connect'],"select COUNT(id) from ".$table." where ".$query_str);
        $count = mysqli_fetch_row($count_query);
        $count = (int)$count[0];
        $total_pages = ceil($count/ $limit);
        $start = $current_page *  $limit;

        $query = mysqli_query($GLOBALS['connect'],"select * from ".$table." where ".$query_str." LIMIT {$start},{$limit}");
        $GLOBALS['query'] = $query;
        $num = mysqli_num_rows( $query );
        $data = [];
        if($num > 0){
            while($row = mysqli_fetch_assoc($query)){
                $data[] = $row; 
            }
        }
        $pages_links = [];
        for($i=1;$i<=$total_pages;$i++){
            $pages_links[] = '<a href = "?page='.$i.'">'."page".$i."<a\>";
        }
        return ['total pages' => $total_pages,'data' => $data ,'links'=>$pages_links];
    }
}

var_dump(db_paginate('users'));