<?php
/*
 * Script to update list.sql record
 * takes json object with full update of record
 */

include_once('config.php');
include_once('dbutils.php');

//Session id of list_id and template_id
session_start();
$session_list_id = $_SESSION['listid'];
$session_template_id = $_SESSION['template_id'];

//Connect to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

//Select attributes - to the template
$query = "SELECT * FROM template_attribute WHERE template_id = $session_template_id";

//JSON object
$data = json_decode(file_get_contents('php://input'), true);


$isComplete = true;

$errorMessage = "";

//Check if variables are correct 
if (!isset($session_list_id)) {
		//If no id was passed (FAIL)
		//Stop execution if the form is not complete
		$errorMessage .= "no id was sent.  ";
		$isComplete = false;
} else {
		//Check if id is in the table
		$query = "SELECT * FROM list WHERE id=$session_list_id";
	
		//Run query
		$result = queryDB($query, $db);
	
		if (nTuples($result) == 0) {
			$errorMessage .= "the id, $session_list_id, does not match any ids in the table  ";
			$isComplete = false;
		}
}


//If complete       
if($isComplete) {
    
    //Run insert statement
    $result = queryDB($query, $db);
    
    //Send response back
    $response = array();
    $response['status'] = 'success';
    $response['id'] = $session_list_id;
    header('Content-Type: application/json');
    echo(json_encode($response));
        
} else {
    ob_start();
    var_dump($data);
    $postdump = ob_get_clean();

    $response = array();
    $response['status'] = 'error';
    $response['message'] = $errorMessage . $postdump;
    header('Content-Type: application/json');
    echo(json_encode($response));
}

?>