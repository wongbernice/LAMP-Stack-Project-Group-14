<?php
    $servername = getenv("SERVER_NAME");
    $username = getenv("USERNAME");
    $serverpassword = getenv("SERVER_PASSWORD");
    $db_name = getenv("DB_NAME");
    if($_SERVER['REQUEST_METHOD']=='GET'){
        // GET classes here
    } elseif($_SERVER['REQUEST_METHOD']=='POST'){
        // POST classes here
    }
?>