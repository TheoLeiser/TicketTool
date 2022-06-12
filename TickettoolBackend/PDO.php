<?php
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    
    $connect = new PDO("mysql:host=localhost;dbname=tickettool", "root", "");
?>