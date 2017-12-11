<?php
    include_once('config.php');
    include_once('dbutils.php');
    		
    //Connect to the database
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);
    		
    //Query to collect template table data
    $query = "SELECT * FROM template";
    
    //Run the query
    $result = queryDB($query, $db);
    
    //Results for array
    $rows = array();
    while ($row = nextTuple($result)) {
        $rows[] = $row;
    }
    
    //JSON send back
    header('Content-Type: application/json');			
    echo(json_encode($rows));
?>