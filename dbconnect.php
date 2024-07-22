<?php
try{
    $server_name = "localhost";
    $mysqlport = "3306";
    $dbname = "my_blog";
    $dbuser = "root";
    $dbpassword = "";

    //Data Source name
    $dsn = "mysql:host=$server_name;port=$mysqlport;dbname=$dbname"; 
    //Create a PDO instance
    $conn = new PDO($dsn, $dbuser, $dbpassword);
    //set error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // echo "Connection success";
}catch (PDOException $e){
    die("Connection Fail:
    " . $e->getMessage());
}  
?>