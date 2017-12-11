<?php
    include_once('config.php');
    include_once('dbutils.php');
    
    //Collects data from the Form 
    $data = json_decode(file_get_contents('php://input'), true);
    $username = $data['username'];
	$password = $data['password'];
    
   //Connect to the database
    $db = connectDB($DBHost, $DBUser, $DBPassword, $DBName);    
    
    //Check for required fields
    $isComplete = true;
    $errorMessage = "";
    
    if (!isset($username)) {
        $errorMessage .= " Please enter a username.";
        $isComplete = false;
    } else {
        $username = makeStringSafe($db, $username);
    }

    if (!isset($password)) {
        $errorMessage .= " Please enter a password.";
        $isComplete = false;
    }	    
	
    if ($isComplete) {   
    
        //Hashed password from the user with the email that got entered
        $query = "SELECT id, hashedpass FROM account WHERE username='$username';";
        $result = queryDB($query, $db);
        
        if (nTuples($result) == 0) {
            //Error if username doesn't exist 
            $errorMessage .= " Username $username does not correspond to any account in the system. ";
            $isComplete = false;
        }
    }
    
	//If account matches email that the user entered, get the hashed password for that account
    if ($isComplete) {            
		$row = nextTuple($result);
		$hashedpass = $row['hashedpass'];
		$id = $row['id'];
		
		//Compare entered password to the password on the database
		if ($hashedpass != crypt($password, $hashedpass)) {
            // if password is incorrect
            $errorMessage .= " The password you enterered is incorrect. ";
            $isComplete = false;
        }
    }
     
	//If correct start a session    
    if ($isComplete) {   
        
        session_start();
        $_SESSION['username'] = $username;
		$_SESSION['account_id'] = $id;
        
        //Send response back
        $response = array();
        $response['status'] = 'success';
		$response['message'] = 'logged in';
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