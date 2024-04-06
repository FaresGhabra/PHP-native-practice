<?php

ob_start();
session_start();
require_once __DIR__."/includes/app.php";


// $data = db_create('users',[
//     'name'=>'phpAnonymous',
//     'email'=>'anonymous@php.com',
//     'password'=>'123456',
//     'phone'=> 951230933]);


// db_update('users',[
//     'name'=>'FaresGH',
//     'email'=>'Faresgh@gmail.com',
//     'phone'=>'0951230933'
//  ],1) ;

//db_delete('users',4);

//db_find('users',1);

// db_first('users',' name LIKE "%res%"');

// db_get('users');

// db_paginate('users'," name = Mhmd", 3);




if(!empty($GLOBALS['query'])){
    mysqli_free_result($GLOBALS['query']);
}
mysqli_close($connect);

ob_end_clean();
ob_end_flush();
