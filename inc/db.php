<?php

    $dns      = "mysql:host=mysql5044.site4now.net; dbname=db_a6d541_cms2021";
    // $dns      = "mysql:host=localhost; dbname=my-cms";
    $username = "a6d541_cms2021";
    // $username = "root";
    $pass     = "abc@123456";
    // $pass     = "";

    try {
        $pdo = new PDO($dns , $username , $pass);
    } catch (PDOException $e) {
        echo $e->getMessage();
    }


