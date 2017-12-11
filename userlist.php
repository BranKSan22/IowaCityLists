<?php

include_once('config.php');
include_once('dbutils.php');

// session id of list id and template id
session_start();
$session_list_id = $_SESSION['list'];
$session_id= $_SESSION['account_id']


// connect to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

// get the list id for all the users list
$query= "SELECT * FROM list where account_id =$session_id";

// run the query
    $result = queryDB($query, $db);
    
?>