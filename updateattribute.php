<?php
/*
 * Script to update attribute record.
 * Takes json object with full update of record
 */

include_once('config.php');
include_once('dbutils.php');
//Collect data from FORM
 $data = json_decode(file_get_contents('php://input'), true);
 $attribute_id= $data['id'];
 $attribute_value = $data['value'];
 //$data= $data[$index]
 //for each i>0; i< amount of data; i++ 
 // nTuple that goes through data and gets what needs to be updated
 
 //Juan Pablo notes
//session id of list id and template id
//session_start();
//$session_list_id = $_SESSION['listid'];

//Connect to the database
$db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);

//Get attributes refer to the template
$query =  "update attribute set value = '$attribute_value' WHERE id=$attribute_id";
    
    //Run the statement
    $result = queryDB($query, $db);

    $response = array();
    $response['status'] = 'success';
    header('Content-Type: application/json');
    echo(json_encode($response));

?>
