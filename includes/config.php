<?php 

// database
$dbhost = "localhost";
$dbname = "projectuser";
$dbuser = "root";
$dbpass = "";
$dbcharset = "utf8";

function base_url($page = null){
    $url = "http://localhost/projectuser/";
    $result = $url . $page;
    return $result;
}