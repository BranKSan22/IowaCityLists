<?php
    /*
     * Takes an attribute and returns a session variable's corresponding value
     */
    
    $isComplete = true;
    $errorMessage = "";
    
    //Not logged in
    session_start();
    if (!isset($_SESSION['username'])) {
        
        
        $isComplete = false;
        $errorMessage .= " You are not logged in and cannot get a session variable. ";
    }
    
    //Logged in
    if ($isComplete) {
        
        //Form data
        $data = json_decode(file_get_contents('php://input'), true);
        $attribute = $data['attribute'];
        
        if (!isset($attribute)) {
            $isComplete = false;
            $errorMessage .= " You need to submit a valid attribute. ";
        } else if (!isset($_SESSION[$attribute])) {
            $isComplete = false;
            $errorMessage .= " The session variable $attribute is not set. ";
        }
    }
    
    if ($isComplete) {
        //Set session variable when correct
        $value = $_SESSION[$attribute];
        
         //Send response back
        $response = array();
        $response['status'] = 'success';
        $response['value'] = $value;
        header('Content-Type: application/json');
        echo(json_encode($response));
    } else {
        //Send response error
        $response = array();
        $response['status'] = 'error';
        $response['message'] = $errorMessage;
        header('Content-Type: application/json');
        echo(json_encode($response));   
    }
?>