<?php
    /*
     * Takes attribute/value pair and sets it as session variable if logged in
     */
    
    $isComplete = true;
    $errorMessage = "";

    //Not Logged In
    session_start();
    if (!isset($_SESSION['username'])) {
    
        
        $isComplete = false;
        $errorMessage .= " You are not logged in and cannot set a session variable. ";
    }
    
    //Logged in
    if ($isComplete) {
        
        
        //Collect data from FORM
        $data = json_decode(file_get_contents('php://input'), true);
        $attribute = $data['attribute'];
        $value = $data['value'];
        
        if (!isset($attribute) || $attribute == 'username') {
            $isComplete = false;
            $errorMessage .= " You need to submit a valid attribute. ";
        }
        
        if (!isset($value)) {
            $isComplete = false;
            $errorMessage .= " You need to submit a value. ";
        }
    }
    
    //If correct 
    if ($isComplete) {
    
        $_SESSION[$attribute] = $value;
        
         //Send response back
        $response = array();
        $response['status'] = 'success';
        header('Content-Type: application/json');
        echo(json_encode($response));
    } else {
        //Send response for error
        $response = array();
        $response['status'] = 'error';
        $response['message'] = $errorMessage;
        header('Content-Type: application/json');
        echo(json_encode($response));   
    }
?>