<?php
/*
 * Creates list. Gets list id in json object.
*/
include_once('config.php');
include_once('dbutils.php');

//Collect data from the FORM
$data = json_decode(file_get_contents('php://input'), true);
$name = $data['name'];
$temp_id = $data ['template_id'];
//TIMESTAMP created so that each list, if newer, becomes the first list within the list of LISTS
$timeTable = $data['timeTable'];

//Session start for account id, making sure it is speciic user
session_start();
$account_id = $_SESSION['account_id'];


//Connect to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);


//IsComplete to set boundaries for form completion 
$isComplete = true;

//Error message in case an issue arises with the data
$errorMessage = "";


//Go through data in table
//Stop if FORM not complete 
if (!isset($name) || (strlen($name) == 0)) {
    $errorMessage .= "Please enter a name.\n";
    $isComplete = false;
}

if (!isset($temp_id)) {
    $errorMessage .= "Please select a template.\n";
    $isComplete = false;
}

//If complete permit video 
if($isComplete) {
            
            
    $video = makeStringSafe($db, $name);
    
    
    //Enter record into list table and insert new record  
    $query = "INSERT INTO list(name, template_id, account_id, timeTable) VALUES ('$name', $temp_id, $account_id, NOT NULL);";
    
    //Run statement in DB
    $result = queryDB($query, $db);
    
    
    //Get id for list we just entered
    session_start();
    $_SESSION['listid'] = mysqli_insert_id($db);
    $_SESSION['template_id'] = $temp_id;
    
    // send response back
    $response = array();
    $response['status'] = 'success';
    $response['id'] = $listid;
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