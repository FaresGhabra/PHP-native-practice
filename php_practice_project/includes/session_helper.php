<?php

if(!function_exists('session')){
    function session(string $key, mixed $value = null):mixed{
        if(!is_null($value)){
            $_SESSION[$key] = $value;
        }
        return !is_null($_SESSION[$key])?$_SESSION[$key]:'';
    }
}


if(!function_exists('session_forget')){
    function session_forget(string $key){
        session_unset($key);
    }
}

if(!function_exists('sessions_delete')){
    function sessions_delete(){
        session_destroy();
    }
}