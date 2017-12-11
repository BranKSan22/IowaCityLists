<?php
/*
 * Script to update list record.
 * Takes json object with full update of record
 */

include_once('config.php');
include_once('dbutils.php');

//Session id of list id and template id
session_start();
$session_list_id = $_SESSION['listid'];
$session_template_id = $_SESSION['template_id'];

// Connect to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName)

//Get attributes refer to the template
$query = "SELECT * FROM template_attribute WHERE template_id = $session_template_id";

//Collect data from FORM
$data = json_decode(file_get_contents('php://input'), true);

//Form completion
$isComplete = true;

//Error message
$errorMessage = "";

if (!isset($session_list_id)) {
		//If no id was passed (FAIL)
		$errorMessage .= "no id was sent.  ";
		$isComplete = false;
} else {
		//Check if id is in table
		$query = "SELECT * FROM list WHERE id=$session_list_id";
	
		//Run the query
		$result = queryDB($query, $db);
	
		if (nTuples($result) == 0) {
			$errorMessage .= "the id, $session_list_id, does not match any ids in the table  ";
			$isComplete = false;
		}
}


// Stop if error
if($isComplete) {
 
    //Run the insert statement
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

