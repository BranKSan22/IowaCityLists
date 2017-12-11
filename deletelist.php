<?php
/*
 * Deletes list. Gets list id in json object.
*/
include_once('config.php');
include_once('dbutils.php');

$data = json_decode(file_get_contents('php://input'), true);
$session_list_id = $data['id'];

$isComplete = true;

$errorMessage = "";

//Connect to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

if (!isset($session_list_id)) {
    // If no id was passed (FAIL)
    $errorMessage .= "No id was sent.  ";
    $isComplete = false;
} else {
    // Check if the id is in the table
    $query = "SELECT * FROM list WHERE id=$session_list_id";
    
    //Run the query
    $result = queryDB($query, $db);
    
    if(nTuples($result) == 0) {
        $errorMessage .= "The id provided, $session_list_id does not match any ids of lists in the table.  ";
        $isComplete = false;
    }
}

if ($isComplete) {
    //Delete the record
    $query = "DELETE FROM list WHERE id=$session_list_id";
    
    //Run the delete statement
    queryDB($query, $db);
    
    // send response back
    $response = array();
    $response['status'] = 'success';
    $response['id'] =  $session_list_id;
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