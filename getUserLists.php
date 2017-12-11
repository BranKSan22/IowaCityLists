<?php
    include_once('config.php');
    include_once('dbutils.php');
    
    //Connect to the database
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);
	
	    //Session for account id
		session_start();
		$session_account_id = $_SESSION['account_id'];
		
    //Query to get the list of lists
    $query = "SELECT * FROM list WHERE account_id=$session_account_id";
    
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