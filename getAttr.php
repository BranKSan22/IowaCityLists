<?php
		
    include_once('config.php');
    include_once('dbutils.php');
    		
    //Connect to the database
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);
    	
	   //$Session_temp_id to grab data pertaining to template attributes shown on editlist
		session_start();
		$session_temp_id = $_SESSION['template_id'];
	
	//Query that gets data from template_attribute --- template_id 
    $query = "SELECT * FROM template_attribute WHERE template_id=$session_temp_id order by ordernumber";
    
    //Run the query
    $result = queryDB($query, $db);
    
    //Results given for array
    $rows = array();
    while ($row = nextTuple($result)) {
        $rows[] = $row;
    }
    
    //JSON send back 
	$response = array();
    $response['status'] = 'success';
    $response['value'] = $rows;
    header('Content-Type: application/json');
    echo(json_encode($response));
?>